<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class admin extends Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('m_admin');

		// session handler
		if (!$this->session->has_userdata('user'))
			redirect('account/login');
		else
			if (!$this->session->userdata('user')['is_admin'])
			redirect('account/login');
	}

	public function dashboard()
	{
		$this->call->view('admin/dashboard', [
			'pageTitle' => 'Dashboard',
			'breadCrumb' => 'Dashboard'
		]);
	}

	public function barangay()
	{
		$barangays = $this->m_admin->barangay_index();

		$this->call->view('admin/barangay', [
			'pageTitle' => 'Dashboard',
			'breadCrumb' => 'Barangay',
			'barangays' => $barangays
		]);
	}
}
