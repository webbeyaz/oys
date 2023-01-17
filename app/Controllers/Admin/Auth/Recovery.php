<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\Admin;

class Recovery extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		return $this->view('admin.pages.auth.recovery', $this->data);
	}
}
