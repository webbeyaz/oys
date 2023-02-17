<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QRCodeException;
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
		$qrCode = null;
		$employee = [];

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
				SELECT
					a.code AS code,
					a.start_time AS start_time,
					e.firstname AS firstname,
					e.lastname AS lastname
				    /* TODO: İleride eklenebilir. (e.photo) */
				FROM actions a
				INNER JOIN employees e ON e.id = a.employee_id
				WHERE
				    a.employee_id = '{$employee_id}'
					AND
				    a.end_time IS NULL
				ORDER BY a.id DESC
			";

			$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

			if ($query)
			{
				// Çıkış işlemi
				$employee = $query;
			}
			else
			{
				$sql = "
					SELECT
						id
					FROM actions
					WHERE
					    employee_id = '{$employee_id}'
						AND
						(start_time IS NOT NULL AND end_time IS NOT NULL)
						AND
					    (DATE(start_time) = CURDATE() AND DATE(end_time) = CURDATE())
					ORDER BY id DESC
				";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					$error = [
						'class' => 'danger',
						'text' => 'Aynı gün içerisinde birden fazla giriş ve çıkış işlemi yapılamaz.'
					];
				}
				else
				{
					// Giriş işlemi
					$code = hashid();

					$sql = "
						INSERT INTO codes SET
						slug = ?,
						employee_id = ?
					";

					$query = $this->db->prepare($sql);

					$insert = $query->execute([
						$code,
						$employee_id
					]);

					if ($insert)
					{
						$qrCodeURL = site_url('login/' . $code);
						$qrCode = $this->qrCode($qrCodeURL);
					}
					else
					{
						$error = [
							'class' => 'danger',
							'text' => 'Sistemde bir hata oluştu ve QR kod eklenemedi.'
						];
					}
				}
			}
		}
		else
		{
			$error = [
				'class' => 'danger',
				'text' => 'Personel ve çerez bilgileri eşleşmiyor.'
			];
		}

		$this->data['error'] = $error;
		$this->data['qrCode'] = $qrCode;
		$this->data['employee'] = $employee;

		return $this->view('client.pages.home', $this->data);
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	public function qrCode($data): mixed
	{
		$render = null;

		$options = new QROptions([
			'version'    => 5,
			'outputType' => QRCode::OUTPUT_MARKUP_SVG,
			'eccLevel'   => QRCode::ECC_L
		]);

		$qrCode = new QRCode($options);

		try
		{
			$render = $qrCode->render($data);
		}
		catch (QRCodeException $e)
		{
			$this->data['error'] = [
				'class' => 'warning',
				'text' => 'QR kod oluşturulurken bir hata oluştu.'
			];
		}

		return $render;
	}
}
