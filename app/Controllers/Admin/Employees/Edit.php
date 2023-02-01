<?php

namespace App\Controllers\Admin\Employees;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Edit extends Admin
{
	/**
	 * @param $id
	 * @param Request $request
	 * @return string
	 */
	public function index($id, Request $request): string
	{
		$message = [];
		$employee = null;

		$sql = "
			SELECT
			    username,
			    password,
			    firstname,
			    lastname
			FROM employees
			WHERE id = '{$id}'
		";

		$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($query)
		{
			$employee = $query;
		}
		else
		{
			header('Location: ' . site_url('admin/employees/list'));
			exit;
		}

		if ($request->getMethod() == 'POST')
		{
			$rules = [
				'required' => [
					'username',
					'firstname',
					'lastname'
				]
			];

			$this->validator->rules($rules);

			if ($this->validator->validate())
			{
				$data = $this->validator->data();

				$username = $data['username'];
				$password = $data['password'] ? md5($data['password']) : $employee->password;
				$firstname = $data['firstname'];
				$lastname = $data['lastname'];
				// $status = $data['status']; TODO: İleride aktif edilebilir.

				$sql = "
					UPDATE employees SET
					username = :username,
					password = :password,
					firstname = :firstname,
					lastname = :lastname,
					updated_by = :updated_by,
					updated_at = :updated_at
					WHERE id = :id
				";

				$query = $this->db->prepare($sql);

				$update = $query->execute([
					'username' => $username,
					'password' => $password,
					'firstname' => $firstname,
					'lastname' => $lastname,
					'updated_by' => $this->data['user']->id,
					'updated_at' => date('Y-m-d H:i:s'),
					'id' => $id
				]);

				if ($update)
				{
					$message = [
						'class' => 'success',
						'text' => 'Personel başarılı bir şekilde güncellendi.'
					];
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve personel güncellenemedi.'
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

		$this->data['employee'] = $employee;
		$this->data['message'] = $message;

		return $this->view('admin.pages.employees.edit', $this->data);
	}
}
