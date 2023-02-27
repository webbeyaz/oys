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
		$vehicles = [];

		$sql = "
			SELECT
			    v.id AS id,
				v.plate AS plate,
				v.chassis AS chassis,
				v.created_at AS created_at,
				d.firstname AS firstname,
				d.lastname AS lastname
			FROM vehicles v
			LEFT JOIN drivers d ON d.vehicle_id = v.id
			WHERE v.deleted_at IS NULL
			ORDER BY v.updated_at DESC, v.id DESC
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
