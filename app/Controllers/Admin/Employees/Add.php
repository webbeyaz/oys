<?php

namespace App\Controllers\Admin\Employees;

use App\Controllers\Admin;

class Add extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$message = [];


		$this->data['message'] = $message;

		return $this->view('admin.pages.employees.add', $this->data);
	}
}
