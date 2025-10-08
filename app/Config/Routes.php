<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =============================================================================
// PUBLIC ROUTES (No Authentication Required)
// =============================================================================

// Dashboard Routes
$routes->group('', static function($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');

    $routes->group('cfb-football', static function($routes){
        $routes->get('', 'Games\Index::index'); 
        $routes->get('week/(:num)', 'Games\Week\Index::index/$1'); 
        $routes->get('refresh', 'Games\Index::refresh_cache');
        $routes->get('games', 'Games\Index::get_games'); 
        $routes->get('teams', 'Games\Index::get_teams'); 
        $routes->get('team/(:any)', 'Games\Team\Index::index/$1');
        $routes->get('records/(:any)', 'Games\Index::get_records/$1'); 
        $routes->get('weeks', 'Games\Index::get_weeks'); 
        $routes->get('rankings', 'Games\Index::get_rankings'); 
    });
});

// Directory Routes
$routes->group('directory', static function($routes) {
    $routes->get('/', 'Directory::index');
    $routes->post('search', 'Directory::search');
    $routes->get('weather', 'Directory::weather');
});

$routes->get('legacy', 'Legacy\Index::index'); 

// File Management Routes
$routes->group('', static function($routes) {
    $routes->get('download/(:any)', 'Filemanager\FileController::download/$1');
    $routes->get('file/(:any)', 'Filemanager\Files::get_file/$1/$2');
});

// Form Routes
$routes->get('leave/requestform', 'Forms\LeaveRequest::getPdf');

// Employee Public Routes
$routes->group('employee', static function($routes) {
    $routes->get('resources', 'Employee\Index::index');
    $routes->get('leave/request', 'Employee\Leave::index');
    $routes->get('training', 'Employee\Training\Index::index');
    $routes->get('training/data', 'Employee\Training\Index::get_data');
    $routes->get('training/resources', 'Employee\Training\Index::get_resources');
    $routes->get('list', 'Employee\Index::list');
    $routes->group('email-signature-gen', static function($routes){
        $routes->get('', 'Employee\Email_Signature_Gen\Index::index'); 
    });
});

// Orientation Routes
$routes->group('orientation', static function($routes) {
    $routes->get('', 'Employee\Orientation\Index::index');
    $routes->get('playback/(:num)', 'Employee\Orientation\Index::playback/$1');
});

// =============================================================================
// AUTHENTICATION ROUTES
// =============================================================================
//service('auth')->routes($routes);

service('auth')->routes($routes, ['except' => ['login']]);
$routes->get('login', '\App\Controllers\Auth\LoginController::loginView', ['as' => 'login']);
$routes->post('login', '\App\Controllers\Auth\LoginController::loginAction');

// =============================================================================
// USER PROFILE ROUTES
// =============================================================================
$routes->group('user', static function($routes) {
    $routes->get('profile', 'User\Index::index');
    $routes->get('profile/(:num)', 'User\Index::index/$1');
    $routes->post('get-pto', 'User\Index::get_pto');
    $routes->post('save-signature', 'User\Index::save_signature'); 
});

