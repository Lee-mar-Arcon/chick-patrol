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
		$this->call->database();

		$this->call->view('customer/homepage', [
			'pageTitle' => 'Home',
			'categories' => $this->db->table('categories')->get_all(),
			'products' => $this->db->table('products as p')->select('p.id, p.name as product_name, c.name as category_name, p.image as image, p.price')->inner_join('categories as c', 'p.category=c.id')->get_all(),
			'user' => $this->session->userdata('user')
		]);
	}
}
