<?php

namespace App\Controllers\Admin\Drivers;

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
			UPDATE drivers SET
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
				'text' => 'Şoför silme işlemi başarılı ile gerçekleşti.'
			];
		}
		else
		{
			$message = [
				'class' => 'danger',
				'text' => 'Sistemde bir hata oluştu ve şoför silinemedi.'
			];
		}

		$this->data['message'] = $message;

		return $this->view('admin.pages.drivers.delete', $this->data);
	}
}
