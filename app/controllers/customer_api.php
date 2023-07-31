<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json;");

class customer_api extends Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('m_encrypt');
		$this->call->database();
	}

	function is_authorized()
	{
		// session handler
		if (!$this->session->has_userdata('user'))
			throw new Exception('Not Authorized');
	}

	function add_to_cart()
	{
		try {
			$this->is_authorized();
			$user = $this->session->userdata('user');
			$hasPendingCart = $this->db->table('cart')->where(['user_id' => $user['id'], 'status' => 'pending'])->get();
			$productId = (int)$this->m_encrypt->decrypt($_POST['id']);

			// if there is no current pending cart for the user
			if ($hasPendingCart == false) {
				$data[] = array('id' => $productId, 'quantity' => 1);
				$this->db->table('cart')->insert(array(
					'user_id' => $user['id'],
					'products' => json_encode($data)
				));
				echo json_encode('product added');
			}
			// if there is already a cart for the user
			else {
				$pendingCart = $hasPendingCart;
				$product = json_decode($pendingCart['products']);
				if ($this->productExists($product, $productId))
					echo json_encode('product exists');
				else
					echo json_encode($this->addProductToCart($product, $pendingCart['id'], $productId));
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function productExists($productList, $productId)
	{
		$productExists = false;
		for ($i = 0; $i < count($productList); $i++) {
			if ($productList[$i]->id == $productId) {
				$productExists = true;
				break;
			}
		}
		return $productExists;
	}

	function addProductToCart($productList, $cartId, $newProduct)
	{
		$productList[] = array('id' => (int)$newProduct, 'quantity' => 1);
		$this->db->table('cart')->where('id', $cartId)->update(array('products' => json_encode($productList)));
		return 'product added';
	}

	function get_cart_total()
	{
		try {
			$this->is_authorized();
			$user = $this->session->userdata('user');
			$hasPendingCart = $this->db->table('cart')->where(['user_id' => $user['id'], 'status' => 'pending'])->get();
			echo json_encode($hasPendingCart ? count(json_decode($hasPendingCart['products'])) : 0);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function remove_cart_product()
	{
		try {
			$this->is_authorized();
			$pendingCart = $this->db->table('cart')->where(['user_id' =>  $this->session->userdata('user')['id'], 'status' => 'pending'])->get();
			$productId = (int)$this->m_encrypt->decrypt($_POST['id']);

			$newProductList = array();
			$productList = json_decode($pendingCart['products']);
			for ($i = 0; $i < count($productList); $i++) {
				if ($productList[$i]->id != $productId)
					array_push($newProductList, array('id' => $productList[$i]->id, 'quantity' => $productList[$i]->quantity));
			}
			$this->db->table('cart')->where('id', $pendingCart['id'])->update(array('products' => json_encode($newProductList)));
			echo json_encode('product removed');
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function get_max_quantity()
	{
		try {
			$this->is_authorized();
			$productId = (int)$this->m_encrypt->decrypt($_POST['id']);
			$product = $this->db->table('products as p')->where('id', $productId)->get();
			echo json_encode($product['quantity']);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function update_cart_product_quantity()
	{
		try {
			$this->is_authorized();
			$cart = $this->db->table('cart')->where(array('user_id' => $this->session->userdata('user')['id'], 'status' => 'pending'))->get();
			$productId = (int)$this->m_encrypt->decrypt($_POST['id']);
			$productList = json_decode($cart['products']);
			$updatedProductList = array();
			$newQuantity = json_decode($_POST['newQuantity']);
			foreach ($productList as $product) {
				if ($product->id == (int)$productId) {
					$product->quantity = (int)$newQuantity;
					array_push($updatedProductList, $product);
				} else {
					array_push($updatedProductList, $product);
				}
			}
			$this->db->table('cart')->where('id', $cart['id'])->update(array('products' => json_encode($updatedProductList)));
			echo json_encode($updatedProductList);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	function get_user_cart()
	{
		try {
			$this->is_authorized();
			$status = $_POST['status'];
			if ($status == 'all') $status = '%%';
			else $status = '%' . $status . '%';
			$carts = $this->db->table('cart as c')->select('id, DATE_FORMAT(for_approval_at, "%b %d, %Y %h:%i %p") as for_approval_at, status')->where('c.user_id', $this->session->userdata('user')['id'])->like('c.status', $status)->order_by('for_approval_at', 'desc')->get_all();
			echo json_encode($carts);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	function get_cart_details()
	{
		try {
			$this->is_authorized();
			$cartDetails = array();
			// $cartID = 16;
			$cartID = $_POST['id'];
			$cartDetails['cart'] = $this->db->table('cart')
				->select('
				cart.*, 
				DATE_FORMAT(for_approval_at, "%b %d, %Y %h:%i %p") as for_approval_at,
				DATE_FORMAT(approved_at, "%b %d, %Y %h:%i %p") as approved_at,
				DATE_FORMAT(on_delivery_at, "%b %d, %Y %h:%i %p") as on_delivery_at,
				DATE_FORMAT(received_at, "%b %d, %Y %h:%i %p") as received_at,
				DATE_FORMAT(rejected_at, "%b %d, %Y %h:%i %p") as rejected_at')->where(['id' => $cartID])->get();
				
			$cartDetails['user'] = $this->db->table('users as u')->select('u.first_name, u.middle_name, u.street, u.last_name, u.contact, b.name as barangay_name, u.email')->inner_join('barangays as b', 'u.barangay=b.id')->where('u.id', $cartDetails['cart']['user_id'])->get();
			$cartDetails['products'] = $this->db->table('products as p')->select('name, id')->in('id', $this->get_all_product_id($cartDetails['cart']['products']))->get_all();
			// para lang saf yung id sa front end
			$cartDetails['cart']['user_id'] = $this->m_encrypt->encrypt($cartDetails['cart']['user_id']);
			echo json_encode($cartDetails);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
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

	// template
	// function user_index()
	// {
	// 	try {
	// 		$this->is_authorized();
	// 		echo json_encode($this->m_admin->user_index());
	// 	} catch (Exception $e) {
	// 		echo $e->getMessage();
	// 	}
	// }


}
