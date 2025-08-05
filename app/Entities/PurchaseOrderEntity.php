<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PurchaseOrderEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];



    public function getTruePromise()
    {
        $value = new \DateTime( $this->attributes['true_promise'] );
        return $value; 
    }


    public function getFollowup25TargetDate()
    {
        $value = new \DateTime( $this->attributes['followup_25_target_date'] );
        return $value; 
    }
    public function getFollowup50TargetDate()
    {
        $value = new \DateTime( $this->attributes['followup_50_target_date'] );
        return $value; 
    }

    public function getFollowup90TargetDate()
    {
        $value = new \DateTime( $this->attributes['followup_90_target_date'] );
        return $value; 
    }

    public function getNextVendorUpdateAt()
    {

        $value = ( !empty($this->attributes['next_vendor_update_at']) ) ? (new \DateTime($this->attributes['next_vendor_update_at']))->format('m-d-Y') : '' ;
        return $value; 
    }

    public function getLastVendorUpdateAt()
    {

        $promise = (new \DateTime($this->attributes['true_promise']))->format('Y-m-d'); 
        $today = (new \DateTime())->format('Y-m-d'); 

        if( $promise == $today )
        {
            return ''; 
        }elseif($promise <  $today )
        {
            return ''; 
        }elseif( !$this->attributes['last_vendor_update_at'] )
        {
            return ''; 
        }
        
        $value = new \DateTime( $this->attributes['last_vendor_update_at'] );
        return $value->format('m-d-Y'); 
    }
    

}
