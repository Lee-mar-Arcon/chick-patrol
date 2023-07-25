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
			echo json_encode(count(json_decode($hasPendingCart['products'])));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function remove_cart_product()
	{
		try {
			$this->is_authorized();
			// $userId = $this->session->userdata('user');
			$pendingCart = $this->db->table('cart')->where(['user_id' =>  $this->session->userdata('user')['id'], 'status' => 'pending'])->get();
			$productId = (int)$this->m_encrypt->decrypt($_POST['id']);

			$newProductList = array();
			$productList = json_decode($pendingCart['products']);
			for ($i = 0; $i < count($productList); $i++) {
				if (!($productList[$i]->id == $productId))
					array_push($newProductList, array('id' => $productList[$i]->id, 'quantity' => $productList[$i]->quantity));
			}
			$this->db->table('cart')->where('id', $pendingCart['id'])->update(array('products' => json_encode($newProductList)));
			echo 'product removed';
		} catch (Exception $e) {
			echo $e->getMessage();
		}
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
