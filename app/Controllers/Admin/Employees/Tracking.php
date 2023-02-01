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
			    a.id AS id,
			    e.username AS username,
			    e.firstname AS firstname,
			    e.lastname AS lastname,
			    a.time AS time
			FROM actions a
			INNER JOIN codes c ON c.id = a.code_id
			INNER JOIN employees e ON e.id = c.employee_id
			ORDER BY a.time ASC
			GROUP BY a.time
		";

		$queryIn = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($queryIn)
		{
			foreach ($queryIn as $rowIn)
			{
				$i = $rowIn->id;

				$tracking[$i] = [
					'username' => $rowIn->username,
					'firstname' => $rowIn->firstname,
					'lastname' => $rowIn->lastname,
					'time_in' => $rowIn->time
				];

				 $sql = "
				    SELECT
					    a.time AS time
					FROM actions a
					INNER JOIN codes c ON c.id = a.code_id
					INNER JOIN employees e ON e.id = c.employee_id
					WHERE c.id > $i
					ORDER BY a.time ASC
					GROUP BY a.time
				 ";

				$queryOut = $this->db->query($sql, PDO::FETCH_OBJ);

				foreach ($queryOut as $rowOut)
				{
					$tracking[$i]['time_out'] = $rowOut->time;
				}
			}
		}

		echo '<pre>';
		print_r($tracking);
		exit;

		$this->data['tracking'] = $tracking;

		return $this->view('admin.pages.employees.tracking', $this->data);
	}
}
