<?php

namespace App\Controllers\Admin\Vehicles;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use Verot\Upload\Upload;
use PDO;

class Tracking extends Admin
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return string
	 */
	public function list(): string
	{
		$events = [];
		//$images = [];

		$sql = "
			SELECT
			    e.id AS id,
			    d.firstname AS firstname,
			    d.lastname AS lastname,
			    v.plate AS plate,
			    e.text AS text,
			    e.created_at AS created_at
			FROM events e
			INNER JOIN drivers d ON d.id = e.driver_id
			INNER JOIN vehicles v ON v.id = d.vehicle_id
			WHERE e.deleted_at IS NULL
			ORDER BY e.updated_at DESC, e.id DESC
		";

		$queryEvent = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($queryEvent->rowCount())
		{
			$events = $queryEvent;

			/*foreach ($queryEvent as $rowEvent)
			{
				$id = $rowEvent->id;

				$sql = "
					SELECT
					    image
					FROM images
					WHERE event_id = $id
				";

				$queryImage = $this->db->query($sql, PDO::FETCH_OBJ);

				if ($queryImage->rowCount())
				{
					foreach ($queryImage as $rowImage)
					{
						$images[$id][] = $rowImage->image;
					}
				}
			}*/
		}

		$this->data['events'] = $events;
		//$this->data['images'] = $images;

		return $this->view('admin.pages.vehicles.tracking.list', $this->data);
	}

