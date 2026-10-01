<?php
/** @var Application $app */

$app->router->get('/login',  'AuthController@showLogin');
$app->router->post('/login', 'AuthController@login');
$app->router->get('/logout', 'AuthController@logout');

$app->router->get('/',          'DashboardController@index', ['AuthMiddleware']);
$app->router->get('/dashboard', 'DashboardController@index', ['AuthMiddleware']);

$app->router->get('/users',         'UserController@index',  ['AuthMiddleware', 'PermissionMiddleware']);
$app->router->get('/users/create',  'UserController@create', ['AuthMiddleware', 'PermissionMiddleware']);
$app->router->post('/users/store',  'UserController@store',  ['AuthMiddleware', 'PermissionMiddleware']);
$app->router->get('/users/edit',    'UserController@edit',   ['AuthMiddleware', 'PermissionMiddleware']);
$app->router->post('/users/update', 'UserController@update', ['AuthMiddleware', 'PermissionMiddleware']);
$app->router->post('/users/delete', 'UserController@delete', ['AuthMiddleware', 'PermissionMiddleware']);

$app->router->get('/customers',         'CustomerController@index',  ['AuthMiddleware']);
$app->router->get('/customers/create',  'CustomerController@create', ['AuthMiddleware']);
$app->router->post('/customers/store',  'CustomerController@store',  ['AuthMiddleware']);
$app->router->get('/customers/edit',    'CustomerController@edit',   ['AuthMiddleware']);
$app->router->post('/customers/update', 'CustomerController@update', ['AuthMiddleware']);
$app->router->post('/customers/delete', 'CustomerController@delete', ['AuthMiddleware']);

$app->router->get('/suppliers',         'SupplierController@index',  ['AuthMiddleware']);
$app->router->get('/suppliers/create',  'SupplierController@create', ['AuthMiddleware']);
$app->router->post('/suppliers/store',  'SupplierController@store',  ['AuthMiddleware']);
$app->router->get('/suppliers/edit',    'SupplierController@edit',   ['AuthMiddleware']);
$app->router->post('/suppliers/update', 'SupplierController@update', ['AuthMiddleware']);
$app->router->post('/suppliers/delete', 'SupplierController@delete', ['AuthMiddleware']);

$app->router->get('/items',         'ItemController@index',  ['AuthMiddleware']);
$app->router->get('/items/create',  'ItemController@create', ['AuthMiddleware']);
$app->router->post('/items/store',  'ItemController@store',  ['AuthMiddleware']);
$app->router->get('/items/edit',    'ItemController@edit',   ['AuthMiddleware']);
$app->router->post('/items/update', 'ItemController@update', ['AuthMiddleware']);
$app->router->post('/items/delete', 'ItemController@delete', ['AuthMiddleware']);

$app->router->get('/sales',        'SalesController@index',  ['AuthMiddleware']);
$app->router->get('/sales/create', 'SalesController@create', ['AuthMiddleware']);
$app->router->post('/sales/store', 'SalesController@store',  ['AuthMiddleware']);
$app->router->get('/sales/show',   'SalesController@show',   ['AuthMiddleware']);
