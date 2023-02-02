<?php

namespace App\Controllers\Admin\Vehicles;

use App\Controllers\Admin;
use PDO;

class Tracking extends Admin
{
	public function __construct()
	{
		parent::__construct();


	}

	/**
	 * @return string
	 */
	public function index(): string
	{
		$events = [];

		$sql = "
			SELECT
			    e.id AS id,
			    d.firstname AS firstname,
			    d.lastname AS lastname,
			    v.plate AS plate,
			    e.text AS text,
			    e.images AS images,
			    e.created_at AS created_at
			FROM events e
			WHERE e.deleted_at IS NULL
			ORDER BY e.updated_at DESC, e.id DESC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$events = $query;
		}

		$this->data['vehicles'] = $events;

		return $this->view('admin.pages.vehicles.tracking.list', $this->data);
	}
}
