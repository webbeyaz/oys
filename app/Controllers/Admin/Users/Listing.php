<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\Admin;
use PDO;

class Listing extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$users = [];

		$sql = "
			SELECT
			    id,
				username,
				firstname,
				lastname,
				email,
				phone,
				role,
				created_at
			FROM users
			WHERE deleted_at IS NULL
			ORDER BY updated_at DESC, id DESC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$users = $query;
		}

		$this->data['users'] = $users;

		return $this->view('admin.pages.users.listing', $this->data);
	}
}