// =============================================================================
// SUPER ADMIN ROUTES
// =============================================================================
$routes->group('sadmin', ['filter' => 'group:super'], static function($routes) {
    $routes->get('control-panel', 'Admin\Index::index');
    
    $routes->group('user-manager', static function($routes){
        $routes->get('', 'Admin\UserManager\Index::index'); 
        $routes->get('data', 'Admin\UserManager\Index::get_data'); 
        $routes->post('edit', 'Admin\UserManager\Index::get_edit_user');
        $routes->post('new', 'Admin\UserManager\Index::get_new_user');
        $routes->post('save', 'Admin\UserManager\Index::save_user'); 
        $routes->post('add', 'Admin\UserManager\Index::add_user'); 
        $routes->post('remove', 'Admin\UserManager\Index::remove_user'); 
        $routes->post('email', 'Admin\UserManager\Index::email_credentials');
    });

    // User Management
    $routes->group('', static function($routes) {
        $routes->get('user-management', 'Admin\Users::index');
        $routes->get('user/edit/(:num)', 'Admin\Users::edit/$1');
        $routes->post('user/create', 'Admin\Users::create');
        $routes->post('user/update/(:num)', 'Admin\Users::update/$1');
        $routes->get('create-guest', 'Admin\Users::create_guest');
    });

    // Assets Management
    $routes->group('assets-manager', static function($routes) {
        $routes->get('/', 'Admin\AssetsManager::index');
        $routes->get('print', 'Admin\AssetsManager::print');
    });

    $routes->group('assets', static function($routes) {
        $routes->get('print', 'Admin\NetAssets::print');
        $routes->get('print-details', 'Admin\NetAssets::print_details');
    });

    $routes->group('asset', static function($routes) {
        $routes->get('edit/(:num)', 'Admin\Asset\Edit\Index::index/$1');
        $routes->post('update/(:num)', 'Admin\Asset\Edit\Index::save/$1');
        $routes->get('remove-user/(:num)', 'Admin\Asset\Edit\Index::removeUser/$1');
        $routes->post('add-user/(:num)', 'Admin\Asset\Edit\Index::addUser/$1');
        $routes->get('lookup/(:num)', 'Admin\Asset\Edit\Index::lookup/$1');
    });

    // Login Management
    $routes->group('', static function($routes) {
        $routes->post('logins/add/(:num)', 'Admin\Logins::add/$1');
        $routes->get('login/delete/(:num)', 'Admin\Logins::delete/$1');
    });

    $routes->group('login-manager', static function($routes) {
        $routes->get('/', 'Admin\LoginManager::index');
        $routes->get('(:num)', 'Admin\LoginManager::index/$1');
        $routes->post('save', 'Admin\LoginManager::save_data');
        $routes->get('decrypt/(:num)', 'Admin\LoginManager::decrypt/$1');
        $routes->get('edit/(:num)', 'Admin\LoginManager::edit/$1');
    });

    $routes->get('page-logs', 'Admin\PageStats::index');

    $routes->group('backup-manager', static function($routes){
        $routes->get('', 'Admin\BackupManager\Index::index'); 
        $routes->get('download-file/(:any)', 'Admin\BackupManager\Index::download/$1/$2');  
        $routes->get('backup-site', 'Admin\BackupManager\Index::backup_site'); 
        $routes->get('backup-visual', 'Admin\BackupManager\Index::backup_visual'); 
        $routes->get('site-files-backup', 'Admin\BackupManager\Index::site_files_backup'); 
        $routes->get('download-site-files/(:any)', 'Admin\BackupManager\Index::download_site/$1');
    });
});


