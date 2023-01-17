<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin;

class Error extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		return $this->view('admin.pages.error', $this->data);
	}
}
