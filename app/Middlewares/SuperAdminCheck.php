<?php

namespace App\Middlewares;

class SuperAdminCheck
{
	public function handle()
	{
		$userRole = session()->segment->get('user_role');

		if ($userRole != 1)
		{
			header('Location: ' . site_url('admin/dashboard'));
			exit;
		}

		return true;
	}
}
