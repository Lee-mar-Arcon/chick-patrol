<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class customer extends Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('m_encrypt');
	}
	public function loggedIn()
	{
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
			'products' => $this->m_encrypt->encrypt($this->db->table('products as p')->select('p.id, p.name as product_name, c.name as category_name, p.image as image, p.price, p.available, p.quantity')->inner_join('categories as c', 'p.category=c.id')->get_all()),
			'user' => $this->session->userdata('user') != null ? $this->session->userdata('user') : null
		]);
	}

	public function shopping_cart()
	{
		$this->call->database();
		$user = $this->session->userdata('user');
		$pendingCart = $this->db->table('cart')->where(['user_id' => $user['id'], 'status' => 'pending'])->get();
		if (count(json_decode($pendingCart['products'])) > 0)
			$products = $this->db->table('products as p')->in('id', $this->get_all_product_id($pendingCart['products']))->get_all();
		else
			$products = array();
		$this->call->view('customer/shopping-cart', [
			'pageTitle' => 'Shopping Cart',
			'categories' => $this->db->table('categories')->get_all(),
			'products' => $products,
			'user' => $this->session->userdata('user') != null ? $this->session->userdata('user') : null,
			'pendingCart' => $pendingCart
		]);
	}

	function get_all_product_id($productList)
	{
		$ids = array();
		$productList = json_decode($productList);
		for ($i = 0; $i < count($productList); $i++) {
			array_push($ids, $productList[$i]->id);
		}
		return $ids;
	}
}
