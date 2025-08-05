<?php

namespace App\Models;

use CodeIgniter\Model;

class SqlbaseModel extends Model
{
    public function getData($url,$raw = false)
    {

        $client = \Config\Services::curlrequest(); 
        $response = $client->get($url);

        if($raw)
        {
            return $response->getBody(); 
        }

        if($response->getStatusCode() === 200){
            $result = json_decode($response->getBody(), true); 
            $array = [];
            foreach($result as $row)
            {
                $array[] = (object) $row; 
            }
            $result = $array; 

            return $result; 
        }

        return null; 
    }

    public function postData($url, $data)
    {

        $client = service('curlrequest'); 

        $response = $client->post($url, ['form_params' => $data]);

        if( $response->getStatusCode() === 200){
            $result = json_decode($response->getBody(), true);
            return $result; 
        }
        
        return null;  
        
    }
}