<?php

namespace App\Controllers\Admin\Employees;

use App\Controllers\Admin;
use PDO;

class Listing extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$employees = [];

		$sql = "
			SELECT
			    id,
			    photo,
			    username,
			    firstname,
			    lastname,
			    status,
			    created_at
			FROM employees
			WHERE deleted_at IS NULL
			ORDER BY created_at DESC, id DESC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query)
		{
			$employees = $query;
		}

		$this->data['employees'] = $employees;

		return $this->view('admin.pages.employees.listing', $this->data);
	}
}
