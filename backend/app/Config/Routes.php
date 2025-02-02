<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');

// $routes->options('/(:any)', 'Home::options', ['filter' => 'apiAccess']);

// $routes->get('/', 'MembersController::index');
// $routes->get('/register', 'MembersController::renderRegisterPage');
// $routes->post('/register', 'MembersController::register');
// $routes->get('/login', 'MembersController::renderLoginPage');
// $routes->post('/login', 'MembersController::login');

// $routes->get('/product', 'FrontStage\ProductsController::showProducts');
// $routes->get('/product/(:num)', 'FrontStage\ProductsController::showPerProduct/$1');

// $routes->group('/', ['filter' => 'JwtAuth','ApiAccessFilter'], function($routes)
// {
//     $routes->get('/home', 'MemberManage::index');
//     $routes->get('/logout', 'MembersController::logout');

//     $routes->get('/editMemberData', 'MemberManage::renderEditMemberDataPage');
//     $routes->post('/editMemberData', 'MemberManage::update');
//     $routes->delete('/delete', 'MemberManage::delete');

//     // $routes->get('/backstage/product', 'BackStage\ProductsController::showProducts');
//     // $routes->post('/backstage/product', 'BackStage\ProductsController::addProduct');
//     // $routes->put('/backstage/product/(:num)', 'BackStage\ProductsController::editProduct/$1');
//     // $routes->delete('/backstage/product/(:num)', 'BackStage\ProductsController::deleteProduct/$1');
//     // $routes->get('/backstage/product/(:num)', 'BackStage\ProductsController::showPerProduct/$1');

//     $routes->get('/cartItems', 'FrontStage\CartItemsController::showCartItems');
//     $routes->post('/cartItems', 'FrontStage\CartItemsController::addCartItem');
//     $routes->put('/cartItems/(:num)', 'FrontStage\CartItemsController::editCartItem/$1');
//     $routes->delete('/cartItems/(:num)', 'FrontStage\CartItemsController::deleteCartItem/$1');

    
// });

// $routes->get('/orders', 'FrontStage\OrdersController::testCreateOrder');

// $routes->post('/orders', 'FrontStage\OrdersController::createOrder');
// $routes->get('/orderPay', 'FrontStage\EcPayController::orderPay');
// $routes->post('/callbackAfterPayment', 'FrontStage\EcPayController::callbackAfterPayment');
// $routes->post('/afterPayment', 'FrontStage\EcPayController::afterPayment');

// $routes->get('/backstage/categories', 'BackStage\CategoriesController::showCategories');
// $routes->post('/backstage/categories', 'BackStage\CategoriesController::addCategory');
// $routes->put('/backstage/categories/(:num)', 'BackStage\CategoriesController::editCategory/$1');
// $routes->delete('/backstage/categories/(:num)', 'BackStage\CategoriesController::deleteCategory/$1');

// $routes->get('/backstage/product', 'BackStage\ProductsController::showProducts');
// $routes->post('/backstage/product', 'BackStage\ProductsController::addProduct');
// $routes->put('/backstage/product/(:num)', 'BackStage\ProductsController::editProduct/$1');
// $routes->delete('/backstage/product/(:num)', 'BackStage\ProductsController::deleteProduct/$1');
// $routes->get('/backstage/product/(:num)', 'BackStage\ProductsController::showPerProduct/$1');

// $routes->get('/backstage/order', 'BackStage\OrdersController::showOrders');
// $routes->put('/backstage/order/(:num)', 'BackStage\OrdersController::editOrder/$1');
// $routes->delete('/backstage/order/(:num)', 'BackStage\OrdersController::deleteOrder/$1');
// $routes->get('/backstage/order/(:num)', 'BackStage\OrdersController::showPerOrder/$1');

// $routes->get('/order', 'FrontStage\OrdersController::showOrders');
// $routes->put('order/(:num)', 'FrontStage\OrdersController::editOrder/$1');

// $routes->post('/backstage/storeInfo', 'BackStage\StoreInfoController::addStoreInfo');
// $routes->put('/backstage/storeInfo/(:num)', 'BackStage\StoreInfoController::editStoreInfo/$1');
// $routes->delete('/backstage/storeInfo/(:num)', 'BackStage\StoreInfoController::deleteStoreInfo/$1');
// $routes->get('/backstage/storeInfo/(:num)', 'BackStage\StoreInfoController::showPerStoreInfo/$1');

$routes->options('(:any)', 'Home::options', ['filter' => 'apiAccess']);

// API V1 (前台)
$routes->group('api/v1', ['filter' => 'apiAccess'], function($routes) {
    // 公開路由
    $routes->post('register', 'Api\V1\AuthController::register');
    $routes->post('login', 'Api\V1\AuthController::login');
    $routes->post('forgot-password', 'Api\V1\AuthController::forgotPassword');
    $routes->post('reset-password', 'Api\V1\AuthController::resetPassword');

    // 需要會員驗證的路由
    $routes->group('', ['filter' => 'memberAuth'], function($routes) {
        $routes->get('profile', 'Api\V1\MemberController::profile');
        $routes->put('profile', 'Api\V1\MemberController::update');
        $routes->put('change-password', 'Api\V1\MemberController::changePassword');
        $routes->delete('deactivate', 'Api\V1\MemberController::deactivate');
        $routes->get('logout', 'Api\V1\MemberController::logout');
    });
});

// API Admin (後台)
$routes->group('api/admin', ['filter' => 'apiAccess'], function($routes) {
    // 後台登入
    $routes->get('login', 'Api\Admin\AuthController::getCsrf');
    $routes->post('login', 'Api\Admin\AuthController::login');

    // 需要管理員驗證的路由
    $routes->group('', ['filter' => 'adminAuth'], function($routes) {
        // 儀表板
        $routes->get('dashboard', 'Api\Admin\DashboardController::index');

        // 管理員自己
        $routes->get('profile', 'Api\Admin\AuthController::profile');
        $routes->put('profile', 'Api\Admin\AuthController::update');
        $routes->put('change-password', 'Api\Admin\AuthController::changePassword');
        $routes->get('logout', 'Api\Admin\AuthController::logout');

        // 超級管理員
        $routes->get('admins', 'Api\Admin\AdminController::index');
        $routes->post('admins', 'Api\Admin\AdminController::create');
        $routes->get('admins/(:num)', 'Api\Admin\AdminController::show/$1');
        $routes->put('admins/(:num)', 'Api\Admin\AdminController::update/$1');
        $routes->delete('admins/(:num)', 'Api\Admin\AdminController::delete/$1');
        $routes->get('admins/logs', 'Api\Admin\AdminController::logs');
        
        // 會員管理
        $routes->get('members', 'Api\Admin\MemberController::index');
        $routes->get('members/(:num)', 'Api\Admin\MemberController::show/$1');
        $routes->put('members/(:num)', 'Api\Admin\MemberController::update/$1');
        $routes->delete('members/(:num)', 'Api\Admin\MemberController::delete/$1');

        // 設定管理
        $routes->group('settings', function($routes) {
            $routes->post('upload', 'Api\Admin\SettingController::upload');
            $routes->get('/', 'Api\Admin\SettingController::index');
            $routes->get('(:num)', 'Api\Admin\SettingController::show/$1');
            $routes->post('/', 'Api\Admin\SettingController::create');
        });
    });
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
