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
					    employee_id = '{$employee_id}'
						AND
					    status = 1
					ORDER BY id DESC
					LIMIT 1
				";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					$sql = "
						SELECT COUNT(a.id) AS count
						FROM actions a
						INNER JOIN codes c ON c.id = a.code_id
						WHERE
						    c.employee_id = '{$employee_id}'
							AND
						    DATE(a.time) = CURDATE()
					";

					$queryCount = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

					if ($queryCount)
					{
						if ($queryCount->count == 0)
						{
							$text = [
								'status' => 200,
								'message' => 'Başarıyla giriş yapıldı.'
							];
						}
					}
					else
					{
						$text = [
							'status' => 201,
							'message' => 'Başarıyla çıkış yapıldı.'
						];
					}
				}
				else
				{
					$text = [
						'status' => 402,
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
