<?php

namespace App\Controllers\Admin\Logs;

use App\Controllers\Admin;
use PDO;

class Listing extends Admin
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		$logs = [];

		$sql = "
			SELECT
			    text,
			    /*status*/
				date
			FROM logs
		";

		$query = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($query->rowCount())
		{
			$logs = $query;
		}

		$this->data['logs'] = $logs;

		return $this->view('admin.pages.logs.listing', $this->data);
	}
}
