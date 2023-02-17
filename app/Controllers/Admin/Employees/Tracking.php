<?php

namespace App\Controllers\Admin\Employees;

use App\Controllers\Admin;
use PDO;

class Tracking extends Admin
{
	public function __construct()
	{
		parent::__construct();

		$this->employees();
	}

	/**
	 * @return string
	 */
	public function index(): string
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
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$tracking = $query;
		}

		$this->data['tracking'] = $tracking;

		return $this->view('admin.pages.employees.tracking', $this->data);
	}

	/**
	 * @return void
	 */
	public function employees(): void
	{
		$employees = [];

		$sql = "
			SELECT
			    id,
			    firstname,
			    lastname
			FROM employees
			WHERE deleted_at IS NULL
			ORDER BY updated_at DESC, id DESC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$employees = $query;
		}

		$this->data['employees'] = $employees;
	}
}