// =============================================================================
// SESSION PROTECTED ROUTES
// =============================================================================
$routes->group('', ['filter' => 'session'], static function($routes) {

    $routes->get('it/group-access-request/(:any)', 'IT\Index::access_request/$1'); 

    // Purchasing Routes
    $routes->group('purchasing', static function($routes) {
        $routes->get('/', 'Purchasing\Index::index');
        // $routes->get('fabrication-report', 'Purchasing\Fabrication\Index::index');
        // $routes->get('fabrication-report/data', 'Purchasing\Fabrication\Index::get_data');
        // $routes->get('paint-report', 'Purchasing\Paint\Index::index');
        // $routes->get('paint-report/data', 'Purchasing\Paint\Index::get_data');
        // $routes->get('safety-stock', 'Purchasing\Stock\Index::index');
        // $routes->get('safety-stock/data', 'Purchasing\Stock\Index::get_data');
        
        $routes->group('fabrication-report', static function($routes){
            $routes->get('', 'Purchasing\Fabrication\Index::index'); 
            $routes->get('data', 'Purchasing\Fabrication\Index::get_data'); 
        }); 

        $routes->group('paint-report', static function($routes){
            $routes->get('', 'Purchasing\Paint\Index::index');
            $routes->get('data', 'Purchasing\Paint\Index::get_data');
        });

        $routes->group('safety-stock', static function($routes){
            $routes->get('', 'Purchasing\Stock\Index::index');
            $routes->get('data', 'Purchasing\Stock\Index::get_data');
        });

        $routes->group('tools', static function($routes) {
            $routes->get('/', 'Purchasing\Tools\Index::index');
            $routes->get('data', 'Purchasing\Tools\Index::get_data');
            
            $routes->group('bookings', static function($routes) {
                $routes->get('/', 'Purchasing\Tools\Bookings\Index::index');
                $routes->get('data/(:any)', 'Purchasing\Tools\Bookings\Index::get_data/$1');
                $routes->get('test-data/(:any)', 'Purchasing\Tools\Bookings\Index::get_data_test/$1'); 
                $routes->post('review', 'Purchasing\Tools\Bookings\Index::review_email');
                $routes->post('send-email', 'Purchasing\Tools\Bookings\Index::send_email');
                $routes->get('send-test-email', 'Purchasing\Tools\Bookings\Index::send_email_test'); 
            });
            
            $routes->group('confirmations', static function($routes) {
                $routes->get('/', 'Purchasing\Tools\Confirmations\Index::index');
                $routes->post('review', 'Purchasing\Tools\Confirmations\Index::review_email');
                $routes->post('send-email', 'Purchasing\Tools\Confirmations\Index::send_email');
                $routes->get('data', 'Purchasing\Tools\Confirmations\Index::get_data'); 
            });
        });

        $routes->group('orders', static function($routes){
            $routes->get('/', 'Purchasing\Orders\Index::index'); 
            $routes->get('data/(:any)', 'Purchasing\Orders\Index::get_data/$1'); 
            $routes->get('data', 'Purchasing\Orders\Index::get_data');
        });

        $routes->group('work-request', static function($routes){
            $routes->get('/', 'Purchasing\WorkRequest\Index::index'); 
            $routes->get('data', 'Purchasing\WorkRequest\Index::get_data'); 
            $routes->post('get', 'Purchasing\WorkRequest\Index::get_request');  
            $routes->post('update', 'Purchasing\WorkRequest\Index::update_request'); 
            $routes->post('save', 'Purchasing\WorkRequest\Index::save_request');  
            $routes->post('close', 'Purchasing\WorkRequest\Index::close_request'); 
            $routes->post('restore', 'Purchasing\WorkRequest\Index::restore_request'); 
        });

        $routes->group('part', static function($routes){
            $routes->group('name', static function($routes){
                $routes->group('generator', static function($routes){
                    $routes->get('', 'Purchasing\Part\Name\Generator\Index::index');
                });
            });
        });

    });

    // Production Routes
    $routes->group('production', static function($routes) {
        $routes->get('/', 'Production\Index::index');

        $routes->group('', ['filter' => 'secured_group:production'], static function($routes){
            $routes->group('schedule', static function($routes) {
                $routes->get('/', 'Production\Schedule\Index::index');
                $routes->get('data', 'Production\Schedule\Index::get_data');
                $routes->get('data/(:segment)', 'Production\Schedule\Index::get_data/$1');
                $routes->post('mark-complete', 'Production\Schedule\Index::set_operation_complete');
                $routes->get('shop-view', 'Production\Schedule\Index::shop_view');
                $routes->get('shop-view/(:segment)', 'Production\Schedule\Index::shop_view/$1');
            });

            $routes->group('workorders', static function($routes){
                $routes->get('', 'Production\Workorders::index');
            });
        });
        
        $routes->get('workorder/(:num)/(:num)', 'Production\Workorders::get_workorder/$1/$2');
        $routes->get('print', 'Production\Workorders::print_list');
        $routes->post('print', 'Production\Workorders::print_list');
        $routes->get('spreadsheets', 'Production\Spreadsheet\Index::index');
        $routes->get('spreadsheet/trucks/(:segment)', 'Production\Spreadsheet\Trucks::index/$1');
        $routes->get('truck/(:num)', 'Production\Spreadsheet\Truck::index/$1');

        $routes->group('requirements', static function($routes){
            $routes->get('paint', 'Production\Requirements\Paint\Index::index');
            $routes->get('paint/data', 'Production\Requirements\Paint\Index::get_data'); 
        });
        
        // $routes->group('schedule', static function($routes) {
        //     $routes->get('/', 'Production\Schedule\Index::index');
        //     $routes->get('data', 'Production\Schedule\Index::get_data');
        //     $routes->get('data/(:segment)', 'Production\Schedule\Index::get_data/$1');
        //     $routes->post('mark-complete', 'Production\Schedule\Index::set_operation_complete');
        //     $routes->get('shop-view', 'Production\Schedule\Index::shop_view');
        //     $routes->get('shop-view/(:segment)', 'Production\Schedule\Index::shop_view/$1');
        // });
    });

    // Sales Routes
    $routes->group('sales', static function($routes) {
        $routes->get('', 'Sales\Index::index');

        //secured routes 
        $routes->group('', ['filter' => 'secured_group:sales'], static function($routes) {
            $routes->group('customers', static function($routes){
                $routes->get('', 'Sales\Customers\Index::index');
                $routes->get('get', 'Sales\Customers\Index::get_data');

                $routes->group('orders', static function($routes){
                    $routes->group('open', static function ($routes){
                        $routes->get('', 'Sales\Customers\Orders\Open\Index::index'); 
                        $routes->get('data', 'Sales\Customers\Orders\Open\Index::get_data'); 
                    });
                });
            }); 

            $routes->group('customer', static function($routes){
                $routes->get('(:segment)', 'Sales\Customer\Index::index/$1');
            });
        });

       
        

        $routes->group('', ['filter' => 'edereport'], function($routes){
            $routes->group('ede', static function($routes) {
               $routes->get('report', 'Sales\EDE\Report\Index::index');
               $routes->get('report/data', 'Sales\EDE\Report\Index::get_data');
               $routes->get('report/spreadsheet', 'Sales\EDE\Report\Index::get_spreadsheet');
            });
        });



    });

    // Vendor Routes
    $routes->group('vendor', static function($routes) {
        $routes->get('performance/(:any)', 'Vendors\Index::get_performance/$1');
        $routes->get('reminder_review/(:any)', 'Vendors\Index::reminder_review/$1');
        $routes->get('email-delivery-update', 'Vendors\Email::update_delivery');
        $routes->get('email-confirmation', 'Vendors\Email::confirmation');
    });

    $routes->group('vendors', static function($routes) {
        $routes->get('tools', 'Vendors\Index::index');

        $routes->group('performance', static function($routes){
            $routes->get('', 'Vendors\Performance\Index::index'); 
            $routes->get('data', 'Vendors\Performance\Index::get_data'); 
            $routes->post('vendor', 'Vendors\Performance\Index::get_vendor'); 
            $routes->post('email-vendor', 'Vendors\Performance\Index::send_email');
        }); 
        
        
        $routes->get('jcp-report', 'Vendors\JCPReport\Index::index');
        $routes->get('jcp-report/data', 'Vendors\JCPReport\Index::get_data'); 
        $routes->get('list', 'Vendors\List\Index::index'); 
        $routes->get('list/data', 'Vendors\List\Index::get_data'); 
    });

    // Warehouse Routes
    $routes->group('warehouse', static function($routes) {
        $routes->get('/', 'Warehouse\Index::index');
        $routes->get('transactions', 'Warehouse\InventoryTransactions::index');
        $routes->post('print-pick-list', 'Warehouse\InventoryTransactions::print');
        $routes->post('get-transactions', 'Warehouse\InventoryTransactions::get_data');
        $routes->get('receipts', 'Warehouse\Receiver::index');
        $routes->get('po/getpo/(:num)', 'Warehouse\Receiver::get_purchase_order/$1');
        $routes->group('parts', static function($routes){
            $routes->get('', 'Warehouse\Parts\Index::index'); 
            $routes->get('part-lookup', 'Warehouse\Parts\PartLookup\Index::index'); 
            $routes->get('part-lookup/data', 'Warehouse\Parts\PartLookup\Index::get_data'); 
            $routes->post('part-lookup/data', 'Warehouse\Parts\PartLookup\Index::get_data'); 
            $routes->post('part-lookup/details', 'Warehouse\Parts\PartLookup\Index::get_details'); 
            $routes->get('part-lookup/details/(:any)', 'Warehouse\Parts\PartLookup\Index::get_details/$1'); 
        });
    });

    // Work Orders Routes
    $routes->group('workorders', static function($routes) {
        $routes->get('/', 'Workorders\Index::index');
        $routes->get('(:num)', 'Workorders\Index::index/$1');
        $routes->get('open_workorders', 'Workorders\Index::open_workorders');
    });

    $routes->group('workorder', static function($routes) {
        $routes->get('(:num)/(:num)', 'Workorders\Index::workorder/$1/$2');
        $routes->get('print', 'Workorders\Index::print');
        $routes->post('print', 'Workorders\Index::print');
    });

    // Maintenance Routes
    $routes->group('maintenance', static function($routes) {
        $routes->get('/', 'Maintenance\Index::index');
        $routes->get('stats', 'Maintenance\Index::getPerformance');
        $routes->get('total-tickets', 'Maintenance\Index::getTotalTickets');
        $routes->group('', ['filter' => 'group:maintenance'], static function($routes) {

        });
    });

    // IT Routes
    $routes->group('it', static function($routes) {
        $routes->get('/', 'IT\Index::index');
    });

    // Service Tickets Routes
    // $routes->group('service-tickets', static function($routes) {
    //     $routes->get('(:segment)', 'ServiceTicket\Index::index/$1');
    //     $routes->post('(:segment)/save', 'ServiceTicket\Index::save_data');
    //     $routes->get('data/(:segment)/(:segment)', 'ServiceTicket\Index::get_data/$1/$2');
    //     $routes->post('(:segment)/delete', 'ServiceTicket\Index::delete');
    // });

    // Engineering Routes
    $routes->group('engineering', static function($routes) {
        $routes->get('/', 'Engineering\Index::index');
    });

    //HR Routes
    $routes->group('hr', static function($routes){
        $routes->get('/', 'HR\Index::index'); 
        $routes->group('employee', static function($routes){
            $routes->get('management', 'HR\Employee\Management\Index::index');
            $routes->get('management/data', 'HR\Employee\Management\Index::get_data');
            $routes->post('management/employee', 'HR\Employee\Management\Index::get_employee');
            $routes->post('management/employee/save', 'HR\Employee\Management\Index::save_employee');
        });
    });

    // Error Routes
    $routes->get('access/denied', 'Errors\Index::index');
});

$routes->group('service', static function($routes) {
    $routes->get('', 'ServiceTicket\Index::index');
    $routes->group('tickets', static function($routes){

        $routes->get('data/(:segment)', 'ServiceTicket\Tickets\Index::get_data/$1');
        $routes->get('process', 'ServiceTicket\Tickets\Index::get_old'); 
        $routes->get('process/(:segment)', 'ServiceTicket\Tickets\Index::get_old/$1'); 
        $routes->get('(:segment)', 'ServiceTicket\Tickets\Index::index/$1');
        
        $routes->post('new', 'ServiceTicket\Tickets\Index::new_ticket');
        $routes->post('save', 'ServiceTicket\Tickets\Index::save_ticket'); 
        $routes->post('close', 'ServiceTicket\Tickets\Index::delete');
        $routes->post('get', 'ServiceTicket\Tickets\Index::get_ticket'); 
        
    });
});