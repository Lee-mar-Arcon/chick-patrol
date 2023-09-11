<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json;");

class C_api extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->call->database();
		date_default_timezone_set("Asia/Singapore");
	}

	function resend_code($email)
	{
		$this->call->model('M_encrypt');
		$email = $this->M_encrypt->decrypt($email);
		$this->send_email_code($email);
		echo json_encode($email);
	}

	public function send_email_code($email = '')
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->call->model('M_mailer');
			$this->call->model('M_encrypt');
			if (count($this->db->table('email_codes')->where('user_email', $email)->limit(1)->get_all()))
				$this->db->table('email_codes')->update([
					'code' => mt_rand(100000, 999999),
					'user_email' => $email
				]);
			else
				$this->db->table('email_codes')->insert([
					'code' => mt_rand(100000, 999999),
					'user_email' => $email
				]);
			$code = $this->db->raw('select code from email_codes where user_email = ? limit 1', array($email))[0]['code'];
			$this->M_mailer->send_mail($email, 'Account Verification', $code, $this->M_encrypt->encrypt($email));
			return 'email sent';
		} else {
			return 'not sent';
		}
	}

	function verify_code($email, $code = null)
	{
		$this->call->model('M_encrypt');
		$email = $this->M_encrypt->decrypt($email);
		$databaseCode = $this->db->table('email_codes')->where('user_email', $email)->limit(1)->get_all()[0]['code'];
		if ($databaseCode == $code) {
			$this->db->table('email_codes')->where('user_email', $email)->delete();
			$this->db->table('users')->where('email', $email)->update(['verified_at' => date('Y-m-d H:i:s')]);
			echo true;
		} else
			echo false;
	}

	function send_forgot_password_link($email)
	{
		$user = $this->db->table('users')->where_not_null('verified_at')->where('email', $email)->limit(1)->get_all();
		if (count($user) > 0) {
			$this->call->model('M_mailer');
			echo $this->M_mailer->send_forgot_password_link($email, 'Account password reset link');
		} else
			echo 'User does not exists.';
	}
}
