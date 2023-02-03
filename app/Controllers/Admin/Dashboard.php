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

		return $this->view('admin.pages.dashboard', $this->data);
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
			'event' => 0
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

		$this->data['statistics'] = $statistics;
	}
}
