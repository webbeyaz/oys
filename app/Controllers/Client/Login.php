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
			SELECT id
			FROM actions
			WHERE code = '{$slug}'
		";

		$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($query)
		{
			$sql = "
				SELECT employee_id
				FROM codes
				WHERE slug = '{$slug}'
			";

			$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

			if ($query)
			{
				$employee_id = $query->employee_id;

				$sql = "INSERT INTO actions SET
				employee_id = ?,
				code = ?";

				$query = $this->db->prepare($sql);

				$insert = $query->execute([
					$employee_id,
					$slug
				]);

				if ($insert)
				{
					$message = [
						'class' => 'success',
						'text' => 'Başarılı bir şekilde giriş yapıldı.'
					];
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve giriş yapılamadı.'
					];
				}
			}
			else
			{
				$message = [
					'class' => 'danger',
					'text' => 'Sistemdeki QR kodlar eşleşmiyor.'
				];
			}
		}

		$this->data['message'] = $message;

		return $this->view('client.pages.login', $this->data);
	}
}
