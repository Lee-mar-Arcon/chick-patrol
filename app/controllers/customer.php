<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class customer extends Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('m_encrypt');
		$this->call->database();
	}

	function check_input($input)
	{
		$this->form_validation->run();
		$result = isset($this->form_validation->get_errors()[0]) ? $this->form_validation->get_errors()[0] : null;
		$this->form_validation->errors = array();
		return $result;
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
		$this->call->view('customer/homepage', [
			'pageTitle' => 'Home',
			'categories' => $this->db->table('categories')->get_all(),
			'products' => $this->m_encrypt->encrypt($this->db->table('products as p')->select('p.id, p.name as product_name, c.name as category_name, p.image as image, p.price, p.available, p.quantity')->inner_join('categories as c', 'p.category=c.id')->get_all()),
			'user' => $this->session->userdata('user') != null ? $this->session->userdata('user') : null
		]);
	}

	public function shopping_cart()
	{
		$this->loggedIn();
		$user = $this->session->userdata('user');
		$pendingCart = $this->db->table('cart')->where(['user_id' => $user['id'], 'status' => 'pending'])->get();
		if ($pendingCart)
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

	function checkout()
	{
		$this->loggedIn();
		$cart = $this->db->table('cart')->where(['user_id' => $this->session->userdata('user')['id'], 'status' => 'pending'])->get();
		$this->call->view('customer/checkout', [
			'pageTitle' => 'Checkout',
			'cart' => $cart,
			'cartProducts' => $cart ? $this->db->table('products')->in('id', $this->get_all_product_id($cart['products']))->get_all() : null,
			'user' => array_merge($this->session->userdata('user'), $this->db->table('barangays')->select('name as barangay_name, delivery_fee')->where('id', $this->session->userdata('user')['barangay'])->get()),
			'errors' => $this->session->userdata('errors') != null ? $this->session->userdata('errors') : null
		]);
	}

	function place_order()
	{
		$this->loggedIn();
		if ($this->form_validation->submitted()) {
			$errors = array();
			// name
			$this->form_validation
				->name('note')
				->required('Required')
				->min_length(1, 'Must be greater than 1 characters only.')
				->max_length(1000, 'Must be less than 1000 characters only.');
			$result = $this->check_input('note');
			$result != null ? $errors['note'] = $result : '';
			$this->session->set_flashdata(array('errors' => $errors));

			// location
			$this->form_validation
				->name('location')
				->required('Location is required.');
			$result = $this->check_input('location');
			$result != null ? $errors['location'] = $result : '';
			$this->session->set_flashdata(array('errors' => $errors));

			if (count($errors) == 0) {
				$cart = $this->db->table('cart')->where(['user_id' => $this->session->userdata('user')['id'], 'status' => 'pending'])->get();
				$cartProducts =  $this->db->table('products')->in('id', $this->get_all_product_id($cart['products']))->get_all();
				$cartProductWithPrice = array();
				$delivery_fee = $this->db->table('barangays')->select('delivery_fee')->where('id', $this->session->userdata('user')['barangay'])->get()['delivery_fee'];
				$total = 0 + $delivery_fee;
				foreach (json_decode($cart['products']) as $product) {
					for ($i = 0; $i < count($cartProducts); $i++) {
						if ($cartProducts[$i]['id'] == $product->id) {
							$product->price = $cartProducts[$i]['price'];
							$total += ($cartProducts[$i]['price'] * $product->quantity);
							// update subtract cart product quantity to product quantity
							if ($cartProducts[$i]['quantity']) {
								$this->db->table('products')->where('id', $cartProducts[$i]['id'])->update(['quantity' => $cartProducts[$i]['quantity'] - $product->quantity]);
							}
							array_push($cartProductWithPrice, $product);
						}
					}
				}

				$this->db->table('cart')->where('id', $cart['id'])->update([
					'delivery_fee' => $delivery_fee,
					'products' => json_encode($cartProductWithPrice),
					'total' => $total,
					'note' => $this->io->post('note'),
					'status' => 'for approval',
					'for_approval_at' => date('Y-m-d H:i:s'),
					'location' => $this->io->post('location')
				]);
			}
		} else
			echo 'error';
		redirect('customer/checkout');
	}

	public function orders()
	{
		$this->loggedIn();
		$this->call->view('customer/orders', [
			'pageTitle' => 'Orders',
			'user' => $this->session->userdata('user') != null ? $this->session->userdata('user') : null
		]);
	}

	public function profile()
	{
		$this->loggedIn();
		$this->call->model('m_admin');
		$this->call->view('customer/profile', [
			'pageTitle' => 'Profile',
			'user' => array_merge($this->session->userdata('user'), $this->db->table('barangays')->select('name as barangay_name, delivery_fee')->where('id', $this->session->userdata('user')['barangay'])->get()),
			'barangays' => $this->m_admin->barangay_index()
		]);
	}
}
