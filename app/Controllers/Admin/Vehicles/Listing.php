<?php

namespace App\Controllers\Admin\Vehicles;

use App\Controllers\Admin;
use PDO;

class Listing extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$vehicles = [];

		$sql = "
			SELECT
			    id,
				plate,
				chassis,
				created_at
			FROM vehicles
			WHERE deleted_at IS NULL
			ORDER BY updated_at DESC, id DESC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$vehicles = $query;
		}

		$this->data['vehicles'] = $vehicles;

		return $this->view('admin.pages.vehicles.listing', $this->data);
	}
}
