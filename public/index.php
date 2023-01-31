<?php

session_start();

require '../src/config/config.php';
require '../vendor/autoload.php';
require SRC . 'helper.php';

$router = new Blog\Router($_SERVER["REQUEST_URI"]);
$router->get('/', "BlogController@index");
$router->get('/login/', "UserController@showLogin");
$router->get('/register/', "UserController@showRegister");
$router->get('/logout/', "UserController@logout");
$router->get('/dashboard/', "BlogController@showAll");
$router->get('/dashboard/nouveau/', "BlogController@create");
$router->get('/dashboard/:Blog/', "BlogController@show");
$router->get('/dashboard/:Blog/delete/', "BlogController@delete");

$router->post('/login/', "UserController@login");
$router->post('/register/', "UserController@register");
$router->post('/dashboard/nouveau/', "BlogController@store");
$router->post('/dashboard/:Blog/createUpdate/', "BlogController@createUpdate");
$router->post('/dashboard/:Blog/update/', "BlogController@update");
$router->post('/dashboard/comment/nouveau', "CommentController@store");

$router->run();
