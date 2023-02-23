<?php

namespace App\Controllers;

use Core\Controller;
use PDO;

class Admin extends Controller
{
	public array $data = [];

	public function __construct()
	{
		parent::__construct();

		$this->data['user'] = $this->user();
	}

	/**
	 * @return array|mixed|void
	 */
	public function user()
	{
		$result = [];

		$admin_login = session()->segment->get('admin_login');

		if ($admin_login)
		{
			$user_id = session()->segment->get('user_id');

			$sql = "
				SELECT
				    id,
				    username,
				    firstname,
				    lastname,
				    email,
				    phone,
				    role
				FROM users
				WHERE
				    (status = 1 AND deleted_at IS NULL)
					AND
				    id = '{$user_id}'
			";

			$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

			if ($query)
			{
				$result = $query;
			}
			else
			{
				header('Location: ' . site_url('admin/logout'));
				exit;
			}
		}

		return $result;
	}
}
