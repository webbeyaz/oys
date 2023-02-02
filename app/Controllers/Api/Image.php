<?php

namespace App\Controllers\Api;

use App\Controllers\Api;
use Symfony\Component\HttpFoundation\Response;
use PDO;

class Image extends Api
{
	/**
	 * @param Response $response
	 * @return void
	 */
	public function index(Response $response): void
	{
		$data = [];

		$json = json_encode($data, JSON_UNESCAPED_UNICODE);

		$response->setContent($json);
		$response->send();
	}
}
