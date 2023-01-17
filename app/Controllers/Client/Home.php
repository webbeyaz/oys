<?php

namespace App\Controllers\Client;

use App\Controllers\Client;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

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
		$data = site_url('login/' . hashid());

		$this->data['qrCode'] = $this->qrCode($data);

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
