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
			    e.id AS eid,
			    e.username AS username,
			    e.firstname AS firstname,
			    e.lastname AS lastname,
			    a.time AS time
			FROM actions a
			INNER JOIN codes c ON c.id = a.code_id
			INNER JOIN employees e ON e.id = c.employee_id
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
				        e.id AS id,
					    a.time AS time
					FROM actions a
					INNER JOIN codes c ON c.id = a.code_id
					INNER JOIN employees e ON e.id = c.employee_id
					WHERE c.id > $i
				 ";

				$queryOut = $this->db->query($sql, PDO::FETCH_OBJ);

				foreach ($queryOut as $rowOut)
				{
					if ($rowIn->eid == $rowOut->id)
					{
						$tracking[$i]['time_out'] = $rowOut->time;
						break;
					}
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
