<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('weather', 'Dashboard::get_weather'); 
$routes->get('dashboard', 'Dashboard::index');
$routes->get('directory', 'Directory::index');
$routes->post('directory/search', 'Directory::search'); 
$routes->get('directory/weather', 'Directory::weather'); 

/**
 * Common pages for all users 
 */
$routes->get('employee/resources', 'Employee\Index::index'); 
$routes->get('employee/leave/request', 'Employee\Leave::index'); 

$routes->group('employee', static function($routes){
   $routes->get('training', 'Employee\Training\Index::index'); 
   $routes->get('training/data', 'Employee\Training\Index::get_data'); 
   $routes->get('training/resources', 'Employee\Training\Index::get_resources'); 
   $routes->get('list', 'Employee\Index::list'); 
});

$routes->group('sales', static function($routes){
   $routes->get('', 'Sales\Index::index'); 
   $routes->get('customers', 'Sales\Customers\Index::index'); 
   $routes->get('customers/get', 'Sales\Customers\Index::get_data'); 
   
   $routes->get('customer/orders/(:num)', 'Sales\Customer\Orders\Index::index/$1'); 
   $routes->get('customer/(:segment)', 'Sales\Customer\Index::index/$1'); 
});

$routes->group('orientation', static function($routes){
   $routes->get('', 'Employee\Orientation\Index::index');
});

$routes->get('leave/requestform', 'Forms\LeaveRequest::getPdf');
$routes->get('files', 'Dashboard::files'); 
$routes->get('download/(:any)', 'Filemanager\FileController::download/$1');

service('auth')->routes($routes);


/**
 * User Profile Area
 */
$routes->get('user/profile', 'User\Index::index'); 
$routes->get('user/profile/(:num)', 'User\Index::index/$1'); 


/**
 * --------------------------------------------------------------------
 * Superadmin Routes Group
 * --------------------------------------------------------------------
 * Routes accessible only to users in the 'superadmin' group.
 * URI prefix: /sadmin
 * 
 * This section provides access to privileged administrative tools, 
 * including:
 * 
 * - Control Panel:
 *     - '/control-panel' → Superadmin dashboard
 * 
 * - User Management:
 *     - '/user-management'         → Manage user accounts
 *     - '/user/edit/(:num)'        → Edit a specific user
 *     - '/user/create'             → Create a new user
 *     - '/user/update/(:num)'      → Update existing user
 *     - '/create-guest'            → Create a guest account
 * 
 * - Network Assets Management:
 *     - '/workstation/add/(:num)'       → Assign asset to workstation
 *     - '/asset-manager'                → View asset management dashboard
 *     - '/asset/create'                 → Create new asset
 *     - '/asset/edit/(:num)'            → Edit asset
 *     - '/asset/update/(:num)'          → Update asset
 *     - '/asset/remove/(:num)'          → Remove asset
 *     - '/asset/delete/(:num)'          → Permanently delete asset
 *     - '/asset/get/(:num)'             → Get asset details
 *     - '/assets/print'                 → Print all assets
 *     - '/assets/print-details'         → Print detailed asset view
 * 
 * - Login Management:
 *     - '/logins/add/(:num)'            → Add login credentials to a user
 *     - '/login/delete/(:num)'          → Delete a login record
 */

