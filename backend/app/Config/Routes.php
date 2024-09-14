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

$routes->options('/(:any)', 'Home::options', ['filter' => 'ApiAccessFilter']);

$routes->get('/', 'MembersController::index');
$routes->get('/register', 'MembersController::renderRegisterPage');
$routes->post('/register', 'MembersController::register');
$routes->get('/login', 'MembersController::renderLoginPage');
$routes->post('/login', 'MembersController::login');

$routes->get('/product', 'FrontStage\ProductsController::showProducts');
$routes->get('/product/(:num)', 'FrontStage\ProductsController::showPerProduct/$1');

$routes->group('/', ['filter' => 'JwtAuth','ApiAccessFilter'], function($routes)
{
    $routes->get('/home', 'MemberManage::index');
    $routes->get('/logout', 'MembersController::logout');

    $routes->get('/editMemberData', 'MemberManage::renderEditMemberDataPage');
    $routes->post('/editMemberData', 'MemberManage::update');
    $routes->delete('/delete', 'MemberManage::delete');

    // $routes->get('/backstage/product', 'BackStage\ProductsController::showProducts');
    // $routes->post('/backstage/product', 'BackStage\ProductsController::addProduct');
    // $routes->put('/backstage/product/(:num)', 'BackStage\ProductsController::editProduct/$1');
    // $routes->delete('/backstage/product/(:num)', 'BackStage\ProductsController::deleteProduct/$1');
    // $routes->get('/backstage/product/(:num)', 'BackStage\ProductsController::showPerProduct/$1');

    $routes->get('/cartItems', 'FrontStage\CartItemsController::showCartItems');
    $routes->post('/cartItems', 'FrontStage\CartItemsController::addCartItem');
    $routes->put('/cartItems/(:num)', 'FrontStage\CartItemsController::editCartItem/$1');
    $routes->delete('/cartItems/(:num)', 'FrontStage\CartItemsController::deleteCartItem/$1');

    
});

$routes->get('/orders', 'FrontStage\OrdersController::testCreateOrder');

$routes->post('/orders', 'FrontStage\OrdersController::createOrder');
$routes->get('/orderPay', 'FrontStage\EcPayController::orderPay');
$routes->post('/callbackAfterPayment', 'FrontStage\EcPayController::callbackAfterPayment');
$routes->post('/afterPayment', 'FrontStage\EcPayController::afterPayment');

$routes->get('/backstage/categories', 'BackStage\CategoriesController::showCategories');
$routes->post('/backstage/categories', 'BackStage\CategoriesController::addCategory');
$routes->put('/backstage/categories/(:num)', 'BackStage\CategoriesController::editCategory/$1');
$routes->delete('/backstage/categories/(:num)', 'BackStage\CategoriesController::deleteCategory/$1');

$routes->get('/backstage/product', 'BackStage\ProductsController::showProducts');
$routes->post('/backstage/product', 'BackStage\ProductsController::addProduct');
$routes->put('/backstage/product/(:num)', 'BackStage\ProductsController::editProduct/$1');
$routes->delete('/backstage/product/(:num)', 'BackStage\ProductsController::deleteProduct/$1');
$routes->get('/backstage/product/(:num)', 'BackStage\ProductsController::showPerProduct/$1');

$routes->get('/backstage/order', 'BackStage\OrdersController::showOrders');
$routes->put('/backstage/order/(:num)', 'BackStage\OrdersController::editOrder/$1');
$routes->delete('/backstage/order/(:num)', 'BackStage\OrdersController::deleteOrder/$1');
$routes->get('/backstage/order/(:num)', 'BackStage\OrdersController::showPerOrder/$1');

$routes->get('/order', 'FrontStage\OrdersController::showOrders');
$routes->put('order/(:num)', 'FrontStage\OrdersController::editOrder/$1');

$routes->post('/backstage/storeInfo', 'BackStage\StoreInfoController::addStoreInfo');
$routes->put('/backstage/storeInfo/(:num)', 'BackStage\StoreInfoController::editStoreInfo/$1');
$routes->delete('/backstage/storeInfo/(:num)', 'BackStage\StoreInfoController::deleteStoreInfo/$1');
$routes->get('/backstage/storeInfo/(:num)', 'BackStage\StoreInfoController::showPerStoreInfo/$1');
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
