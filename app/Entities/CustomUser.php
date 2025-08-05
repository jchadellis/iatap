<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;
use App\Models\BuildingModel;
use App\Models\NetAssetsModel;
use App\Models\LoginsModel; 
use App\Models\DeptModel; 
use App\Models\Host; 
use App\Models\PwdTypesModel;

class CustomUser extends ShieldUser
{
    public function getBldgName()
    {
        if (empty($this->attributes['bldg_id'])) {
            return null;
        }

        $buildingModel = new BuildingModel();
        $building = $buildingModel->find($this->attributes['bldg_id']);

        return $building ? $building->name : null;
    }

    public function getDeptName()
    {
        if (empty($this->attributes['dept_id'])) {
            return null;
        }

        $departmentModel = new DeptModel();
        $department = $departmentModel->find($this->attributes['dept_id']);

        return $department ? $department->name : null;
    }

    public function getHost()
    {
        if (empty($this->attributes['host_id'])) {
            return null;
        }

        $hostModel = new NetAssetsModel();
        $host = $hostModel->find($this->attributes['host_id']);

        return $host ? $host : null;
    }

    public function getLogins()
    {
        $LoginModel = new LoginsModel(); 
        $PwdTypesModel = new PwdTypesModel();
        $pwd_types = $PwdTypesModel->findAll();  
        $logins = $LoginModel->where('user_id', $this->attributes['id'])->findAll(); 

        foreach($logins as $login)
        {
            foreach($pwd_types as $type )
            {
                if( $login->type_id == $type->id )
                {
                    $login->type = $type->name; 
                }
            }
        }


        return $logins ? $logins : []; 
    }

    public function getDirty()
    {
       $dirty = [];

        foreach ($this->toRawArray() as $key => $val) {
            if ($this->hasChanged($key)) {
                $dirty[$key] = $val;
            }
        } 

        return $dirty; 
    }


    public function getStreet()
    {
        return ucwords(strtolower($this->attributes['street'])); 
    }

    public function setStreet($value)
    {
        return ucwords(strtolower($value)); 
    }

    public function getCity()
    {
        return ucwords( strtolower( $this->attributes['city'] ) );
    }

    public function setCity($value)
    {
        return ucwords(strtolower($value)); 
    }


}
