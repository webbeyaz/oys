<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Edit extends Admin
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $id
	 * @param Request $request
	 * @return string
	 */
	public function index($id, Request $request): string
	{
		$message = [];
		$vehicle = null;

		$sql = "
			SELECT
			    plate,
			    chassis
			FROM vehicles
			WHERE id = '{$id}'
		";

		$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($query)
		{
			$vehicle = $query;
		}
		else
		{
			header('Location: ' . site_url('admin/vehicles/list'));
			exit;
		}

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
					UPDATE vehicles SET
					plate = :plate,
					chassis = :chassis,
					updated_by = :updated_by,
					updated_at = :updated_at
					WHERE id = :id
				";

				$query = $this->db->prepare($sql);

				$update = $query->execute([
					'plate' => $plate,
					'chassis' => $chassis,
					'updated_by' => $this->data['user']->id,
					'updated_at' => date('Y-m-d H:i:s'),
					'id' => $id
				]);

				if ($update)
				{
					$message = [
						'class' => 'success',
						'text' => 'Araç başarılı bir şekilde güncellendi.'
					];
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve araç güncellenemedi.'
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

		$this->data['vehicle'] = $vehicle;
		$this->data['message'] = $message;

		return $this->view('admin.pages.vehicles.edit', $this->data);
	}
}
