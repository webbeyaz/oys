<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin;
use PDO;

class Users extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$sql = "
			
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		$this->data['users'] = $query;

		return $this->view('admin.pages.users.index', $this->data);
	}
}
