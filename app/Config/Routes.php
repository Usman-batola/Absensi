<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth Routes
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::register');
$routes->get('/auth/logout', 'Auth::logout');

// User Routes
$routes->get('/user/dashboard', 'User::dashboard');
$routes->post('/user/check-location', 'User::checkLocation');
$routes->post('/user/save-absensi', 'User::saveAbsensi');
$routes->get('/user/history', 'User::history');

// Admin Routes
$routes->get('/admin/dashboard', 'Admin::dashboard');

// Admin Users Routes
$routes->get('/admin/users', 'Admin::users');
$routes->get('/admin/add-user', 'Admin::addUser');
$routes->post('/admin/add-user', 'Admin::addUser');
$routes->get('/admin/edit-user/(:num)', 'Admin::editUser/$1');
$routes->post('/admin/edit-user/(:num)', 'Admin::editUser/$1');
$routes->get('/admin/delete-user/(:num)', 'Admin::deleteUser/$1');

// Admin Lokasi Routes
$routes->get('/admin/lokasi', 'Admin::lokasi');
$routes->get('/admin/add-lokasi', 'Admin::addLokasi');
$routes->post('/admin/add-lokasi', 'Admin::addLokasi');
$routes->get('/admin/edit-lokasi/(:num)', 'Admin::editLokasi/$1');
$routes->post('/admin/edit-lokasi/(:num)', 'Admin::editLokasi/$1');
$routes->get('/admin/delete-lokasi/(:num)', 'Admin::deleteLokasi/$1');

// Admin Absensi Routes
$routes->get('/admin/absensi', 'Admin::absensi');
$routes->get('/admin/delete-absensi/(:num)', 'Admin::deleteAbsensi/$1');
