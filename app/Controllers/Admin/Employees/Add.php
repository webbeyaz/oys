<?php

namespace App\Controllers\Admin\Employees;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;

class Add extends Admin
{
	/**
	 * @param Request $request
	 * @return string
	 */
	public function index(Request $request): string
	{
		$message = [];

		if ($request->getMethod() == 'POST')
		{
			$rules = [
				'required' => [
					'username',
					'password',
					'firstname',
					'lastname'
				]
			];

			$this->validator->rules($rules);

			if ($this->validator->validate())
			{
				$data = $this->validator->data();

				$username = $data['username'];
				$password = md5($data['password']);
				$firstname = $data['firstname'];
				$lastname = $data['lastname'];
				// $status = $data['status']; TODO: İleride aktif edilebilir.

				$sql = "
					INSERT INTO employees SET
					username = ?,
					password = ?,
					firstname = ?,
					lastname = ?,
					created_by = ?,
					updated_by = ?
				";

				$query = $this->db->prepare($sql);

				$insert = $query->execute([
					$username,
					$password,
					$firstname,
					$lastname,
					$this->data['user']->id,
					$this->data['user']->id
				]);

				if ($insert)
				{
					$message = [
						'class' => 'success',
						'text' => 'Personel başarılı bir şekilde eklendi.'
					];
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve personel eklenemedi.'
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

		$this->data['message'] = $message;

		return $this->view('admin.pages.employees.add', $this->data);
	}
}
