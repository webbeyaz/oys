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
			$i = 0;

			foreach ($queryIn as $rowIn)
			{
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
				";

				$queryOut = $this->db->query($sql, PDO::FETCH_OBJ);

				if ($queryOut)
				{
					foreach ($queryOut as $rowOut)
					{
						$explodeIn = explode(' ', $rowIn->time);
						$explodeOut = explode(' ', $rowOut->time);

						if ($explodeIn[0] == $explodeOut[0])
						{
							$tracking[$i]['time_out'] = $rowOut->time;
						}
					}
				}

				$i++;
			}
		}

		echo '<pre>';
		print_r($tracking);
		exit;

		$this->data['tracking'] = $tracking;

		return $this->view('admin.pages.employees.tracking', $this->data);
	}
}
