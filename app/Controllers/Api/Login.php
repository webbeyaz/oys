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
					FROM actions
					WHERE
						employee_id = '{$employee_id}'
						AND
					    DATE(start_time) = CURDATE()
				";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					$text = [
						'status' => 200,
						'message' => 'Başarıyla giriş yapıldı.'
					];
				}
				else
				{
					$sql = "
						SELECT id
						FROM actions
						WHERE
							employee_id = '{$employee_id}'
							AND
							(start_time IS NOT NULL AND end_time IS NOT NULL)
							AND
						    DATE(end_time) = CURDATE()
					";

					$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

					if ($query)
					{
						$text = [
							'status' => 201,
							'message' => 'Başarıyla çıkış yapıldı.'
						];
					}
					else
					{
						$text = [
							'status' => 402,
							'message' => 'Giriş ve çıkış zamanları uyuşmuyor.'
						];
					}
				}
			}
			else
			{
				$text = [
					'status' => 401,
					'message' => 'Personel ve çerez bilgileri eşleşmiyor.'
				];
			}
		}

		$json = json_encode($text, JSON_UNESCAPED_UNICODE);

		$response->setContent($json);
		$response->send();
	}
}
