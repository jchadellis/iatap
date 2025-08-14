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
            'btn-url'   => 'orientation/playback/0',
            'btn-text'  => 'Play Video', 
            'card-thumb' => 'assets/video/drug-and-alcohol.jpg', 
        ],
        [
            'title' => 'Safety Orientation', 
            'text' => 'Some quick example text to build on the card title.',
            'btn-url'   => 'orientation/playback/1',
            'btn-text'  => 'Play Video', 
            'card-thumb' => 'assets/video/safety-orientation.jpg', 
        ],
        [
            'title' => 'Walking / Working</br>Surfaces Employees', 
            'text' => 'Some quick example text to build on the card title.',
            'btn-url'   => 'orientation/playback/2',
            'btn-text'  => 'Play Video', 
            'card-thumb' => 'assets/video/walking-working-surfaces-employees.jpg', 
        ],
        [
            'title' => 'Export Control Awareness', 
            'text' => 'Some quick example text to build on the card title.',
            'btn-url'   => 'orientation/playback/3',
            'btn-text'  => 'Play Video', 
            'card-thumb' => 'assets/video/export-control-awareness.jpg', 
        ],
    ];

    private $videos = [
        [
            'title' => 'Drug and Alcohol', 
            'url' => 'assets/video/drug-and-alcohol.webm',
        ],
        [
            'title' => 'Safety Orientation', 
            'url' => 'assets/video/safety-orientation.webm',
        ],
        [
            'title' => 'Walking Working Surfaces', 
            'url' => 'assets/video/walking-working-surfaces-employees.webm',
        ],
        [
            'title' => 'Export Control Awareness', 
            'url' => 'assets/video/export-control-awareness.webm',
        ],

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

    public function playback($id)
    {
        $video = $this->videos[$id];
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Orientation', 'is_active' => false, 'url' => 'orientation'],
                ['name' => "{$video['title']}", 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Orientation', 
            'content' => view('employee/orientation/playback', ['data' => $video]),
            'js' =>'', 
        ];

        return view('template/index', $data); 
    }
}