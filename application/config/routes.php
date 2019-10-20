<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['admin/metode_pembayaran']['get'] = '/admin/admin/metode_pembayaran';
$route['admin/produk']['get'] = '/admin/admin/produk';
$route['admin/pegawai']['get'] = '/admin/admin/pegawai';
$route['admin/cabang']['get'] = '/admin/admin/cabang';
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

//SINGLE API MASTER PRODUK
$route['sapi/admin_produk/get_all']['GET'] = '/singleapi/AdminProduk/get_all';
$route['sapi/admin_produk/read']['POST'] = '/singleapi/AdminProduk/get';
$route['sapi/admin_produk/create']['POST'] = '/singleapi/AdminProduk/add';
$route['sapi/admin_produk/update']['POST'] = '/singleapi/AdminProduk/edit';
$route['sapi/admin_produk/delete']['POST'] = '/singleapi/AdminProduk/remove';

//SINGLE API CUSTOMER
$route['sapi/customer/get_all']['GET'] = '/singleapi/customer/get_all';
$route['sapi/customer/read']['POST'] = '/singleapi/customer/get';
$route['sapi/customer/create']['POST'] = '/singleapi/customer/add';
$route['sapi/customer/update']['POST'] = '/singleapi/customer/edit';
$route['sapi/customer/delete']['POST'] = '/singleapi/customer/remove';

//SINGLE API JENIS
$route['sapi/jenis/get_all']['GET'] = '/singleapi/jenis/get_all';
$route['sapi/jenis/read']['POST'] = '/singleapi/jenis/get';
$route['sapi/jenis/create']['POST'] = '/singleapi/jenis/add';
$route['sapi/jenis/update']['POST'] = '/singleapi/jenis/edit';
$route['sapi/jenis/delete']['POST'] = '/singleapi/jenis/remove';

//SINGLE API KATEGORI
$route['sapi/kategori/get_all']['GET'] = '/singleapi/kategori/get_all';
$route['sapi/kategori/read']['POST'] = '/singleapi/kategori/get';
$route['sapi/kategori/create']['POST'] = '/singleapi/kategori/add';
$route['sapi/kategori/update']['POST'] = '/singleapi/kategori/edit';
$route['sapi/kategori/delete']['POST'] = '/singleapi/kategori/remove';

//SINGLE API PEGAWAI
$route['sapi/pegawai/get_all']['GET'] = '/singleapi/pegawai/get_all';
$route['sapi/pegawai/read']['POST'] = '/singleapi/pegawai/get';
$route['sapi/pegawai/create']['POST'] = '/singleapi/pegawai/add';
$route['sapi/pegawai/update']['POST'] = '/singleapi/pegawai/edit';
$route['sapi/pegawai/delete']['POST'] = '/singleapi/pegawai/remove';

//SINGLE API CUSTOMER
$route['sapi/customer/createExUsrPass']['POST'] = '/singleapi/customer/createExUsrPass';
$route['sapi/customer/updateUsrPass']['POST'] = '/singleapi/customer/updateUsrPass';
$route['sapi/customer/getByNumber']['POST'] = '/singleapi/customer/getByNumber';
$route['sapi/customer/updatePass']['POST'] = '/singleapi/customer/updatePass';
$route['sapi/customer/updateUserPassByNoTelp']['POST'] = '/singleapi/customer/updateUserPassByNoTelp';

//SINGLE API CABANG
$route['sapi/cabang/get_all']['GET'] = '/singleapi/cabang/get_all';
$route['sapi/cabang/read']['POST'] = '/singleapi/cabang/get';
$route['sapi/cabang/create']['POST'] = '/singleapi/cabang/add';
$route['sapi/cabang/update']['POST'] = '/singleapi/cabang/edit';
$route['sapi/cabang/delete']['POST'] = '/singleapi/cabang/remove';

//API ADMIN

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
