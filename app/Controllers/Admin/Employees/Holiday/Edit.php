<?php

namespace App\Controllers\Admin\Employees\Holiday;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Edit extends Admin
{
	public function __construct()
	{
		parent::__construct();

		$this->employees();
	}

	/**
	 * @param $id
	 * @param Request $request
	 * @return string
	 */
	public function index($id, Request $request): string
	{
		$message = [];
		$holiday = null;

		$sql = "
			SELECT
			    employee_id,
			    date_start,
			    date_end
			FROM holidays
			WHERE id = '{$id}'
		";

		$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($query)
		{
			$holiday = $query;
		}
		else
		{
			header('Location: ' . site_url('admin/employees/holiday'));
			exit;
		}

		if ($request->getMethod() == 'POST')
		{
			$rules = [
				'required' => [
					'employee_id',
					'date_start',
					'date_end'
				]
			];

			$this->validator->rules($rules);

			if ($this->validator->validate())
			{
				$data = $this->validator->data();

				$employee_id = $data['employee_id'];
				$date_start = $data['date_start'];
				$date_end = $data['date_end'];

				$sql = "
					UPDATE holidays SET
					employee_id = :employee_id,
					date_start = :date_start,
					date_end = :date_end,
					updated_by = :updated_by,
					updated_at = :updated_at
					WHERE id = :id
				";

				$query = $this->db->prepare($sql);

				$update = $query->execute([
					'employee_id' => $employee_id,
					'date_start' => $date_start,
					'date_end' => $date_end,
					'updated_by' => $this->data['user']->id,
					'updated_at' => date('Y-m-d H:i:s'),
					'id' => $id
				]);

				if ($update)
				{
					$message = [
						'class' => 'success',
						'text' => 'Personel izni başarılı bir şekilde güncellendi.'
					];
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve personel izni güncellenemedi.'
					];
				}
			}
			else
			{
				$message = [
					'class' => 'warning',
					'text' => 'Lütfen boş alan bırakmayın.'
				];
			}
		}

		$this->data['holiday'] = $holiday;
		$this->data['message'] = $message;

		return $this->view('admin.pages.employees.holiday.edit', $this->data);
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
			ORDER BY firstname ASC, lastname ASC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$employees = $query;
		}

		$this->data['employees'] = $employees;
	}
}
