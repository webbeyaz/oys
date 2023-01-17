<?php

namespace App\Middlewares;

class AdminCheckAuth
{
	public function handle()
	{
		$panelLogin = session()->segment->get('admin_login');

		// TODO: 'logout' segmentini kontrol et!
		if (!$panelLogin && !array_intersect(segments(), ['login', 'logout', 'recovery']))
		{
			header('Location: ' . site_url('admin/login'));
			exit;
		}

		if ($panelLogin && array_intersect(segments(), ['login', 'recovery']))
		{
			header('Location: ' . site_url('admin/dashboard'));
			exit;
		}

		return true;
	}
}
