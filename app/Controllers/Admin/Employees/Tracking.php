<?php

namespace App\Controllers\Admin\Employees;

use App\Controllers\Admin;
use PDO;
use Symfony\Component\HttpFoundation\Request;

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
	 * @param Request $request
	 * @return string|void
	 */
	public function report(Request $request)
	{
		$error = [];
		$reports = [];
		$total = 0;

		$dateStart = null;
		$dateEnd = null;

		if ($request->getMethod() == 'POST')
		{
			$rules = [
				'required' => [
					'employee',
					'start',
					'end'
				]
			];

			$this->validator->rules($rules);

			if ($this->validator->validate())
			{
				$data = $this->validator->data();

				$employee = $data['employee'];
				$start = $data['start'];
				$end = $data['end'];

				$dateStart = $start;
				$dateEnd = $end;

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
					WHERE
					    a.employee_id = $employee
					    AND
					    (DATE(a.start_time) >= '{$start}' AND DATE(a.end_time) <= '{$end}')
				";

				$query = $this->db->query($sql, PDO::FETCH_OBJ);

				if ($query->rowCount())
				{
					$reports = $query;

					$sql = "
						SELECT
						    start_time,
						    end_time
						FROM actions
						WHERE
						    employee_id = $employee
						    AND
						    (DATE(start_time) >= '{$start}' AND DATE(end_time) <= '{$end}')
					";

					$query = $this->db->query($sql, PDO::FETCH_OBJ);

					if ($query->rowCount())
					{
						foreach ($query as $row)
						{
							$diff = timeDiffHoursWithDecimal($row->start_time, $row->end_time);
							$total += $diff;
						}

						$total = floatval($total) != intval($total) ? number_format($total, 1, ',', '') : intval($total);
					}
				}
			}
			else
			{
				$error = [
					'class' => 'warning',
					'text' => 'Lütfen tüm alanları seçiniz.'
				];
			}
		}
		else
		{
			header('Location: ' . site_url('admin/employees/tracking'));
			exit;
		}

		$this->data['error'] = $error;
		$this->data['reports'] = $reports;
		$this->data['total'] = $total;
		$this->data['dateStart'] = $dateStart;
		$this->data['dateEnd'] = $dateEnd;

		return $this->view('admin.pages.employees.report', $this->data);
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
