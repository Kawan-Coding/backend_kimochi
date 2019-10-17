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
$route['sapi/metode_pembayaran/get']['POST'] = '/singleapi/MetodePembayaran/get';
$route['sapi/metode_pembayaran/add']['POST'] = '/singleapi/MetodePembayaran/add';
$route['sapi/metode_pembayaran/edit']['POST'] = '/singleapi/MetodePembayaran/edit';
$route['sapi/metode_pembayaran/remove']['POST'] = '/singleapi/MetodePembayaran/remove';


$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
