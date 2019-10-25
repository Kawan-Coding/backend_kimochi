<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['admin/metode_pembayaran']['get'] = '/admin/admin/metode_pembayaran';
$route['admin/produk']['get'] = '/admin/admin/produk';
$route['admin/pegawai']['get'] = '/admin/admin/pegawai';
$route['admin/cabang']['get'] = '/admin/admin/cabang';
$route['admin/responsible']['get'] = '/admin/admin/responsible';
$route['admin/jenis']['get'] = '/admin/admin/jenis';
$route['admin/kategori']['get'] = '/admin/admin/kategori';
$route['admin/status_tranksaksi']['get'] = '/admin/admin/status_tranksaksi';
$route['admin/barang']['get'] = '/admin/admin/barang';
$route['admin/allowed_payment']['get'] = '/admin/admin/allowed_payment';
//=====ROUTE API
// CASH REGISTER
$route['api/cashregister/open']['POST'] = '/api/CashRegisterController/open';
$route['api/cashregister/close']['POST'] = '/api/CashRegisterController/close';

//API_GET
$route['api/api_get/get_data_booking']['GET'] = '/api/Api_Get/get_data_booking_where_status_booking';
$route['api/api_get/get_data_barang']['GET'] = '/api/Api_Get/get_data_barang';
$route['api/api_get/get_detail_aksesoris']['POST'] = '/api/Api_Get/get_detail_aksesoris';

//API_GET TRANSAKSI
$route['api/api_get/get_transaksi']['GET'] = '/api/Api_Get/get_transaksi';

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

//SINGLE RESPONSIBLE
$route['sapi/responsible/get_all']['GET'] = '/singleapi/responsible/get_all';
$route['sapi/responsible/read']['POST'] = '/singleapi/responsible/get';
$route['sapi/responsible/create']['POST'] = '/singleapi/responsible/add';
$route['sapi/responsible/update']['POST'] = '/singleapi/responsible/edit';
$route['sapi/responsible/delete']['POST'] = '/singleapi/responsible/remove';

//SINGLE status_transaksi
$route['sapi/status_transaksi/get_all']['GET'] = '/singleapi/StatusTransaksi/get_all';
$route['sapi/status_transaksi/read']['POST'] = '/singleapi/StatusTransaksi/get';
$route['sapi/status_transaksi/create']['POST'] = '/singleapi/StatusTransaksi/add';
$route['sapi/status_transaksi/update']['POST'] = '/singleapi/StatusTransaksi/edit';
$route['sapi/status_transaksi/delete']['POST'] = '/singleapi/StatusTransaksi/remove';

//SINGLE BARANG
$route['sapi/barang/get_all']['GET'] = '/singleapi/Barang/get_all';
$route['sapi/barang/read']['POST'] = '/singleapi/Barang/get';
$route['sapi/barang/create']['POST'] = '/singleapi/Barang/add';
$route['sapi/barang/update']['POST'] = '/singleapi/Barang/edit';
$route['sapi/barang/delete']['POST'] = '/singleapi/Barang/remove';

//SINGLE ALLOWED PAYMENT
$route['sapi/allowed_payment/get_all']['GET'] = '/singleapi/allowed_payment/get_all';
$route['sapi/allowed_payment/read']['POST'] = '/singleapi/allowed_payment/get';
$route['sapi/allowed_payment/create']['POST'] = '/singleapi/allowed_payment/add';
$route['sapi/allowed_payment/update']['POST'] = '/singleapi/allowed_payment/edit';
$route['sapi/allowed_payment/delete']['POST'] = '/singleapi/allowed_payment/remove';

//SINGLE TAKING ORDER
$route['api/ato/set_booking']['POST'] = '/api/Api_Taking_Order/set_taking_order_booking';
$route['api/ato/set_order']['POST'] = '/api/Api_Taking_Order/set_taking_order_order';



//API ADMIN

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
