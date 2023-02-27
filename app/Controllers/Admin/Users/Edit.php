<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Edit extends Admin
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $id
	 * @param Request $request
	 * @return string
	 */
	public function index($id, Request $request): string
	{
		$message = [];

		$sql = "
			SELECT
			    username,
			    password,
				firstname,
				lastname,
				email,
				phone,
				role
			FROM users
			WHERE id = '{$id}'
		";

		$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($query)
		{
			$user = $query;
		}
		else
		{
			header('Location: ' . site_url('admin/users/list'));
			exit;
		}

		if ($request->getMethod() == 'POST')
		{
			$rules = [
				'required' => [
					'username',
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
				$password = $data['password'] ? md5($data['password']) : $user->password;
				$firstname = $data['firstname'];
				$lastname = $data['lastname'];
				$email = $data['email'];
				$phone = $data['phone'];

				$sql = "
					UPDATE users SET
					username = :username,
					password = :password,
					firstname = :firstname,
					lastname = :lastname,
					email = :email,
					phone = :phone,
					updated_at = :updated_at
					WHERE id = :id
				";

				$query = $this->db->prepare($sql);

				$update = $query->execute([
					'username' => $username,
					'password' => $password,
					'firstname' => $firstname,
					'lastname' => $lastname,
					'email' => $email,
					'phone' => $phone,
					'updated_at' => date('Y-m-d H:i:s'),
					'id' => $id
				]);

				if ($update)
				{
					$message = [
						'class' => 'success',
						'text' => 'Kullanıcı başarılı bir şekilde güncellendi.'
					];
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve kullanıcı güncellenemedi.'
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

		$this->data['item'] = $user;
		$this->data['message'] = $message;

		return $this->view('admin.pages.users.edit', $this->data);
	}
}
