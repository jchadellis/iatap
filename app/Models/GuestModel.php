<?php 

namespace App\Models; 

use CodeIgniter\Model; 

class GuestModel
{
    private $groups = ['guest'];
    protected $first_name = "Guest"; 
    protected $last_name = ''; 


    public function inGroup(string $group = '')
    {
        return (in_array($group, $this->groups)) ? true : false ; 
    }

    public function isGuest()
    {
        return true; 
    }
}