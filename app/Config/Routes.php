<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function () {
	return view('templates/404');
});
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'CusFilter']);
$routes->group('orders', ['filter' => 'CusFilter'], function ($routes) {
	$routes->get('', 'Orders::index');
	$routes->post('cancel', 'Orders::cancel');
	$routes->get('history', 'Orders::history');
	$routes->get('(:any)', 'Orders::index');
});

$routes->group('menu', ['filter' => 'CusFilter'], function ($routes) {
	$routes->get('', 'Menu::index');
	$routes->post('ordering', 'Menu::ordering');
	$routes->get('orderresult/(:any)', 'Menu::orderResult/$1');
});

$routes->group('account', ['filter' => 'CusFilter'], function ($routes) {
	$routes->get('changepass', 'Account::changepass');
	$routes->post('updatepass', 'Account::updatepass');
	$routes->get('edit', 'Account::edit');
	$routes->post('update', 'Account::update');
});

$routes->get('/login', 'Auth::index', ['filter' => 'LoginFilter']);
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register', ['filter' => 'LoginFilter']);
$routes->post('/registering', 'Auth::registering', ['filter' => 'LoginFilter']);
$routes->get('/first', 'Home::first', ['filter' => 'RegisterFilter']);
$routes->post('/update', 'Home::update', ['filter' => 'RegisterFilter']);

$routes->group('admin', function ($routes) {
	$routes->get('', 'Admin\Dashboard::index',  ['filter' => 'RoleFilter']);
	$routes->group('food', ['filter' => 'RoleFilter:super,admin'], function ($routes) {
		$routes->get('ordinary', 'Admin\Food::ordinary');
		$routes->get('special', 'Admin\Food::special');
		$routes->get('add', 'Admin\Food::add');
		$routes->get('add_s', 'Admin\Food::add_s');
		$routes->delete('(:any)', 'Admin\Food::delete/$1/$2');
		$routes->get('edit/(:any)', 'Admin\Food::edit/$1');
		$routes->get('edit_s/(:any)', 'Admin\Food::edit_s/$1');
		$routes->get('restore', 'Admin\Food::restore');
		$routes->post('switch', 'Admin\Food::switch');
	});
	$routes->group('orders', ['filter' => 'RoleFilter:super,admin,chef'], function ($routes) {
		$routes->get('', 'Admin\Orders::index');
		$routes->get('cus', 'Admin\Orders::cus');
		$routes->get('food', 'Admin\Orders::food');
		$routes->get('detail', 'Admin\Orders::detail');
		$routes->get('history_by_order_query/(:any)', 'Admin\Orders::history_by_order_query/$1/$2/$3/$4/$5');
		$routes->get('history_by_order_query/(:any)', 'Admin\Orders::history_by_cus_query/$1/$2/$3/$4/$5');
		$routes->get('history_by_order_query/(:any)', 'Admin\Orders::history_by_food_query/$1/$2/$3/$4/$5/$6');
	});

	// $routes->get('orders', 'Admin\Orders::index', ['filter' => 'RoleFilter:super,admin,chef']);
	// $routes->get('orders/(:any)', 'Admin\Orders::index/$1',  ['filter' => 'RoleFilter:super,admin,chef']);
	$routes->group('payment', ['filter' => 'RoleFilter:super,admin,cashier'], function ($routes) {
		$routes->get('', 'Admin\Payment::index');
		$routes->get('result/(:any)', 'Admin\Payment::result/$1');
	});

	$routes->group('customer', ['filter' => 'RoleFilter:super,admin'], function ($routes) {
		$routes->get('', 'Admin\Customer::index');
		$routes->post('result', 'Admin\Customer::result');
		$routes->post('block', 'Admin\Customer::block');
		$routes->post('restore', 'Admin\Customer::restore');
		$routes->post('upload', 'Admin\Customer::upload');
		$routes->post('download', 'Admin\Customer::download');
		$routes->post('save', 'Admin\Customer::save');
	});

	$routes->group('user', ['filter' => 'RoleFilter:super'], function ($routes) {
		$routes->get('', 'Admin\User::index');
		$routes->get('add', 'Admin\User::add');
		$routes->get('edit', 'Admin\User::edit');
		$routes->post('save', 'Admin\User::save');
		$routes->post('update', 'Admin\User::update');
		$routes->post('block', 'Admin\User::block');
		$routes->post('resetpass', 'Admin\User::resetpass');
		$routes->post('restore', 'Admin\User::restore');
	});
	$routes->group('variable', ['filter' => 'RoleFilter:super,admin'], function ($routes) {
		$routes->get('changetimelimit', 'Admin\Variable::changetimelimit');
		$routes->get('changedeliverycost', 'Admin\Variable::changedeliverycost');
		$routes->get('announcement', 'Admin\Variable::announcement');
		$routes->post('updateTimeLimit', 'Admin\Variable::updateTimeLimit');
		$routes->post('updateDeliveryCost', 'Admin\Variable::updateDeliveryCost');
		$routes->post('updateannounce', 'Admin\Variable::updateannounce');
		$routes->post('cancelannounce', 'Admin\Variable::cancelannounce');
		$routes->post('publishannounce', 'Admin\Variable::publishannounce');
	});
	$routes->group('account', ['filter' => 'RoleFilter'], function ($routes) {
		$routes->get('changepass', 'Admin\Account::changepass');
		$routes->post('updatepass', 'Admin\Account::updatepass');
	});
	$routes->group('report', ['filter' => 'RoleFilter:super,admin'], function ($routes) {
		$routes->get('income', 'Admin\Report::income');
		$routes->get('income_query/(:any)', 'Admin\Report::income_query/$1/$2/$3/$4');
		$routes->get('income_export/(:any)', 'Admin\Report::income_export/$1/$2/$3/$4');
		$routes->get('delivery_query/(:any)', 'Admin\Report::delivery_query/$1/$2/$3/$4');
	});
	$routes->group('admlog', ['filter' => 'RoleFilter:super,admin'], function ($routes) {
		$routes->get('', 'Admin\Admlog::index');
		$routes->get('getAll', 'Admin\Admlog::getAll');
		$routes->get('getByDate/(:any)', 'Admin\Admlog::getByDate/$1/$2/$3/$4/$5');
		$routes->get('getMethod/(:any)', 'Admin\Admlog::getMethod/$1');
	});
	$routes->group('cuslog', ['filter' => 'RoleFilter:super,admin'], function ($routes) {
		$routes->get('', 'Admin\Cuslog::index');
		$routes->get('getAll', 'Admin\Cuslog::getAll');
		$routes->get('getByDate/(:any)', 'Admin\Cuslog::getByDate/$1/$2/$3/$4/$5');
	});
});
// $routes->get('(:any)', 'Home::any', ['filter' => 'CusFilter']);




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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
