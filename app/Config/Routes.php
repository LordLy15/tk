<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman Utama Langsung Dashboard Publik
$routes->get('/', 'Home::index');

// Login & Auth
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// Dashboard Internal Guru
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->post('saveSiswa', 'Dashboard::saveSiswa');
    $routes->get('deleteSiswa/(:num)', 'Dashboard::deleteSiswa/$1');
    $routes->post('saveGuru', 'Dashboard::saveGuru');
});