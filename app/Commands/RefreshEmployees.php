<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\EmployeeModel;
use App\Models\UserModel; 

class RefreshEmployees extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'refresh:employees';
    protected $description = 'Sync employees from external database and update only new/changed entries';

    public function run(array $params)
    {
        CLI::write('Starting employee synchronization...', 'green');
        
        try {
            $this->syncEmployees();
            CLI::write('Employee synchronization completed successfully!', 'green');
        } catch (\Exception $e) {
            CLI::write('Error during employee synchronization: ' . $e->getMessage(), 'red');
            return;
        }
    }

    private function sanitizeToInteger($value) {
        if (empty($value)) {
            return 0;
        }
        
        $value = trim($value);
        
        // Handle mixed numbers
        if (preg_match('/^(\d+)\s+(\d+)\/(\d+)$/', $value, $matches)) {
            $whole = (int)$matches[1];
            $numerator = (int)$matches[2];
            $denominator = (int)$matches[3];
            return (int)round($whole + ($numerator / $denominator));
        }
        
        // Handle simple fractions
        if (preg_match('/^(\d+)\/(\d+)$/', $value, $matches)) {
            $numerator = (int)$matches[1];
            $denominator = (int)$matches[2];
            return (int)round($numerator / $denominator);
        }
        
        // Handle decimals
        return (int)round((float)$value);
    }


    private function syncEmployees()
    {
        CLI::write('Fetching employees from external source...', 'yellow');
        
        $employees = new \App\Controllers\Employee\Index;
        $employeeList = $employees->list();
        $employeeModel = new EmployeeModel();
        $userModel = new UserModel(); 
       
        //unset($employeeList[0]); // Remove first element as in original code
        
        $newCount = 0;
        $updatedCount = 0;
        $deletedCount = 0;
        $errorCount = 0;
        
        foreach ($employeeList as $employee) {
            try {
                $phoneNumber = $employee->phone;
                $empData = [
                    'employee_id' => $employee->id,
                    'first_name' => ucwords(strtolower($employee->first_name)),
                    'last_name' => ucwords(strtolower($employee->last_name)),
                    'middle_initial' => $employee->middle_initial,
                    'addr_1' => ucwords(strtolower($employee->address_1)),
                    'addr_2' => ucwords(strtolower($employee->address_2)),
                    'addr_3' => ucwords(strtolower($employee->address_3)),
                    'city' => ucwords(strtolower($employee->city)),
                    'state' => ucwords(strtolower($employee->state)),
                    'zipcode' => $employee->zip_1,
                    'phone' => sprintf("%s-%s-%s", substr($phoneNumber, 0, 3), substr($phoneNumber, 3, 3), substr($phoneNumber, 6, 4)),
                    'department_id' => ($employee->dept_id != 'NDLA') ? $employee->dept_id : 0,
                    'birth_date' => $employee->birth_date, 
                    'hire_date' => $employee->hire_date, 
                    'vac_days' => $this->sanitizeToInteger($employee->udf_string_1), 
                    'free_days' => $this->sanitizeToInteger($employee->udf_number), 
                    'last_visual_updated_at' => (new \DateTime($employee->date_updated))->format('Y-m-d h:i:s'), 
                    'work_email' => filter_var($employee->udf_string_2, FILTER_VALIDATE_EMAIL) ? $employee->udf_string_2 : null,
                    'group' => $employee->emp_proc_group_id,
                ];
                                
                // Store active status separately since it's not a database field
                $isActive = $employee->pay_status;
                
                // Check if employee exists (including soft deleted ones)
                $existingEmployee = (array) $employeeModel->withDeleted()->where('employee_id', $employee->id)->first();


                if ($existingEmployee) {
                    // Employee exists, check if data has changed
                    $hasChanged = false;
                    foreach ($empData as $key => $value) {
                        if ($existingEmployee[$key] != $value) {
                            $hasChanged = true;
                            break;
                        }
                    }
                    
                    if ($hasChanged) {
                        $empData['id'] = $existingEmployee['id'];
                        $employeeModel->save($empData);
                        $updatedCount++;
                        CLI::write("Updated employee: {$employee->first_name} {$employee->last_name}", 'cyan');
                    }
                    
                    // Handle active/inactive status using soft deletes
                    if ($isActive != 'A' && $existingEmployee['deleted_at'] === null) {
                        // Employee became inactive, soft delete
                        $employeeModel->delete($existingEmployee['id']);
                        $deletedCount++;
                        CLI::write("Soft deleted inactive employee: {$employee->first_name} {$employee->last_name}", 'yellow');
                    } elseif ($isActive == 'A' && $existingEmployee['deleted_at'] !== null) {
                        // Employee became active again, restore
                        $employeeModel->update($existingEmployee['id'], ['deleted_at' => null]);
                        CLI::write("Restored employee: {$employee->first_name} {$employee->last_name}", 'green');
                    }
                } else {
                    // New employee - only add if they don't exist
                    if ($isActive != 'A') {
                        // New employee is inactive, add with deleted_at timestamp
                        $empData['deleted_at'] = date('Y-m-d H:i:s');
                        $deletedCount++;
                        CLI::write("Added new inactive employee (soft deleted): {$employee->first_name} {$employee->last_name}", 'yellow');
                    } else {
                        // New active employee
                        CLI::write("Added new employee: {$employee->first_name} {$employee->last_name}", 'cyan');
                    }
                    
                    $employeeModel->save($empData);
                    $newCount++;
                }
                
            } catch (\Exception $e) {
                $errorCount++;
                CLI::write("Error processing employee {$employee->first_name} {$employee->last_name}: " . $e->getMessage(), 'red');
                continue;
            }
        }
        
        CLI::write("Summary:", 'green');
        CLI::write("- New employees: {$newCount}", 'white');
        CLI::write("- Updated employees: {$updatedCount}", 'white');
        CLI::write("- Soft deleted employees: {$deletedCount}", 'white');
        CLI::write("- Errors: {$errorCount}", 'white');
    }
}