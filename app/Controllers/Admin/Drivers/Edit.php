<?php

namespace App\Controllers\Admin\Drivers;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Edit extends Admin
{
	public function __construct()
	{
		parent::__construct();

		$this->vehicles();
	}

	/**
	 * @param $id
	 * @param Request $request
	 * @return string
	 */
	public function index($id, Request $request): string
	{
		$message = [];
		$driver = null;

		$sql = "
			SELECT
			    firstname,
			    lastname,
			    email,
			    phone,
			    vehicle_id
			FROM drivers
			WHERE id = '{$id}'
		";

		$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($query)
		{
			$driver = $query;
		}
		else
		{
			header('Location: ' . site_url('admin/drivers/list'));
			exit;
		}

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

				if ($vehicle_id)
				{
					$sql = "
						SELECT id
						FROM drivers
						WHERE vehicle_id = $vehicle_id
					";

					$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

					if ($query)
					{
						$driver_id = $query->id;

						$sql = "
							UPDATE drivers SET
							vehicle_id = :vehicle_id
							WHERE id = :id
						";

						$query = $this->db->prepare($sql);

						$update = $query->execute([
							'vehicle_id' => $vehicle_id,
							'id' => $driver_id
						]);

						if (!$update)
						{
							$message = [
								'class' => 'danger',
								'text' => 'Sistemde bir hata oluştu ve şoför araçları değiştirelemedi.'
							];
						}
					}
				}

				$sql = "
					UPDATE drivers SET
					firstname = :firstname,
					lastname = :lastname,
					email = :email,
					phone = :phone,
					vehicle_id = :vehicle_id,
					updated_by = :updated_by,
					updated_at = :updated_at
					WHERE id = :id
				";

				$query = $this->db->prepare($sql);

				$update = $query->execute([
					'firstname' => $firstname,
					'lastname' => $lastname,
					'email' => $email,
					'phone' => $phone,
					'vehicle_id' => $vehicle_id,
					'updated_by' => $this->data['user']->id,
					'updated_at' => date('Y-m-d H:i:s'),
					'id' => $id
				]);

				if ($update)
				{
					if (!$message)
					{
						$message = [
							'class' => 'success',
							'text' => 'Şoför başarılı bir şekilde güncellendi.'
						];
					}
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve şoför güncellenemedi.'
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

		$this->data['driver'] = $driver;
		$this->data['message'] = $message;

		return $this->view('admin.pages.drivers.edit', $this->data);
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
