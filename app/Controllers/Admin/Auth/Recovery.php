<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Recovery extends Admin
{
	/**
	 * @param Request $request
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

				$sql = "
					SELECT
						id
					FROM users
					WHERE
						(status = 1 AND deleted_at IS NULL)
						AND
						(email = '{$email}')
				";

				$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

				if ($query)
				{
					$id = $query->id;
					$token = hashid();

					$sql = "
						INSERT INTO recovery SET
						user_id = ?,
						token = ?
					";

					$query = $this->db->prepare($sql);

					if ($query)
					{
						$insert = $query->execute([
							$id,
							$token
						]);

						if ($insert)
						{
							$mail = new PHPMailer(true);

							try
							{
								$mail->SMTPDebug = false;
								$mail->isSMTP();
								$mail->Host = config('SMTP_HOST');
								$mail->SMTPAuth = true;
								$mail->Username = config('SMTP_USERNAME');
								$mail->Password = config('SMTP_PASSWORD');
								$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
								$mail->Port = 465;
								$mail->CharSet = 'UTF-8';

								$mail->setFrom(config('SMTP_USERNAME'), 'Ofis Yönetim Sistemi');
								$mail->addAddress($email);

								$mail->isHTML();
								$mail->Subject = 'Şifre Sıfırlama Bağlantısı';
								$mail->Body = 'Şifre Sıfırlama Bağlantınız: ' . site_url('admin/recovery/sent/' . $token);
								$mail->AltBody = 'OYS';

								$mail->send();

								header('Location: ' . site_url('admin/recovery/sent'));
								exit;
							}
							catch (Exception $e)
							{
								$error = [
									'class' => 'danger',
									'text' => 'Sistemde bir hata oluştu ve e-posta gönderilemedi.'
								];
							}
						}
					}
					else
					{
						$error = [
							'class' => 'danger',
							'text' => 'Sistemde bir hata oluştu ve bağlantı oluşturulamadı.'
						];
					}
				}
				else
				{
					$error = [
						'class' => 'danger',
						'text' => 'Bu e-posta adresine kayıtlı bir kullanıcı bulunamadı.'
					];
				}
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

	/**
	 * @return string
	 */
	public function sent(): string
	{
		return $this->view('admin.pages.auth.recovery.sent', $this->data);
	}

	/**
	 * @param $slug
	 * @param Request $request
	 * @return string
	 */
	public function token($slug, Request $request): string
	{
		$message = [];

		$sql = "
			SELECT
				user_id
			FROM recovery
			WHERE
				status = 0
				AND
				token = '{$slug}'
		";

		$query = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

		if ($query)
		{
			$id = $query->user_id;

			if ($request->getMethod() == 'POST')
			{
				$rules = [
					'required' => 'password'
				];

				$this->validator->rules($rules);

				if ($this->validator->validate())
				{
					$data = $this->validator->data();

					$password = md5($data['password']);

					$sql = "
						UPDATE users SET
						password = :password
						WHERE id = :id
					";

					$query = $this->db->prepare($sql);

					$update = $query->execute([
						'password' => $password,
						'id' => $id
					]);

					if ($update)
					{
						$sql = "
							UPDATE recovery SET
							status = :status
							WHERE token = :token
						";

						$query = $this->db->prepare($sql);

						$update = $query->execute([
							'status' => 1,
							'token' => $slug
						]);

						if ($update)
						{
							$message = [
								'class' => 'success',
								'text' => 'Şifreniz başarıyla güncellendi.'
							];
						}
						else
						{
							$message = [
								'class' => 'danger',
								'text' => 'Sistemde bir hata oluştu ve bağlantı güncellenemedi.'
							];
						}
					}
					else
					{
						$message = [
							'class' => 'danger',
							'text' => 'Sistemde bir hata oluştu ve şifre güncellenemedi.'
						];
					}
				}
				else
				{
					$message = [
						'class' => 'warning',
						'text' => 'Şifre alanı boş bırakılamaz.'
					];
				}
			}
		}
		else
		{
			$message = [
				'class' => 'warning',
				'text' => 'Şifre sıfırlama bağlantısı geçersiz.'
			];
		}

		$this->data['message'] = $message;

		return $this->view('admin.pages.auth.recovery.token', $this->data);
	}
}
