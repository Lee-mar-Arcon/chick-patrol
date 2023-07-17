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
			$productId = $this->m_encrypt->decrypt($_POST['id']);

			// if there is no current pending cart for the user
			if ($hasPendingCart == false) {
				$this->db->table('cart')->insert(array(
					'user_id' => $user['id'],
					'products' => json_encode(array($productId))
				));
				echo json_encode('product added');
			}
			// if there is already a cart for the user
			else {
				$pendingCart = $this->db->table('cart')->where(['user_id' => $user['id'], 'status' => 'pending'])->get();

				if ($this->productExists($pendingCart['products'], $productId))
					echo json_encode('product exists');
				else
					echo json_encode($this->addProductToCart(json_decode($pendingCart['products']), $pendingCart['id'], $productId));
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function productExists($productList, $newProduct)
	{
		$productExists = false;
		foreach (json_decode($productList) as $product)
			if ($product == $newProduct) $productExists = true;
		return $productExists;
	}

	function addProductToCart($productList, $cartId, $newProduct)
	{
		$productList[] = $newProduct;
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
