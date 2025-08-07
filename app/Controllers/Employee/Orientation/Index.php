<?php 

namespace App\Controllers\Employee\Orientation;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{
    private $cards = [
        [
            'title' => 'Drug and Alcohol', 
            'text' => 'Some quick example text to build on the card title.',
            'btn-url'   => 'orientation/video/playback/1',
            'btn-text'  => 'Play Video', 
            'card-thumb' => 'assets/video/drug-and-alcohol.webm', 
        ],
        [
            'title' => 'Safety Orientation', 
            'text' => 'Some quick example text to build on the card title.',
            'btn-url'   => 'orientation/video/playback/2',
            'btn-text'  => 'Play Video', 
            'card-thumb' => 'assets/video/walking-working-surfaces-supervisor.jpg', 
        ],
        [
            'title' => 'Walking / Working</br>Surfaces Supervisor', 
            'text' => 'Some quick example text to build on the card title.',
            'btn-url'   => 'orientation/video/playback/3',
            'btn-text'  => 'Play Video', 
            'card-thumb' => 'assets/video/walking-working-surfaces-supervisor.jpg', 
        ],
        [
            'title' => 'Export Control Awareness', 
            'text' => 'Some quick example text to build on the card title.',
            'btn-url'   => 'orientation/video/playback/4',
            'btn-text'  => 'Play Video', 
            'card-thumb' => 'assets/video/walking-working-surfaces-supervisor.jpg', 
        ],
        // [
        //     'title' => 'Walking / Working</br>Surfaces Supervisor', 
        //     'text' => 'Some quick example text to build on the card title.',
        //     'btn-url'   => 'orientation/video/playback/5',
        //     'btn-text'  => 'Play Video', 
        //     'card-thumb' => 'assets/video/walking-working-surfaces-supervisor.jpg', 
        // ]
    ];

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Orientation', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Orientation', 
            'content' => view('employee/orientation/index', ['cards' => $this->cards ]),
            'js' => view('employee/orientation/index.js.php'), 
        ];

        return view('template/index', $data); 
    }
}