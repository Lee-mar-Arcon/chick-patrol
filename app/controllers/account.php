<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class account extends Controller {

	public function index() {
		$this->call->view('welcome_page');
	}

	public function login() {
		$this->call->view('account/login',[
			'pageTitle' => 'login'
		]);
	}

	public function forgot_password() {
		$this->call->view('account/forgot-password',[
			'pageTitle' => 'forgot-password'
		]);
	}
}
?>