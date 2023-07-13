<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class customer extends Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");

		if (!$this->session->has_userdata('user'))
			redirect('account/login');
		else
			if ($this->session->userdata('user')['is_admin'])
			redirect('account/login');
	}
	public function homepage()
	{
		$this->call->view('customer/homepage', [
			'pageTitle' => 'Home'
		]);
	}
}
