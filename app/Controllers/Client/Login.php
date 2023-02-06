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
			// Çıkış işlemi
			$id = $query->id;

			$sql = "UPDATE actions SET
			end_time = :end_time
			WHERE id = :id";

			$query = $this->db->prepare($sql);

			$update = $query->execute(array(
				'end_time' => date('Y-m-d H:i:s'),
				'id' => $id
			));

			if ($update)
			{
				$message = [
					'class' => 'success',
					'text' => 'Başarılı bir şekilde çıkış yapıldı.'
				];
			}
			else
			{
				$message = [
					'class' => 'danger',
					'text' => 'Sistemde bir hata oluştu ve çıkış yapılamadı.'
				];
			}
		}
		else
		{
			// Giriş işlemi
			$sql = "INSERT INTO actions SET
			employee_id = ?,
			code = ?";

			$query = $this->db->prepare($sql);

			$insert = $query->execute([
				$employee_id,
				$slug
			]);
		}

		$this->data['message'] = $message;

		return $this->view('client.pages.login', $this->data);
	}
}
