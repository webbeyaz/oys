<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\Admin;

class Delete extends Admin
{
	/**
	 * @param $id
	 * @return string
	 */
	public function index($id): string
	{
		$message = [];

		$sql = "
			UPDATE vehicles SET
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
			$sql = "
				UPDATE drivers SET
				vehicle_id = :vehicle_id
				WHERE vehicle_id = :id
			";

			$query = $this->db->prepare($sql);

			$update = $query->execute([
				'vehicle_id' => NULL,
				'id' => $id
			]);

			if ($update)
			{
				$message = [
					'class' => 'success',
					'text' => 'Araç silme işlemi başarılı ile gerçekleşti.'
				];
			}
			else
			{
				$message = [
					'class' => 'danger',
					'text' => 'Sistemde bir hata oluştu ve araç mevcut şoförden silenemedi.'
				];
			}
		}
		else
		{
			$message = [
				'class' => 'danger',
				'text' => 'Sistemde bir hata oluştu ve araç silinemedi.'
			];
		}

		$this->data['message'] = $message;

		return $this->view('admin.pages.vehicles.delete', $this->data);
	}
}
