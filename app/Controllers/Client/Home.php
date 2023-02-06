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

		$cookie = $_COOKIE['login'];
		$qrCodeURL = null;

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
				$qrCodeURL = site_url('login/' . $code);
			}
			else
			{
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
		else
		{
			$error = [
				'class' => 'danger',
				'text' => 'Personel ve çerez bilgileri eşleşmiyor.'
			];
		}

		$qrCode = $qrCodeURL ? $this->qrCode($qrCodeURL) : null;

		$this->data['error'] = $error;
		$this->data['qrCode'] = $qrCode;

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
