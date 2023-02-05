<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use PDO;

class Home extends Client
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
	 * @return string
	 */
	public function index(): string
	{
		$error = [];

		$cookie = $_COOKIE['login'];
		$qrCode = null;

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
				SELECT code
				FROM actions
				WHERE
				    employee_id = '{$employee_id}'
					AND
				    end_time IS NULL
			";

			$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

			if ($query)
			{
				$code = $query->code;
			}
			else
			{
				$code = hashid();
			}

			$qrCode = site_url('login/' . $code);
		}
		else
		{
			$error = [
				'class' => 'danger',
				'text' => 'Personel ve çerez bilgileri eşleşmiyor.'
			];
		}

		$this->data['error'] = $error;
		$this->data['qrCode'] = $this->qrCode($qrCode);

		return $this->view('client.pages.home', $this->data);
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	public function qrCode($data): mixed
	{
		$options = new QROptions([
			'version'    => 5,
			'outputType' => QRCode::OUTPUT_MARKUP_SVG,
			'eccLevel'   => QRCode::ECC_L
		]);

		$qrCode = new QRCode($options);

		return $qrCode->render($data);
	}
}
