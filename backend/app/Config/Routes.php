<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('login', 'UserController::login');
$routes->post('register', 'UserController::register');
$routes->get('user_info', 'UserController::userInfo');


//$routes->get('api/some-endpoint', 'ArticleController::index', ['filter' => 'jwtAuth']);

$routes->get('articles', 'ArticleController::index');
$routes->get('articles/search', 'ArticleController::search');
$routes->get('article/(:segment)', 'ArticleController::show/$1');
$routes->post('article', 'ArticleController::create',['filter' => 'jwtAuth']);
$routes->post('article/update/(:segment)', 'ArticleController::update/$1',['filter' => 'jwtAuth']);
$routes->delete('article/(:segment)', 'ArticleController::delete/$1');


//$routes->group('api', ['namespace' => 'App\API\v1'], static function ($routes) {
//    $routes->resource('users');
//});