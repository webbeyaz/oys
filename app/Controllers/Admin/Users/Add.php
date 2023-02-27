<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Add extends Admin
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param Request $request
	 * @return string
	 */
	public function index(Request $request): string
	{
		$message = [];

		if ($request->getMethod() == 'POST')
		{
			$rules = [
				'required' => [
					'plate',
					'chassis'
				]
			];

			$this->validator->rules($rules);

			if ($this->validator->validate())
			{
				$data = $this->validator->data();

				$plate = $data['plate'];
				$chassis = $data['chassis'];
				// $status = $data['status']; TODO: İleride aktif edilebilir.

				$sql = "
					INSERT INTO vehicles SET
					plate = ?,
					chassis = ?,
					created_by = ?,
					updated_by = ?
				";

				$query = $this->db->prepare($sql);

				$insert = $query->execute([
					$plate,
					$chassis,
					$this->data['user']->id,
					$this->data['user']->id
				]);

				if ($insert)
				{
					$message = [
						'class' => 'success',
						'text' => 'Araç başarılı bir şekilde eklendi.'
					];
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve araç eklenemedi.'
					];
				}
			}
			else
			{
				$message = [
					'class' => 'warning',
					'text' => 'Lütfen boş alan bırakmayın.'
				];
			}
		}

		$this->data['message'] = $message;

		return $this->view('admin.pages.vehicles.add', $this->data);
	}
}
