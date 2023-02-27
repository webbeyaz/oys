<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;

class Add extends Admin
{
	public function __construct()
	{
		parent::__construct();
	}

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
					'lastname',
					'email'
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
				$email = $data['email'];
				$phone = $data['phone'];

				$sql = "
					INSERT INTO users SET
					username = ?,
					password = ?,
					firstname = ?,
					lastname = ?,
					email = ?,
					phone = ?,
					created_by = ?,
					updated_by = ?
				";

				$query = $this->db->prepare($sql);

				$insert = $query->execute([
					$username,
					$password,
					$firstname,
					$lastname,
					$email,
					$phone,
					$this->data['user']->id,
					$this->data['user']->id
				]);

				if ($insert)
				{
					$message = [
						'class' => 'success',
						'text' => 'Kullanıcı başarılı bir şekilde eklendi.'
					];
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve kullanıcı eklenemedi.'
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

		return $this->view('admin.pages.users.add', $this->data);
	}
}
