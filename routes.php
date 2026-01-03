<?php

$router->get('/', 'Home@index');
$router->get('/about', 'About@index');
$router->get('/contact', 'Contact@index');
$router->get('/auth/login', 'Auth\\Login@index');
$router->get('/auth/register', 'Auth\\Register@index');
