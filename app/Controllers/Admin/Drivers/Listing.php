<?php

namespace App\Controllers\Admin\Drivers;

use App\Controllers\Admin;
use PDO;

class Listing extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$drivers = [];

		$sql = "
			SELECT
				id,
			    firstname,
			    lastname,
			    email,
			    phone,
			    plate,
			    created_at
			FROM drivers
			INNER JOIN vehicles ON vehicles.id = drivers.vehicle_id
			WHERE deleted_at IS NULL
			ORDER BY updated_at DESC, id DESC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$drivers = $query;
		}

		$this->data['drivers'] = $drivers;

		return $this->view('admin.pages.employees.listing', $this->data);
	}
}
