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
				d.id AS id,
			    d.firstname AS firstname,
			    d.lastname AS lastname,
			    d.email AS email,
			    d.phone AS phone,
			    v.plate AS plate,
			    d.created_at AS created_at
			FROM drivers d
			INNER JOIN vehicles v ON v.id = d.vehicle_id
			WHERE d.deleted_at IS NULL
			ORDER BY d.updated_at DESC, d.id DESC
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
