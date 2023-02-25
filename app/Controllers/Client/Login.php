<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use Carbon\Carbon;
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
			$employee_id = $query->employee_id;
			$agent_start = $_SERVER['HTTP_USER_AGENT'];

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
				$sql = "
					SELECT
						a.start_time AS start_time,
						a.agent_start AS agent_start,
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
					$start_time = $query->start_time;
					$agent_start = $query->agent_start;
					$username = $query->username;
					$firstname = $query->firstname;
					$lastname = $query->lastname;

					$agent = getDevice($agent_start);
					$start = Carbon::parse($start_time);

					$startTime = Carbon::createFromFormat('H:i:s', '08:30:59');
					$startTime->year($start->year);
					$startTime->month($start->month);
					$startTime->day($start->day);

					if ($start->gt($startTime))
					{
						$text = $firstname . ' ' . $lastname . ' (' . $username . ') personeli, 08:30\'dan sonra <strong>' . $agent . '</strong> ile giriş yaptı.';

						$sql = "INSERT INTO logs SET
                    	text = ?";

						$query = $this->db->prepare($sql);

						$insert = $query->execute([$text]);
					}
				}

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
