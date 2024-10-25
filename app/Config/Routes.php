<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// system routes
$routes->get('/', 'Dashboard::index');
$routes->get('login', 'Login::index');
$routes->get('menu/add', 'Menu::addData');
$routes->get('menu/edit/(:num)', 'Menu::editData/$1');
$routes->get('user-managements', 'User_managements::index');
$routes->get('user-managements/add', 'User_managements::addData');
$routes->get('user-managements/edit/(:num)', 'User_managements::editData/$1');
$routes->get('user-group', 'User_group::index');
$routes->get('group-permission', 'Group_permission::index');

// Menu Master
// Data Anggota
$routes->get('data-anggota', 'Data_anggota::index');
$routes->get('data_anggota/listData', 'Data_anggota::listData');
$routes->get('data-anggota/add', 'Data_anggota::addData');
$routes->get('data-anggota/edit/(:num)', 'Data_anggota::editData/$1');
$routes->get('data-anggota/detail/(:num)', 'Data_anggota::detailData/$1');
// $routes->get('data_anggota/deleteData/(:num)', 'Data_anggota::deleteData/$1'); 

// Produk Master
$routes->get('produk-master', 'Produk_master::index');
$routes->get('produk_master/add', 'Produk_master::addData');
$routes->get('produk_master/edit/(:num)', 'Produk_master::editData/$1');