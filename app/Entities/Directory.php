<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\BuildingModel;
use App\Models\DeptModel; 

class Directory extends Entity
{
   protected function getDepartment()
   {
      if (empty($this->attributes['dept_id'])) {
         return null;
     }

     $departmentModel = new DeptModel();
     $department = $departmentModel->find($this->attributes['dept_id']);

     return $department ? $department->name : null;
   }

   protected function getBuilding()
   {
      if (empty($this->attributes['location_id'])) {
         return null;
      }

      $buildingModel = new BuildingModel();
      $building = $buildingModel->find($this->attributes['location_id']);

      return $building ? $building->name : null;
   }
}