/*
@if ($images)

	<div class="avatar-group">

		@foreach ($images[$event->id] as $key => $value)

			<div title="{{ $key + 1 }}" class="avatar pull-up" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="bottom">
				<img src="{{ upload_url('images/cache/events/33x33/' . $value) }}" alt="{{ $key + 1 }}" width="33" height="33">
			</div>

		@endforeach

		@if (count($images) > 4)

			<h6 class="align-self-center cursor-pointer ms-50 mb-0">
				+{{ count($images) - 4 }}
			</h6>

		@endif

	</div>

@else

	Resim yüklenmemiş.

@endif
*/

	/**
	 * @param Request $request
	 * @return string
	 */
	public function add(Request $request): string
	{
		$message = [];
		$drivers = [];

		$sql = "
			SELECT
			    id,
			    firstname,
			    lastname
			FROM drivers
			ORDER BY firstname ASC, lastname ASC
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$drivers = $query;
		}

		if ($request->getMethod() == 'POST')
		{
			$rules = [
				'required' => [
					'driver_id',
					'text'
				]
			];

			$this->validator->rules($rules);

			$data = $this->validator->data();

			if ($this->validator->validate())
			{
				$driver_id = $data['driver_id'];
				$text = $data['text'];
				// $status = $data['status']; TODO: İleride aktif edilebilir.

				$sql = "
					INSERT INTO events SET
					driver_id = ?,
					text = ?,
					created_by = ?,
					updated_by = ?
				";

				$query = $this->db->prepare($sql);

				$insert = $query->execute([
					$driver_id,
					$text,
					$this->data['user']->id,
					$this->data['user']->id
				]);

				if ($insert)
				{
					if (file_exists($_FILES['images']['tmp_name']))
					{
						$files = [];

						foreach ($_FILES['images'] as $k => $l)
						{
							foreach ($l as $i => $v)
							{
								if (!array_key_exists($i, $files))
								{
									$files[$i] = array();
								}

								$files[$i][$k] = $v;
							}
						}

						$images = [];
						$error = false;

						foreach ($files as $file)
						{
							$handle = new Upload($file);

							if ($handle->uploaded)
							{
								$name = hashid();
								$images[] = $name . '.jpg';

								$handle->allowed = ['image/*'];
								$handle->file_new_name_body = $name;
								$handle->image_convert = 'jpg';
								$handle->process('./uploads/images/original/events');

								$handle->allowed = ['image/*'];
								$handle->file_new_name_body = $name;
								$handle->image_convert = 'jpg';
								$handle->image_resize = true;
								$handle->image_x = 400;
								$handle->image_y = 400;
								$handle->image_ratio_crop = true;
								$handle->process('./uploads/images/cache/events/400x400');

								$handle->allowed = ['image/*'];
								$handle->file_new_name_body = $name;
								$handle->image_convert = 'jpg';
								$handle->image_resize = true;
								$handle->image_x = 40;
								$handle->image_y = 40;
								$handle->image_ratio_crop = true;
								$handle->process('./uploads/images/cache/events/40x40');

								if (!$handle->processed)
								{
									$error = true;
								}
							}
							else
							{
								$error = true;
							}

							$handle->clean();
						}

						if ($error)
						{
							$message = [
								'class' => 'danger',
								'text' => 'Bir hata oluştu ve resim(ler) yüklenemedi.'
							];
						}

						$id = $this->db->lastInsertId();

						$i = 0;

						foreach ($images as $image)
						{
							$i++;

							$sql = "INSERT INTO images SET
							image = ?,
							event_id = ?";

							$query = $this->db->prepare($sql);

							$insert = $query->execute([
								$image,
								$id
							]);

							if (!$insert)
							{
								$message = [
									'class' => 'danger',
									'text' => 'Sistemde bir hata oluştu ve resimler kayıt edilemedi.'
								];
							}
						}
					}
					else
					{
						$message = [
							'class' => 'success',
							'text' => 'Kayıt başarılı bir şekilde eklendi.'
						];
					}
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve kayıt eklenemedi.'
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
		$this->data['drivers'] = $drivers;

		return $this->view('admin.pages.vehicles.tracking.add', $this->data);
	}

	/**
	 * @param $id
	 * @param Request $request
	 * @return string
	 */
	public function edit($id, Request $request): string
	{
		$message = [];
		$event = null;

		$sql = "
			SELECT
			    driver_id,
			    text,
			    created_at
			FROM events
			WHERE id = '{$id}'
		";

		$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($query)
		{
			$event = $query;
		}
		else
		{
			header('Location: ' . site_url('admin/vehicles/tracking'));
			exit;
		}

		if ($request->getMethod() == 'POST')
		{
			$rules = [
				'required' => [
					'driver_id',
					'text'
				]
			];

			$this->validator->rules($rules);

			if ($this->validator->validate())
			{
				$data = $this->validator->data();

				$driver_id = $data['driver_id'];
				$text = $data['text'];
				// $status = $data['status']; TODO: İleride aktif edilebilir.

				$sql = "
					UPDATE vehicles SET
					driver_id = :driver_id,
					text = :text,
					updated_by = :updated_by,
					updated_at = :updated_at
					WHERE id = :id
				";

				$query = $this->db->prepare($sql);

				$update = $query->execute([
					'driver_id' => $driver_id,
					'text' => $text,
					'updated_by' => $this->data['user']->id,
					'updated_at' => date('Y-m-d H:i:s'),
					'id' => $id
				]);

				if ($update)
				{
					$message = [
						'class' => 'success',
						'text' => 'Kayıt başarılı bir şekilde güncellendi.'
					];
				}
				else
				{
					$message = [
						'class' => 'danger',
						'text' => 'Sistemde bir hata oluştu ve kayıt güncellenemedi.'
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

		$this->data['event'] = $event;
		$this->data['message'] = $message;

		return $this->view('admin.pages.vehicles.tracking.edit', $this->data);
	}

	/**
	 * @param $id
	 * @return string
	 */
	public function delete($id): string
	{
		$message = [];

		$sql = "
			UPDATE events SET
			deleted_by = :deleted_by,
			deleted_at = :deleted_at
			WHERE id = :id
		";

		$query = $this->db->prepare($sql);

		$update = $query->execute([
			'deleted_by' => $this->data['user']->id,
			'deleted_at' => date('Y-m-d H:i:s'),
			'id' => $id
		]);

		if ($update)
		{
			$message = [
				'class' => 'success',
				'text' => 'Kayıt silme işlemi başarılı ile gerçekleşti.'
			];
		}
		else
		{
			$message = [
				'class' => 'danger',
				'text' => 'Sistemde bir hata oluştu ve kayıt silinemedi.'
			];
		}

		$this->data['message'] = $message;

		return $this->view('admin.pages.vehicles.tracking.delete', $this->data);
	}
}
