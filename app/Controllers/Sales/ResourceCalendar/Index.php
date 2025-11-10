<?php 

namespace App\Controllers\Sales\ResourceCalendar;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ResourceCalendarModel; 
use App\Models\UserModel; 

class Index extends BaseController
{

    private $colors; 

    public function __construct()
    {
        $this->colors = [
            '1' => '#FF8C00', 
            '2' => '#008B8B',
            '3' => '#8A2BE2',
        ]; 
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => false, 'url' => 'sales'],
				['name' => 'Conf. Rm Calendar', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Resource Calendar', 
            'content' => view('sales/resourcecalendar/index',[]),
            'js' => view('sales/resourcecalendar/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {

    }

    public function get_events($date = null)
    {

        $model = new ResourceCalendarModel();  
        $user_model = new UserModel();  

        $date = $date ? $date : (new \DateTime())->format('Y-m-d'); 

        $events = $model->where("date", $date)->findAll(); 

        foreach ($events as $e) {
            $user = $user_model->find($e->user_id); 
            $e->user_name = $user ? $user->first_name . ' '. $user->last_name : '';
            $e->date = (new \DateTime($e->date))->format('Y-m-d');
            $e->start = (new \DateTime($e->date))->modify($e->start)->format('g:i A');
            $e->end = (new \DateTime($e->date))->modify($e->end)->format('g:i A');
        }

        return $this->response->setJSON(
            [
                'data' =>  $events,
                'success' => true,
            ]
        );
    }

    public function save_event(){
        $model = new ResourceCalendarModel(); 
        $json = $this->request->getJSON();

        $user = auth()->user();

        $id = $json->id ?? null;

        $start_time = (new \DateTime($json->date))->modify($json->start)->format('Y-m-d H:i:s');
        $start_plus_30 = ( new \DateTime($start_time))->modify('+ 30 mins')->format('Y-m-d H:i:s'); 
        $end_time = (new \DateTime($json->date))->modify($json->end)->format('Y-m-d H:i:s'); 

        $data = [
            'resource' => $json->resource,
            'title'     => $json->title,
            'details'  => $json->details,
            'date'     => (new \DateTime($json->date))->format('Y-m-d'),
            'start'    => (new \DateTime($json->date))->modify($json->start)->format('Y-m-d H:i:s'),
            'end'      => (new \DateTime($json->date))->modify($json->end)->format('Y-m-d H:i:s'),
            'user_id'  => $user->id,
            'is_same_cell' => $start_plus_30 === $end_time, 
            'start_cell_id' => $json->start_cell_id, 
            'end_cell_id' => $json->end_cell_id, 
        ];

        if ($id) {
            // Explicit UPDATE
            if ($model->update($id, $data)) {
                $data['id'] = $id;
            }
        } else {
            // Explicit INSERT
            if ($model->insert($data)) {
                $data['id'] = $model->getInsertID();
            }
        }

        $event = $model->find($data['id']); 

        $event->start = (new \DateTime($event->start))->format('g:i A');
        $event->end = (new \DateTime($event->end))->format('g:i A');

        return $this->response->setJSON([
            'success' => true, 
            'data' => $event,
        ]);
    }

    public function delete_event(){
        $model = new ResourceCalendarModel(); 
        $json = $this->request->getJSON(); 

        $array = [
            'id' => $json->id,
        ];
        $model->delete($array); 

        return $this->response->setJSON([
            'data' => $json,
            'success'=> true, 
        ]);
    }

    public function update_event()
    {
        $model = new ResourceCalendarModel(); 
        $json = $this->request->getJSON();

        $start = $json->start ?? date('Y-m-d H:i:s'); 
        $end =  $json->end ?? date('Y-m-d H:i:s'); 
        $id = $json->id ?? null; 
        $resource = $json->resource ?? 1; 
        $text = $json->text ?? 'New Event'; 

        $start = (new \DateTime($start))->format('Y-m-d H:i:s');
        $end = (new \DateTime($end))->format('Y-m-d H:i:s'); 
        $user = auth()->user(); 

        $array = [
            'id' => (int) $id,
            'resource' => (int) $resource ?? '', 
            'user_id' => $user->id ?? '' , 
            'text' => $text,
            'barColor' => $this->colors[$resource],
            'start' => $start, 
            'end' => $end, 
        ];

        if( $model->save($array) )
        {   
            return $this->response->setJSON([
                'success' => true, 
                'data' => $array, 
                'icon' => 'success', 
                'title' => 'Saved', 
                'html' => "<p>Your request was succesfully made.</p>",                
            ]);
        } 
    }

    public function add_event()
    {
        $model = new ResourceCalendarModel(); 
        $post = $this->request->getPost(); 

        $start = $post['start'] ?? date('Y-m-d H:i:s'); 
        $end = $post['end'] ?? date('Y-m-d H:i:s'); 
        $id = $post['id'] ?? 1;  
        $resource = $post['resource'] ?? 1; 
        $text = $post['text'] ?? 'New Event'; 

        $start = (new \DateTime($start))->format('Y-m-d H:i:s');
        $end = (new \DateTime($end))->format('Y-m-d H:i:s'); 
        $user = auth()->user(); 

        $array = [
            'resource' => (int) $resource ?? '', 
            'user_id' => $user->id ?? '' , 
            'text' => $text,
            'barColor' => $this->colors[$resource],
            'start' => $start, 
            'end' => $end, 
        ];

        if( $model->save($array) )
        {   
            return $this->response->setJSON([
                'success' => true, 
                'data' => $array, 
                'icon' => 'success', 
                'title' => 'Saved', 
                'html' => "<p>Your request was succesfully made.</p>",                
            ]);
        } 

    }
}