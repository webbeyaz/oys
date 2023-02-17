<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use Jenssegers\Agent\Agent;
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
		$sql = "
			SELECT employee_id
			FROM codes
			WHERE slug = '{$slug}'
		";

		$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($query)
		{
			$agent = new Agent();
			$browser = $agent->browser();
			$platform = $agent->platform();
			$version = $agent->version($platform);

			$agent_start = $platform . ' ' . $version . ', ' . $browser;
			$employee_id = $query->employee_id;

			$sql = "INSERT INTO actions SET
			employee_id = ?,
			code = ?,
			agent_start = ?";

			$query = $this->db->prepare($sql);

			$insert = $query->execute([
				$employee_id,
				$slug,
				$agent_start
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

		$this->data['message'] = $message;

		return $this->view('client.pages.login', $this->data);
	}
}
