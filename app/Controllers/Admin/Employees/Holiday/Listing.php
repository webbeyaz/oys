<?php

namespace App\Controllers\Admin\Employees\Holiday;

use App\Controllers\Admin;
use PDO;

class Listing extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$holidays = [];

		$sql = "
			SELECT
				h.id AS id,
				e.username AS username,
				e.firstname AS firstname,
				e.lastname AS lastname,
				h.date_start AS date_start,
				h.date_end AS date_end,
				h.created_at AS created_at
			FROM holidays h
			INNER JOIN employees e ON e.id = h.employee_id
			WHERE
			    h.deleted_at IS NULL
				AND
			    (e.status = 1 AND e.deleted_at IS NULL)
			ORDER BY h.updated_at DESC, h.id DESC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$holidays = $query;
		}

		$this->data['holidays'] = $holidays;

		return $this->view('admin.pages.employees.holiday.listing', $this->data);
	}
}
