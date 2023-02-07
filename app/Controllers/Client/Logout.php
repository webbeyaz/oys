<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use PDO;

class Logout extends Client
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_COOKIE['login']))
		{
			header('Location: ' . site_url('welcome'));
			exit;
		}
	}

	/**
	 * @param $slug
	 * @return string
	 */
	public function index($slug): string
	{
		$message = [];

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
			//$employee_id = $query->id;

			$sql = "UPDATE actions SET
			end_time = :end_time
			WHERE code = :code";

			$query = $this->db->prepare($sql);

			$update = $query->execute([
				'end_time' => date('Y-m-d H:i:s'),
				'code' => $slug
			]);

			if ($update)
			{
				$message = [
					'class' => 'success',
					'text' => 'Başarıyla çıkış yapıldı.'
				];
			}
			else
			{
				$message = [
					'class' => 'danger',
					'text' => 'Bir hata oluştu ve çıkış yapılamadı.'
				];
			}
		}
		else
		{
			$message = [
				'class' => 'warning',
				'text' => 'Personel ve çerez bilgileri eşleşmiyor.'
			];
		}

		$this->data['message'] = $message;

		return $this->view('client.pages.logout', $this->data);
	}
}
