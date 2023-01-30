<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\Admin;
use Symfony\Component\HttpFoundation\Request;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
								$mail->Host = 'mail.oysapp.com';
								$mail->SMTPAuth = true;
								$mail->Username = 'admin@oysapp.com';
								$mail->Password = '&zm4X!HNxel0';
								$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
								$mail->Port = 465;

								$mail->setFrom('admin@oysapp.com', 'Ofis Yönetim Sistemi');
								$mail->addAddress($email);

								$mail->isHTML();
								$mail->Subject = 'Şifre Sıfırlama Bağlantısı';
								$mail->Body = 'Şifre Sıfırlama Bağlantınız: ' . site_url('admin/recovery/' . $token);
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
}
