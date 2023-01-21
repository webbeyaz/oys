<?php

namespace App\Controllers\Api;

use App\Controllers\Api;
use Symfony\Component\HttpFoundation\Response;
use PDO;

class Login extends Api
{
	/**
	 * @param Response $response
	 * @return void
	 */
	public function index(Response $response): void
	{
		$response->headers->set('Content-Type', 'application/json');
		$response->setStatusCode(200);

		if (!isset($_COOKIE['login']))
		{
			$text = [
				'status' => 401,
				'message' => 'Kullanıcı oturumu yok veya hatalı.'
			];
		}
		else
		{
			$cookie = $_COOKIE['login'];

			$sql = "
				SELECT id
				FROM employees
				WHERE
				    cookie = '{$cookie}'
					AND
					(status = 1 AND deleted_at IS NULL)
			";

			$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

			if ($query)
			{
				$employee_id = $query->id;

				$sql = "
					SELECT id
					FROM codes
					WHERE
					    (employee_id = $employee_id AND value = '{$cookie}')
						AND
					    status = 1
					ORDER BY id DESC
					LIMIT 1
				";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					/*$text = [
						'status' => 500,
						'message' => 'Başarıyla giriş yapıldı.'
					];*/

					header('Location: ' . site_url('logged'));
					exit;
				}
				else
				{
					$text = [
						'status' => 401,
						'message' => 'Kullanıcı ve kod bilgileri eşleşmiyor.'
					];
				}
			}
			else
			{
				$text = [
					'status' => 401,
					'message' => 'Kullanıcı ve çerez bilgileri eşleşmiyor.'
				];
			}
		}

		$json = json_encode($text, JSON_UNESCAPED_UNICODE);

		$response->setContent($json);
		$response->send();
	}
}
