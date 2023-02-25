<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use Carbon\Carbon;
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
			$agent_end = $_SERVER['HTTP_USER_AGENT'];

			$sql = "UPDATE actions SET
			agent_end = :agent_end,
			end_time = :end_time
			WHERE code = :code";

			$query = $this->db->prepare($sql);

			$update = $query->execute([
				'agent_end' => $agent_end,
				'end_time' => date('Y-m-d H:i:s'),
				'code' => $slug
			]);

			if ($update)
			{
				$sql = "
					SELECT
						a.end_time AS end_time,
						a.agent_end AS agent_end,
						e.username AS username,
						e.firstname AS firstname,
						e.lastname AS lastname
					FROM actions a
					INNER JOIN employees e ON e.id = a.employee_id
					WHERE a.code = '{$slug}'
				";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					$end_time = $query->end_time;
					$agent_end = $query->agent_end;
					$username = $query->username;
					$firstname = $query->firstname;
					$lastname = $query->lastname;

					$agent = getDevice($agent_end);
					$end = Carbon::parse($end_time);

					$endTime = Carbon::createFromFormat('H:i:s', '17:00:59');
					$endTime->year($end->year);
					$endTime->month($end->month);
					$endTime->day($end->day);

					if ($end->lt($endTime))
					{
						$text = $firstname . ' ' . $lastname . ' (' . $username . ') personeli, 17:00\'den önce <strong>' . $agent . '</strong> ile çıkış yaptı.';

						$sql = "INSERT INTO logs SET
                    	text = ?";

						$query = $this->db->prepare($sql);

						$insert = $query->execute([$text]);
					}
				}

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
