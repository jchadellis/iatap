<?php 

namespace App\Cells\SideCards;

use CodeIgniter\View\Cells\Cell;

class WeatherCell extends Cell
{
    //public $breadcrumbs = []; 

    public function render():string
    {
        $session = session();
        return ''; 
        if(!$session->has('weather'))
        {
           
            $client = \Config\Services::curlrequest(); 

            $url = 'https://api.weather.gov/gridpoints/BMX/87,89/forecast'; 
            try{
                    $response = $client->request('GET', $url, [
                        'debug' => true, 
                        'http_errors' => false,
                        'headers' => [
                            'User-Agent'    => 'test/1.0',
                            'Accept'        => 'application/json'
                        ]
                    ]);  
    
                    if( $response->getStatusCode() !== 200){
                        throw new \Exception('Request Failed with status:"'. $response->getStatusCode()); 
                    }

                    $jsonReponse = json_decode($response->getBody(), true) ; 
                    $session->setTempdata('weather', $jsonReponse['properties']['periods'][0], 1200);

    
            }  catch (\Exception $e ){
                    return $this->view('weather_fail');
            }
        }

        return $this->view('weather', ['weather' => $_SESSION['weather']]);  
    }  

}