$routes->group('sadmin', ['filter' => 'group:super'], function($routes){
   
    $routes->get('control-panel', 'Admin\Index::index' ); 
    /**
     * User Restricted Area
     * 
     */
    $routes->get('user-management', 'Admin\Users::index'); 
    $routes->get('user/edit/(:num)', 'Admin\Users::edit/$1'); 
    $routes->post('user/create', 'Admin\Users::create'); 
    $routes->post('user/update/(:num)', 'Admin\Users::update/$1'); 
    $routes->get('create-guest', 'Admin\Users::create_guest');


    /**
     * Networks Assets Management
     */

    //$routes->post('workstation/add/(:num)', 'Admin\NetAssets::add/$1'); 
    //$routes->get('asset-manager', 'Admin\NetAssets::index'); 
    //$routes->post('asset/create', 'Admin\NetAssets::create'); 


    $routes->group('assets-manager', static function($routes){
      $routes->get('/', 'Admin\AssetsManager::index');
      $routes->get('print', 'Admin\AssetsManager::print');
    });

    
    //$routes->get('asset/edit/(:num)', 'Admin\NetAsset::edit/$1'); 
    //$routes->post('asset/update/(:num)', 'Admin\NetAssets::update/$1'); 
    //$routes->get('asset/remove/(:num)', 'Admin\NetAssets::remove/$1'); 
   //  $routes->get('asset/get/(:num)', 'Admin\NetAssets::lookup/$1'); 
   //  $routes->get('asset/delete/(:num)', 'Admin\NetAssets::delete/$1'); 
    $routes->get('assets/print', 'Admin\NetAssets::print'); 
    $routes->get('assets/print-details', 'Admin\NetAssets::print_details');

    $routes->group('asset', static function($routes){
         $routes->get('edit/(:num)', 'Admin\Asset\Edit\Index::index/$1'); 
         $routes->post('update/(:num)', 'Admin\Asset\Edit\Index::save/$1'); 
         $routes->get('remove-user/(:num)', 'Admin\Asset\Edit\Index::removeUser/$1'); 
         $routes->post('add-user/(:num)', 'Admin\Asset\Edit\Index::addUser/$1');
         $routes->get('lookup/(:num)', 'Admin\Asset\Edit\Index::lookup/$1');  
    });


    /**
     * Login Managment
    */

    $routes->post('logins/add/(:num)', 'Admin\Logins::add/$1');
    $routes->get('login/delete/(:num)', 'Admin\Logins::delete/$1'); 

    $routes->group('login-manager', static function($routes){
      $routes->get('/', 'Admin\LoginManager::index'); 
      $routes->get('(:num)', 'Admin\LoginManager::index/$1'); 
      $routes->post('save', 'Admin\LoginManager::save_data'); 
      $routes->get('decrypt/(:num)', 'Admin\LoginManager::decrypt/$1'); 
      $routes->get('edit/(:num)', 'Admin\LoginManager::edit/$1'); 
    });

   $routes->get('page-logs', 'Admin\PageStats::index'); 

 });


