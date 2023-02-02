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
	public function list(): string
	{
		$events = [];
		$images = [];

		$sql = "
			SELECT
			    e.id AS id,
			    d.firstname AS firstname,
			    d.lastname AS lastname,
			    v.plate AS plate,
			    e.text AS text,
			    e.created_at AS created_at
			FROM events e
			INNER JOIN drivers d ON d.id = e.driver_id
			INNER JOIN vehicles v ON v.id = d.vehicle_id
			WHERE e.deleted_at IS NULL
			ORDER BY e.updated_at DESC, e.id DESC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$events = $query;

			foreach ($events as $event)
			{
				$id = $event->id;

				$sql = "
					SELECT
					    image
					FROM images
					WHERE event_id = $id
				";

				$query = $this->db->query($sql, PDO::FETCH_OBJ);

				if ($query->rowCount())
				{
					foreach ($query as $row)
					{
						$images[][$id] = $row->image;
					}
				}
			}
		}

		$this->data['events'] = $events;
		$this->data['images'] = $images;

		return $this->view('admin.pages.vehicles.tracking.list', $this->data);
	}
}
