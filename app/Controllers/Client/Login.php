<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use PDO;

class Login extends Client
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $slug
	 * @return string
	 */
	public function index($slug): string
	{
		$message = [];

		$sql = "
			UPDATE codes SET
			status = :status
			WHERE value = :slug
		";

		$query = $this->db->prepare($sql);

		$update = $query->execute([
			'status' => 1,
			'slug' => $slug
		]);

		if ($update)
		{
			$sql = "
				SELECT
					id,
					employee_id
				FROM codes
				WHERE value = '{$slug}'
			";

			$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

			if ($query)
			{
				$code = $query->id;
				$employee = $query->employee_id;

				$sql = "
					SELECT COUNT(a.id) AS total
					FROM actions a
					INNER JOIN codes c ON c.id = a.code_id
					WHERE
					    c.employee_id = '{$employee}'
						AND
					    DATE(a.time) = CURDATE()
				";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					if ($query->total > 2)
					{
						$message = [
							'class' => 'warning',
							'text' => 'İkiden fazla giriş çıkış işlemi algılandı!'
						];
					}
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Giriş veya çıkış işlemi yapılmadı!'
					];
				}

				$sql = "
					INSERT INTO actions SET
					code_id = ?
				";

				$query = $this->db->prepare($sql);

				if ($query)
				{
					$insert = $query->execute([
						$code
					]);

					if ($insert)
					{
						$message = [
							'class' => 'success',
							'text' => 'Başarıyla Giriş Yapıldı!'
						];
					}
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Giriş işlemi yapılamadı!'
					];
				}
			}
			else
			{
				$message = [
					'class' => 'danger',
					'text' => 'Sistemde kayıtlı böyle bir giriş kodu yok!'
				];
			}
		}
		else
		{
			$message = [
				'class' => 'danger',
				'text' => 'Kod durumu güncellenemedi!'
			];
		}

		$this->data['message'] = $message;

		return $this->view('client.pages.login', $this->data);
	}
}
