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

	public function index($slug)
	{
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
				SELECT COUNT(a.id) AS count
				FROM actions a
				INNER JOIN codes c ON c.id = a.code_id
				WHERE
				    c.employee_id = $employee
					AND
				    DATE(a.time) = CURDATE()
			";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					if ($query->count == 1)
					{
						// Çıkış işlemi yapıldı.
					}
					else
					{
						// İkiden fazla giriş çıkış işlemi algılandı.
						exit;
					}
				}
				else
				{
					// Giriş veya çıkış işlemi yapılmadı.
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
						// Giriş işlemi başarılı.
					}
				}
				else
				{
					// Giriş işlemi yapılamadı.
				}
			}
			else
			{
				// Sistemde kayıtlı böyle bir kod yok.
			}
		}
		else
		{
			// Kod durumu güncellenemedi.
		}
	}
}
