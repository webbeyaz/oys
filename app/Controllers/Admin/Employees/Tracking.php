<?php

namespace App\Controllers\Admin\Employees;

use App\Controllers\Admin;

class Tracking extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		return $this->view('admin.pages.employees.tracking', $this->data);
	}
}
