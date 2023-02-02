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

			$timeIn = $rowIn->time;
			$explode = explode(' ', $timeIn);

			$date = $explode[0];
			$time = $explode[1];

			$tracking[$i] = [
				'username' => $rowIn->username,
				'firstname' => $rowIn->firstname,
				'lastname' => $rowIn->lastname,
				'time_in' => strtotime($time) < strtotime('17:30:00') ? $timeIn : null,
				'time_out' => strtotime($time) < strtotime('17:30:00') ? null : $timeIn,
				'date' => $date
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

			foreach ($queryOut as $rowOut)
			{
				$explode = explode(' ', $rowOut->time);
				$time = $explode[1];

				$tracking[$i]['time_out'] = strtotime($time) > strtotime('17:30:00') ? date('Y-m-d H:i:s', strtotime('17:30:00')) : $rowOut->time;

				if ($rowOut->time < $timeIn)
				{
					unset($tracking[$i]);
				}
			}

			$i++;
		}

		$this->data['tracking'] = $tracking;

		return $this->view('admin.pages.employees.tracking', $this->data);
	}
}
