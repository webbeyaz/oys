<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin;
use PDO;

class Dashboard extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$this->statistics();
		$this->tracking();

		return $this->view('admin.pages.dashboard', $this->data);
	}

	public function tracking()
	{
		$tracking = [];

		$sql = "
			SELECT
			    a.id AS id,
			    e.id AS employee_id,
			    e.username AS username,
			    e.firstname AS firstname,
			    e.lastname AS lastname,
			    a.agent_start AS agent_start,
			    a.agent_end AS agent_end,
			    a.start_time AS start_time,
			    a.end_time AS end_time
			FROM actions a
			INNER JOIN employees e ON e.id = a.employee_id
			ORDER BY a.id DESC
			LIMIT 10
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$tracking = $query;
		}

		$this->data['tracking'] = $tracking;
	}

	/**
	 * @return void
	 */
	public function statistics(): void
	{
		$statistics = [
			'employee' => 0,
			'driver' => 0,
			'vehicle' => 0,
			'event' => 0,
			'action' => 0
		];

		$sql = "
			SELECT
				COUNT(id) AS total
			FROM employees
			WHERE deleted_at IS NULL
		";

		$queryEmployee = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($queryEmployee)
		{
			$statistics['employee'] = $queryEmployee->total;
		}

		$sql = "
			SELECT
				COUNT(id) AS total
			FROM drivers
			WHERE deleted_at IS NULL
		";

		$queryDriver = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($queryDriver)
		{
			$statistics['driver'] = $queryDriver->total;
		}

		$sql = "
			SELECT
				COUNT(id) AS total
			FROM vehicles
			WHERE deleted_at IS NULL
		";

		$queryVehicle = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($queryVehicle)
		{
			$statistics['vehicle'] = $queryVehicle->total;
		}

		$sql = "
			SELECT
				COUNT(id) AS total
			FROM events
			WHERE deleted_at IS NULL
		";

		$queryEvent = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($queryEvent)
		{
			$statistics['event'] = $queryEvent->total;
		}

		$sql = "
			SELECT
				COUNT(id) AS total
			FROM actions
			WHERE
			    start_time IS NOT NULL
				AND
			    end_time IS NOT NULL
		";

		$queryAction = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($queryAction)
		{
			$statistics['action'] = $queryAction->total;
		}

		$this->data['statistics'] = $statistics;
	}
}
