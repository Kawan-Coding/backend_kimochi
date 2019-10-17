<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//=====ROUTE API
// CASH REGISTER
$route['api/cashregister/open']['POST'] = '/api/CashRegisterController/open';
$route['api/cashregister/close']['POST'] = '/api/CashRegisterController/close';

// API CRUD USER 
$route['api/user/(:num)']['GET'] = '/api/UserController/get/$1';
$route['api/user/register']['POST'] = '/api/UserController/register';
$route['api/user/update']['POST'] = '/api/UserController/update';
// API AUTH USER
$route['api/user/login']['POST'] = '/api/UserController/login';
$route['api/user/logout']['POST'] = '/api/UserController/logout';

//SINGLE API METODE PEMBAYARAN penamaaan inisiatif promrammer
$route['sapi/metode_pembayaran/get_all']['GET'] = '/singleapi/MetodePembayaran/get_all';
$route['sapi/metode_pembayaran/read']['POST'] = '/singleapi/MetodePembayaran/get';
$route['sapi/metode_pembayaran/create']['POST'] = '/singleapi/MetodePembayaran/add';
$route['sapi/metode_pembayaran/update']['POST'] = '/singleapi/MetodePembayaran/edit';
$route['sapi/metode_pembayaran/delete']['POST'] = '/singleapi/MetodePembayaran/remove';

//SINGLE API ADMIN PRODUK
$route['sapi/admin_produk/get_all']['GET'] = '/singleapi/AdminProduk/get_all';
$route['sapi/admin_produk/read']['POST'] = '/singleapi/AdminProduk/get';
$route['sapi/admin_produk/create']['POST'] = '/singleapi/AdminProduk/add';
$route['sapi/admin_produk/update']['POST'] = '/singleapi/AdminProduk/edit';
$route['sapi/admin_produk/delete']['POST'] = '/singleapi/AdminProduk/remove';

//API ADMIN

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
