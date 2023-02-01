<?php

namespace App\Controllers\Admin\Employees;

use App\Controllers\Admin;

class Delete extends Admin
{
	public function index($id): string
	{
		$message = [];

		$sql = "
			UPDATE employees SET
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
				'text' => 'Personel silme işlemi başarılı ile gerçekleşti.'
			];
		}
		else
		{
			$message = [
				'class' => 'danger',
				'text' => 'Sistemde bir hata oluştu ve personel silinemedi.'
			];
		}

		$this->data['message'] = $message;

		return $this->view('admin.pages.employees.delete', $this->data);
	}
}
