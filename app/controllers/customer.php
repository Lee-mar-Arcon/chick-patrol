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
			'categories' => $this->db->table('categories as c')->select('distinct c.*')->inner_join('products as p', 'c.id = p.category')->get_all(),
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
				$cartProducts = json_decode($cart['products'], true);

				$perishableIngredientInventory = array_map(function ($product) {
					$boughtQuantity = $product['quantity'];
					$product = $this->db->table('products')->select('id, name, inventory_type')->where('id', $product['id'])->get();
					$product['bought_quantity'] = $boughtQuantity;
					if ($product['inventory_type'] == 'perishable') {
						// product ingredient
						$product_ingredient = $this->db->table('product_ingredients as pi')->select('i.name, pi.need_quantity, pi.id as product_ingredient_id')->inner_join('ingredients as i', 'pi.ingredient_id=i.id')->where('pi.product_id', $product['id'])->get_all();
						$product_ingredient = array_map(
							function ($ingredient) use ($boughtQuantity) {
								$ingredient['total_need_quantity'] = $boughtQuantity * $ingredient['need_quantity'];
								$ingredient['ingredient_inventory'] =
									$this->db->table('ingredient_inventory as ii')
									->where('ii.product_ingredient_id', $ingredient['product_ingredient_id'])
									->where('ii.expiration_date', '>', date('Y-m-d H:i:s'))->order_by('ii.expiration_date', 'ACS')
									->where('ii.remaining_quantity', '!=', 0)->get_all();
								return $ingredient;
							},
							$product_ingredient
						);
						$product['product_ingredient'] = $product_ingredient;
					} else {
						$bought_quantity = $product['bought_quantity'];
						$product_inventory = $this->db->table('product_inventory')->where('product_id', $product['id'])->order_by('expiration_date', 'ACS')->get_all();
						for ($z = 0; $z < count($product_inventory); $z++) {
							$bought_quantity = $bought_quantity - $product_inventory[$z]['remaining_quantity'];
							if ($bought_quantity > 0) {
								$this->db->table('product_inventory')->where('id', $product_inventory[$z]['id'])->update(array('remaining_quantity' => 0));
							} else {
								$this->db->table('product_inventory')->where('id', $product_inventory[$z]['id'])->update(array('remaining_quantity' => abs($bought_quantity)));
								break;
							}
						}
					}
					return $product;
				}, $cartProducts);

				for ($i = 0; $i < count($perishableIngredientInventory); $i++) {
					if ($perishableIngredientInventory[$i]['inventory_type'] == 'perishable') {
						$product_ingredients = $perishableIngredientInventory[$i]['product_ingredient'];
						for ($x = 0; $x < count($product_ingredients); $x++) {
							$total_need_qty =  $product_ingredients[$x]['total_need_quantity'];
							$ingredient_inventory = $product_ingredients[$x]['ingredient_inventory'];

							for ($z = 0; $z < count($ingredient_inventory); $z++) {
								$total_need_qty = $total_need_qty - $ingredient_inventory[$z]['remaining_quantity'];
								if ($total_need_qty > 0) {
									$this->db->table('ingredient_inventory')->where('id', $ingredient_inventory[$z]['id'])->update(array('remaining_quantity' => 0));
								} else {
									$this->db->table('ingredient_inventory')->where('id', $ingredient_inventory[$z]['id'])->update(array('remaining_quantity' => abs($total_need_qty)));
									break;
								}
							}
						}
					}
				}
			} else
				echo 'error';
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
			'user' => array_merge($this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get(), $this->db->table('barangays')->select('name as barangay_name, delivery_fee')->where('id', $this->session->userdata('user')['barangay'])->get()),
			'barangays' => $this->m_admin->barangay_index()
		]);
	}

	public function view_product($productID)
	{
		$this->loggedIn();
		$productID = $this->m_encrypt->decrypt($productID);
		$product = $this->db->table('products as p')->select('p.*, c.name as category_name')->inner_join('categories as c', 'p.category=c.id')->where('p.id', $productID)->get();
		$product['id'] = $this->m_encrypt->encrypt($product['id']);
		$this->call->view('customer/view-product', [
			'pageTitle' => $product['name'],
			'user' => $this->session->userdata('user') != null ? $this->session->userdata('user') : null,
			'product' => $product,
			'relatedProducts' => $this->m_encrypt->encrypt($this->db->table('products as p')->select('p.*, c.name as category_name')->inner_join('categories as c', 'p.category=c.id')->where('p.category', $product['category'])->not_where('p.id', $productID)->limit(5)->get_all())
		]);
	}
}
