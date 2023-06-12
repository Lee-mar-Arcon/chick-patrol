<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class admin extends Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		// if ($this->session->has_userdata('user'))
		// 	if (!$this->session->userdata('user')['is_admin']) 
		// 		echo 123;

		if (!$this->session->has_userdata('user'))
			redirect('account/login');
		else
			if (!$this->session->userdata('user')['is_admin'])
			redirect('account/login');
	}
	public function dashboard()
	{
		$this->call->view('admin/dashboard', [
			'pageTitle' => 'Dashboard'
		]);
	}
}
