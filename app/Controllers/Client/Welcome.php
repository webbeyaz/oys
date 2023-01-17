<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Welcome extends Client
{
	public function __construct()
	{
		parent::__construct();

		if (isset($_COOKIE['login']))
		{
			header('Location: ' . site_url());
			exit;
		}
	}

	/**
	 * @param Request $request
	 * @return string
	 */
	public function index(Request $request): string
	{
		$error = [];

		if ($request->getMethod() == 'POST')
		{
			$this->validator->rule(
			'required',
				['username', 'password']
			);

			if ($this->validator->validate())
			{
				$data = $this->validator->data();

				$username = $data['username'];
				$password = md5($data['password']);

				$sql = "
					SELECT id
					FROM employees
					WHERE
					    username = '{$username}' && password = '{$password}'
						AND
						(status = 1 AND deleted_at IS NULL)
				";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					$id = $query->id;
					$hashid = hashid();

					$sql = "
						UPDATE employees SET
						cookie = :cookie
						WHERE id = :id
					";

					$query = $this->db->prepare($sql);

					$update = $query->execute([
						'cookie' => $hashid,
						'id' => $id
					]);

					if ($update)
					{
						setcookie(
							'login',
							$hashid,
							time() + (10 * 365 * 24 * 60 * 60)
						);

						header('Location: ' . site_url());
						exit;
					}
					else
					{
						$error = [
							'class' => 'danger',
							'text' => 'Bir sorun oluştu ve giriş işlemi yapılamadı.'
						];
					}
				}
				else
				{
					$error = [
						'class' => 'danger',
						'text' => 'Kullanıcı adı veya şifre hatalı.'
					];
				}
			}
			else
			{
				$error = [
					'class' => 'warning',
					'text' => 'Lütfen boş alan bırakmayın.'
				];
			}
		}

		$this->data['error'] = $error;

		return $this->view('client.pages.welcome', $this->data);
	}
}
