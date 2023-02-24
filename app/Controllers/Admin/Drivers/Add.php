<?php

namespace App\Controllers\Admin\Drivers;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Add extends Admin
{
	public function __construct()
	{
		parent::__construct();

		$this->vehicles();
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
					'firstname',
					'lastname',
					'email',
					'phone'
				]
			];

			$this->validator->rules($rules);

			if ($this->validator->validate())
			{
				$data = $this->validator->data();

				$firstname = $data['firstname'];
				$lastname = $data['lastname'];
				$email = $data['email'];
				$phone = $data['phone'];
				$vehicle_id = $data['vehicle_id'] ?: null;
				// $status = $data['status']; TODO: İleride aktif edilebilir.

				$sql = "
					SELECT id
					FROM drivers
					WHERE vehicle_id = $vehicle_id
				";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					$id = $query->id;

					$sql = "
						UPDATE drivers SET
						vehicle_id = :vehicle_id
						WHERE id = :id
					";

					$query = $this->db->prepare($sql);

					$update = $query->execute([
						'vehicle_id' => $vehicle_id,
						'id' => $id
					]);

					if (!$update)
					{
						$message = [
							'class' => 'danger',
							'text' => 'Sistemde bir hata oluştu ve şoför araçları değiştirelemedi.'
						];
					}
				}

				$sql = "
					INSERT INTO drivers SET
					firstname = ?,
					lastname = ?,
					email = ?,
					phone = ?,
					vehicle_id = ?,
					created_by = ?,
					updated_by = ?
				";

				$query = $this->db->prepare($sql);

				$insert = $query->execute([
					$firstname,
					$lastname,
					$email,
					$phone,
					$vehicle_id,
					$this->data['user']->id,
					$this->data['user']->id
				]);

				if ($insert)
				{
					if (!$message)
					{
						$message = [
							'class' => 'success',
							'text' => 'Şoför başarılı bir şekilde eklendi.'
						];
					}
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve şoför eklenemedi.'
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

		return $this->view('admin.pages.drivers.add', $this->data);
	}

	/**
	 * @return void
	 */
	public function vehicles(): void
	{
		$vehicles = [];

		$sql = "
			SELECT
			    id,
			    plate
			FROM vehicles
			WHERE deleted_at IS NULL
			ORDER BY plate ASC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$vehicles = $query;
		}

		$this->data['vehicles'] = $vehicles;
	}
}
