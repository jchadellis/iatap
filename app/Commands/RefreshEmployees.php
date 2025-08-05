<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\EmployeeModel;

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

    private function syncEmployees()
    {
        CLI::write('Fetching employees from external source...', 'yellow');
        
        $employees = new \App\Controllers\Employee\Index;
        $employeeList = $employees->list();
        $employeeModel = new EmployeeModel();
        
        unset($employeeList[0]); // Remove first element as in original code
        
        $newCount = 0;
        $updatedCount = 0;
        $deletedCount = 0;
        $errorCount = 0;
        
        foreach ($employeeList as $employee) {
            try {
                $empData = [
                    'employee_id' => $employee->id,
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name,
                    'middle_initial' => $employee->middle_initial,
                    'addr_1' => $employee->addr_1,
                    'addr_2' => $employee->addr_2,
                    'addr_3' => $employee->addr_3,
                    'city' => $employee->city,
                    'state' => $employee->state,
                    'zipcode' => $employee->zipcode,
                    'phone' => $employee->phone,
                    'department_id' => ($employee->department_id != 'NDLA') ? $employee->department_id : 0,
                ];
                
                // Store active status separately since it's not a database field
                $isActive = $employee->active;
                
                // Check if employee exists (including soft deleted ones)
                $existingEmployee = $employeeModel->withDeleted()->where('employee_id', $employee->id)->first();

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
                    if ($isActive != 'Y' && $existingEmployee['deleted_at'] === null) {
                        // Employee became inactive, soft delete
                        $employeeModel->delete($existingEmployee['id']);
                        $deletedCount++;
                        CLI::write("Soft deleted inactive employee: {$employee->first_name} {$employee->last_name}", 'yellow');
                    } elseif ($isActive == 'Y' && $existingEmployee['deleted_at'] !== null) {
                        // Employee became active again, restore
                        $employeeModel->update($existingEmployee['id'], ['deleted_at' => null]);
                        CLI::write("Restored employee: {$employee->first_name} {$employee->last_name}", 'green');
                    }
                } else {
                    // New employee - only add if they don't exist
                    if ($isActive != 'Y') {
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