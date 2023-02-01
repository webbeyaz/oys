<?php

namespace App\Controllers\Admin\Employees;

use App\Controllers\Admin;
use PDO;

class Tracking extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$tracking = [];

		$sql = "
			SELECT
			    a.id AS action_id,
			    e.id AS employee_id,
			    e.username AS username,
			    e.firstname AS firstname,
			    e.lastname AS lastname,
			    a.time AS time
			FROM actions a
			INNER JOIN codes c ON c.id = a.code_id
			INNER JOIN employees e ON e.id = c.employee_id
		";

		$queryIn = $this->db->query($sql, PDO::FETCH_OBJ);

		$i = 0;

		foreach ($queryIn as $rowIn)
		{
			$action_id = $rowIn->action_id;
			$employee_id = $rowIn->employee_id;

			$time = $rowIn->time;
			$explode = explode(' ', $time);
			$date = $explode[0];

			$tracking[$i] = [
				'username' => $rowIn->username,
				'firstname' => $rowIn->firstname,
				'lastname' => $rowIn->lastname,
				'time_in' => $rowIn->time,
				'time_out' => null
			];

			$sql = "
				SELECT
				    a.time AS time
				FROM actions a
				INNER JOIN codes c ON c.id = a.code_id
				INNER JOIN employees e ON e.id = c.employee_id
				WHERE
				    a.id != $action_id
					AND
				    e.id = $employee_id
					AND
				    DATE(a.time) = '$date'
			";

			$queryOut = $this->db->query($sql, PDO::FETCH_OBJ);

			if ($queryOut->rowCount())
			{
				foreach ($queryOut as $rowOut)
				{
					$tracking[$i]['time_out'] = $rowOut->time;
				}
			}

			$i++;
		}

		echo '<pre>';
		print_r($tracking);
		exit;

		$this->data['tracking'] = $tracking;

		return $this->view('admin.pages.employees.tracking', $this->data);
	}
}
