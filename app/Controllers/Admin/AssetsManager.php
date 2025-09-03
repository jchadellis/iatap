<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController; 
use App\Models\NetAssetsModel; 
use App\Models\UserModel;
use App\Libraries\Forms\AssetsList; 

class AssetsManager extends BaseController
{
    private UserModel $userModel;
    private NetAssetsModel $assetsModel;  
    private array $host_types; 
    private array $dept_types;
    private array $switches; 

    public function __construct()
    {
        $db = db_connect(); 
        $this->assetsModel = new NetAssetsModel();  
        $this->dept_types              = $db->table('tbl_depts')->orderBy('name', 'ASC')->get()->getResult(); 
        $this->host_types               = $db->table('tbl_net_asset_types')->orderBy('name', 'ASC')->get()->getResult();
        $this->switches                 = $db->table('tbl_net_assets')->where('type_id', '8')->orWhere('type_id', '9')->get()->getResult(); 
    }

    public function index($id = null): string
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
            ['name' => 'Assets', 'is_active' => true, 'url' => ''],
        ];

        $data = [
            'title' => 'Assets Manager', 
            'breadcrumbs' => $breadcrumbs, 
            'assets' => $this->assetsModel->orderBy('ip_address')->findAll(), 
            'js' => view('admin/assets/index.js.php'),
            'host_types' => $this->host_types,
            'depts' => $this->dept_types, 
            'switches' => $this->switches,
        ];

        $data['content']  = view('admin/assets/index', $data); 
        return view('template/index', $data); 
    }

    public function print()
    {
        $assets = $this->assetsModel->orderBy('ip_address ASC, type_id DESC')->findAll();
        $pdf = new AssetsList(); 
        $outputFile = 'network_assets_list_' . date('mdY') . '.pdf';

        // Generate the PDF using the provided data
        $pdf->print($outputFile, $assets);
            // Return the PDF file as a new Browser Window. 
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $outputFile . '"')
            ->setBody(file_get_contents(WRITEPATH . 'uploads/assets/' . $outputFile));
    }

    public function print_details()
    {
        $assets  = $this->assetModel->orderBy('ip_address ASC')->where("ip_address BETWEEN '192.168.0.1' AND '192.168.0.254'")->findAll(); 

        $pdf = new AssetsList(); 

        $outputFile = 'network_assets_details_' . date('mdY') . '.pdf';

        $pdf->print_details($outputFile, $assets);

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $outputFile . '"')
            ->setBody(file_get_contents(WRITEPATH . 'uploads/assets/' . $outputFile));
    }

}
