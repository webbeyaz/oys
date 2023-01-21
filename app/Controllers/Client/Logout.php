<?php

namespace App\Controllers\Client;

use App\Controllers\Client;

class Logout extends Client
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_COOKIE['login']))
		{
			header('Location: ' . site_url('welcome'));
			exit;
		}
	}

	/**
	 * @return string
	 */
	public function index(): string
	{
		return $this->view('client.pages.logout', $this->data);
	}
}
