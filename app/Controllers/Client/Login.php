<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use PDO;

class Login extends Client
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $slug
	 * @return string
	 */
	public function index($slug): string
	{
		$message = [];

		$sql = "
			
		";

		$this->data['message'] = $message;

		return $this->view('client.pages.login', $this->data);
	}
}
