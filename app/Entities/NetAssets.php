<?php

namespace App\Entities;

use App\Entities\CustomEntity;
use App\Models\NetAssetsTypesModel; 
use App\Models\DeptModel; 
use App\Models\NetAssetsModel; 

class NetAssets extends CustomEntity
{
    public function getType()
    {
        if (empty($this->attributes['type_id'])) {
            return null;
        }

        $NetAssetsTypesModel = new NetAssetsTypesModel();
        $type = $NetAssetsTypesModel->find($this->attributes['type_id']);

        return $type ? $type->name : null;
    }
    public function getDepartment()
    {
        if (empty($this->attributes['dept_id'])) {
            return null;
        }

        $model = new DeptModel();
        $dept = $model->find($this->attributes['dept_id']);

        return $dept ? $dept->name : null;
    }

    public function getSwitchName()
    {
        if (empty($this->attributes['switch_id'])) {
            return null;
        }

        $model = new NetAssetsModel();
        $switch = $model->find($this->attributes['switch_id']);

        return $switch ? $switch->display_name : null;    
    }

    public function setNetworkName($network_name)
    {
        $this->attributes['network_name'] = strtoupper($network_name);
        return $this;
    }

    public function setIsActive($is_active)
    {
        $this->attributes['is_active'] = ($is_active === 't') ? true : false; 
        return $this; 
    }
    

}