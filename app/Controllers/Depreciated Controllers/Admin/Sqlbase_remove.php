<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Sqlbase extends BaseController
{
    public function getPaintReport()
    {
        $url = 'http://vatap/mvc/public/api/getPaintReport'; 

        $ch = curl_init($url); 

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json'
        ]);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if(curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
            exit;
        }

        // Close cURL
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true); // Use true for associative array, false for object

        // Accessing the data
        echo "<pre>";
        print_r($data);
        echo "</pre>";

    }
}