<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin;

class Dashboard extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		return $this->view('admin.pages.dashboard', $this->data);
	}
}
