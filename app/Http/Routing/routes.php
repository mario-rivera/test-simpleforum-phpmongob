<?php
$r->addRoute('GET', '/', ['App\Http\Controllers\HomeController', 'getHome']);

$r->addRoute('GET', '/auth/login', ['App\Http\Controllers\LoginController', 'getLogin']);
$r->addRoute('POST', '/auth/login', ['App\Http\Controllers\LoginController', 'postLogin']);

$r->addRoute('GET', '/auth/logout', ['App\Http\Controllers\LogoutController', 'getLogout']);

$r->addRoute('GET', '/auth/register', ['App\Http\Controllers\RegisterController', 'getRegister']);
$r->addRoute('POST', '/auth/register', ['App\Http\Controllers\RegisterController', 'postRegister']);

$r->addRoute('GET', '/threads/new', ['App\Http\Controllers\ThreadsAuthenticatedController', 'getNew']);
$r->addRoute('POST', '/threads/new', ['App\Http\Controllers\ThreadsAuthenticatedController', 'postNew']);
$r->addRoute('GET', '/threads/{id}', ['App\Http\Controllers\ThreadsController', 'getThread']);
$r->addRoute('GET', '/threads/{id}/vote', ['App\Http\Controllers\ThreadsAuthenticatedController', 'getVote']);

$r->addRoute('GET', '/posts/new', ['App\Http\Controllers\PostsAuthenticatedController', 'getNew']);
$r->addRoute('POST', '/posts/new', ['App\Http\Controllers\PostsAuthenticatedController', 'postNew']);
$r->addRoute('GET', '/posts/{id}/vote', ['App\Http\Controllers\PostsAuthenticatedController', 'getVote']);
