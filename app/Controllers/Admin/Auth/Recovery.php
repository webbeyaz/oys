<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;

class Recovery extends Admin
{
	/**
	 * @return string
	 */
	public function index(Request $request): string
	{
		$error = [];

		if ($request->getMethod() == 'POST')
		{
			$rules = [
				'required' => 'email',
				'email' => 'email'
			];

			$this->validator->rules($rules);

			if ($this->validator->validate())
			{
				$data = $this->validator->data();

				$email = $data['email'];

				echo $email;
				exit;
			}
			else
			{
				$error = [
					'class' => 'warning',
					'text' => 'Girilen e-posta adresi geçersiz.'
				];
			}
		}

		$this->data['error'] = $error;

		return $this->view('admin.pages.auth.recovery', $this->data);
	}
}
