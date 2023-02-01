<?php

$app->router->notFound(function () {
	$error = new App\Controllers\Client\Error;

	if (segments(0) == 'admin')
	{
		$error = new App\Controllers\Admin\Error;
	}

	return $error->index();
});

$app->router->error(function () {
	$error = new App\Controllers\Client\Error;

	if (segments(0) == 'admin')
	{
		$error = new App\Controllers\Admin\Error;
	}

	return $error->index();
});

/*
 * Client Routes
 */
$app->router->get('/', 'Client.Home@index');
$app->router->any('/welcome', 'Client.Welcome@index');
$app->router->get('/login/:slug', 'Client.Login@index');
$app->router->get('/logged', 'Client.Logged@index');

/*
 * Admin Routes
 */
$app->router->group('/admin', function ($router) {
	$router->get('/', function () {
		header('Location: ' . site_url('admin/dashboard'));
		exit;
	});

	$router->any('/login', 'Admin.Auth.Login@index');
	$router->get('/logout', 'Admin.Auth.Logout@index');

	$router->group('/recovery', function ($router) {
		$router->any('/', 'Admin.Auth.Recovery@index');
		$router->get('/sent', 'Admin.Auth.Recovery@sent');
		$router->any('/sent/:slug', 'Admin.Auth.Recovery@token');
	});

	$router->get('/dashboard', 'Admin.Dashboard@index');

	$router->group('/employees', function ($router) {
		$router->get('/list', 'Admin.Employees.Listing@index');
		$router->get('/tracking', 'Admin.Employees.Tracking@index');
		$router->any('/add', 'Admin.Employees.Add@index');
		$router->any('/edit/:id', 'Admin.Employees.Edit@index');
	});

	$router->group('/users', function ($router) {
		$router->get('/', 'Admin.Users@index');
	});
}, ['before' => 'AdminCheckAuth']);

/*
 * API Routes
 */
$app->router->group('/api', function ($router) {
	$router->xget('/login', 'Api.Login@index');
});