/**
 * --------------------------------------------------------------------
 * Protected Routes Group (Session Filter)
 * --------------------------------------------------------------------
 * All routes within this group are protected by the 'session' filter, 
 * ensuring that only authenticated users with an active session can 
 * access them.
 * 
 * This group includes:
 * 
 * - Purchasing Routes:
 *     Routes for tools, reports, and safety stock management under
 *     the 'purchasing' URI prefix.
 * 
 * - Vendor Routes:
 *     Routes for handling individual vendor operations, including 
 *     performance metrics and email-based actions, under the 'vendor' URI prefix.
 * 
 * - Vendors Routes:
 *     Routes for listing and retrieving data for all vendors, under 
 *     the 'vendors' URI prefix.
 */


 $routes->group('', ['filter' => 'session'], static function($routes){

   /**
    * --------------------------------------------------------------------
    * Purchasing Routes Group
    * --------------------------------------------------------------------
    * Defines all routes under the 'purchasing' URI prefix.
    * These routes map to various controllers handling purchasing-related 
    * tools and reports, including:
    * 
    * - PO Tools: general tools for managing purchase orders
    *     - '/po-tools'                   → Main PO tools dashboard
    *     - '/po-tools/bookings'         → PO bookings interface
    *     - '/bookings/data/(:any)'      → Fetch bookings data (filtered)
    *     - '/po-booking-review/(:any)'  → Review a specific booking
    *     - '/updatestatus/(:any)/(:any)'→ Update PO status
    * 
    * - PO Confirmations:
    *     - '/po-tools/confirmations'        → PO confirmations interface
    *     - '/po-confirmation-review/(:any)' → Review a specific confirmation
    * 
    * - PO Counts:
    *     - '/po-tools/counts'   → Counts dashboard
    *     - '/po-counts'         → Retrieve counts data
    * 
    * - Reports:
    *     - '/fabrication-report'        → Fabrication report view
    *     - '/fabrication-report/data'   → Fabrication report data
    *     - '/paint-report'              → Paint report view
    *     - '/paint-report/data'         → Paint report data
    * 
    * - Safety Stock:
    *     - '/safety-stock'        → Safety stock overview
    *     - '/safety-stock/data'   → Fetch safety stock data
    * 
    * NOTE: A previously defined vendor list route is commented out.
    */

   $routes->group('purchasing-test', static function($routes){
      // $routes->get('bookings', 'Purchasing\PO_Tools\Bookings\Index::index'); 
      // $routes->get('bookings/get/(:any)', 'Purchasing\PO_Tools\Bookings\Index::get_data/$1'); 
   });


   $routes->group('purchasing', static  function($routes){
      
      $routes->get('/', 'Purchasing\Index::index');
      
      $routes->get('po-tools', 'Purchasing\PoTools::index'); 

      // $routes->get('po-tools/bookings', 'Purchasing\PoTools::bookings'); 
      // $routes->get('bookings/data/(:any)' , 'Purchasing\PoTools::get_data/$1');
      
      $routes->group('tools', static function($routes){
         $routes->group('bookings', static function($routes){
            $routes->get('/', 'Purchasing\Tools\Bookings\Index::index'); 
            $routes->get('data/(:any)', 'Purchasing\Tools\Bookings\Index::get_data/$1'); 
            //$routes->post('bookings/po/', 'Purchasing\Tools\Bookings\Index::get_po'); 
            $routes->post('view-email', 'Purchasing\Tools\Bookings\Index::view_email'); 
            $routes->post('send-email', 'Purchasing\Tools\Bookings\Index::send_email'); 
         });
      });


      $routes->get('po-booking-review/(:any)', 'Purchasing\PoTools::po_booking_review/$1');
      $routes->get('updatestatus/(:any)/(:any)', 'Purchasing\PoTools::update_po_status/$1/$2');

      $routes->get('po-tools/confirmations', 'Purchasing\PoTools::confirmations');              
      $routes->get('po-confirmation-review/(:any)', 'Purchasing\PoTools::po_confirmation_review/$1');

      $routes->get('po-tools/counts', 'Purchasing\PoTools::counts'); 
      $routes->get('po-counts', 'Purchasing\PoTools::po_counts'); 
      
      $routes->get('fabrication-report', 'Purchasing\FabricationReport::index'); 
      $routes->get('fabrication-report/data', 'Purchasing\FabricationReport::get_data'); 

      $routes->get('paint-report', 'Purchasing\PaintReport::index'); 
      $routes->get('paint-report/data', 'Purchasing\PaintReport::get_data'); 

      $routes->get('safety-stock', 'Purchasing\SafetyStock::index');
      $routes->get('safety-stock/data', 'Purchasing\SafetyStock::get_data');

   });


   /**
    * --------------------------------------------------------------------
    * Vendor Routes
    * --------------------------------------------------------------------
    * Routes related to individual vendor operations and actions.
    * URI prefix: /vendor
    * 
    * - '/performance/(:any)'         → Fetch vendor performance metrics
    * - '/reminder_review/(:any)'     → Display vendor reminder review
    * - '/email-delivery-update'      → Handle email delivery update (AJAX/trigger)
    * - '/email-confirmation'         → Handle email confirmation (AJAX/trigger)
    */

   /**
    * --------------------------------------------------------------------
    * Vendors Routes (List & Data)
    * --------------------------------------------------------------------
    * Routes related to the vendors listing and associated data retrieval.
    * URI prefix: /vendors
    * 
    * - '/'          → Vendor listing page
    * - '/data'      → Retrieve vendor data (for DataTables or API)
    */

   $routes->group('vendor', static function($routes){
      $routes->get('performance/(:any)', 'Vendors\Index::get_performance/$1'); 
      $routes->get('reminder_review/(:any)', 'Vendors\Index::reminder_review/$1');
      $routes->get('email-delivery-update', 'Vendors\Email::update_delivery'); 
      $routes->get('email-confirmation', 'Vendors\Email::confirmation'); 
   });

   $routes->group('vendors', static function($routes){
      $routes->get('/', 'Vendors\Index::index'); 
      $routes->get('data', 'Vendors\Index::get_data'); 
   });




   /**
    * File Download Routes
   */

   $routes->get('file/(:any)', 'Filemanager\Files::get_file/$1/$2');


   /**
   * Warehouse Related Routes
   */
   $routes->group('warehouse', static function($routes){
   $routes->get('/', 'Warehouse\Index::index');
   $routes->get('transactions', 'Warehouse\InventoryTransactions::index');
   $routes->post('print-pick-list', 'Warehouse\InventoryTransactions::print'); 
   $routes->post('get-transactions', 'Warehouse\InventoryTransactions::get_data'); 
   $routes->get('receipts', 'Warehouse\Receiver::index'); 
   $routes->get('po/getpo/(:num)', 'Warehouse\Receiver::get_purchase_order/$1');
   });


   /**
    * Production Related Routes
    */

   $routes->get('production', 'Production\Index::index');
   $routes->get('production/workorders', 'Production\Workorders::index');
   $routes->get('production/workorder/(:num)/(:num)', 'Production\Workorders::get_workorder/$1/$2');
   $routes->get('production/print', 'Production\Workorders::print_list'); 
   $routes->post('production/print', 'Production\Workorders::print_list'); 

   $routes->get('production/spreadsheets', 'Production\Spreadsheet\Index::index'); 
   $routes->get('production/spreadsheet/trucks/(:segment)', 'Production\Spreadsheet\Trucks::index/$1'); 
   $routes->get('production/truck/(:num)', 'Production\Spreadsheet\Truck::index/$1'); 

   $routes->group('production', static function($routes){
      $routes->group('schedule', static function($routes){
         $routes->get('/',  'Production\Schedule\Index::index'); 
         $routes->get('data', 'Production\Schedule\Index::get_data'); 
         $routes->get('data/(:segment)', 'Production\Schedule\Index::get_data/$1'); 
         $routes->post('mark-complete', 'Production\Schedule\Index::set_operation_complete'); 
         $routes->get('shop-view', 'Production\Schedule\Index::shop_view'); 
         $routes->get('shop-view/(:segment)', 'Production\Schedule\Index::shop_view/$1'); 
      });
   });

   $routes->Get('access/denied', 'Errors::denied');


   $routes->get('workorders', 'Workorders\Index::index'); 
   $routes->get('workorders/(:num)', 'Workorders\Index::index/$1'); 
   $routes->get('workorder/(:num)/(:num)', 'Workorders\Index::workorder/$1/$2');
   $routes->get('workorder/print', 'Workorders\Index::print'); 
   $routes->post('workorder/print', 'Workorders\Index::print'); 


   $routes->group('workorders', static function($routes){
      $routes->get('open_workorders', 'Workorders\Index::open_workorders'); 
   });


   // $routes->group('it', static function($routes){
   //    $routes->get('/', 'IT\Index::index'); 
   //    $routes->get('data/(:any)', 'IT\Index::get_data/$1'); 
   //    $routes->post('update', 'IT\Index::save_data'); 
   //    $routes->get('delete(:any)', 'IT\Index::delete/$1'); 
   // }); 

   $routes->group('maintenance', static function($routes){
      $routes->get('/', 'Maintenance\Index::index'); 
      $routes->get('stats', 'Maintenance\Index::getPerformance');
      $routes->get('total-tickets', 'Maintenance\Index::getTotalTickets');
   });

   $routes->group('it', static function($routes){
      $routes->get('/', 'IT\Index::index'); 
   });

   $routes->group('service-tickets', static function($routes) {
      $routes->get('(:segment)', 'ServiceTicket\Index::index/$1');
      $routes->post('(:segment)/save', 'ServiceTicket\Index::save_data');
      $routes->get('data/(:segment)/(:segment)', 'ServiceTicket\Index::get_data/$1/$2');
      $routes->post('(:segment)/delete', 'ServiceTicket\Index::delete');
   });
  

  $routes->group('engineering', static function($routes){
    $routes->get('/', 'Engineering\Index::index'); 
  });


});