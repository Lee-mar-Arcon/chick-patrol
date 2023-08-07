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
				$data[] = array('id' => $productId, 'quantity' => isset($_POST['quantity']) ? $_POST['quantity'] : 1);
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
					echo json_encode($this->addProductToCart($product, $pendingCart['id'], $productId, isset($_POST['quantity']) ? $_POST['quantity'] : 1));
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

	function addProductToCart($productList, $cartId, $newProduct, $quantity)
	{
		$productList[] = array('id' => (int)$newProduct, 'quantity' => $quantity);
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
			$carts = $this->db->table('cart as c')->select('id, DATE_FORMAT(for_approval_at, "%b %d, %Y %h:%i %p") as for_approval_at, status')->where('c.user_id', $this->session->userdata('user')['id'])->like('c.status', $status)->not_like('c.status', 'pending')->order_by('for_approval_at', 'desc')->get_all();
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

	function update_account()
	{
		try {
			$this->is_authorized();
			$updatePassword = false;
			$updateEmail = false;
			$responseSuccess = true;
			$emailSent = false;
			// changing password validation
			if (strlen($_POST['old_password']) > 0) {
				if (strlen($_POST['new_password']) == 0 || strlen($_POST['retype_new_password']) == 0)
					$responseSuccess = 'new password required';
				else {
					$responseSuccess = $this->validate_password_values($_POST['old_password'], $_POST['new_password'], $_POST['retype_new_password']);
					$updatePassword = is_string($responseSuccess) ? false : true;
				}
			} else if ((strlen($_POST['new_password']) > 0 || strlen($_POST['retype_new_password']) > 0) && strlen($_POST['old_password']) == 0)
				$responseSuccess = 'old password required';

			// changing basic information
			if (!is_string($responseSuccess)) {
				$responseSuccess = $this->validate_user_basic_information($_POST);
			}


			// changing email validation
			if ($this->session->userdata('user')['email'] != $_POST['email'] && $responseSuccess == true)
				if (!preg_match('/@gmail\.com$/i', $_POST['email']))
					$responseSuccess = 'email is not a valid Gmail address.';
				else {
					$updateEmail = true;
				}

			// update user email
			if ($updateEmail && $responseSuccess == true) {
				$this->call->model('m_mailer');
				$userID = $this->session->userdata('user')['id'];
				$encryptedID = $this->m_encrypt->encrypt($this->session->userdata('user')['id']);
				$emailSent = $this->m_mailer->send_change_email_mail($_POST['email'], $encryptedID);
				if ($emailSent == false) {
					$responseSuccess = 'sending email failed';
				} else {
					$this->call->database();
					$exists = $this->db->table('change_email_code')->where('user_id', $userID)->get();
					if ($exists)
						$this->db->table('change_email_code')->where('id', $exists['id'])->update(array('email' => $_POST['email']));
					else
						$this->db->table('change_email_code')->insert(array('user_id' => $userID, 'email' => $_POST['email']));
				}
			}

			// update user password
			if ($updatePassword && $responseSuccess == true)
				$this->db->table('users')->where('id', $this->session->userdata('user')['id'])->update(array('password' => password_hash($_POST['new_password'], PASSWORD_DEFAULT)));
			// update user basic information
			if (!is_array($responseSuccess)) {
				$this->db->table('users')->where('id', $this->session->userdata('user')['id'])->update([
					'barangay' => $this->m_encrypt->decrypt($_POST['barangay']),
					'birth_date' => $_POST['birth_date'],
					'contact' => $_POST['contact'],
					'first_name' => $_POST['first_name'],
					'middle_name' => $_POST['middle_name'],
					'last_name' => $_POST['last_name'],
					'sex' => $_POST['sex'],
					'street' => $_POST['street'],
				]);
			}
			if ($updateEmail && $emailSent)
				echo json_encode($responseSuccess = 'mail sent and updated');
			else
				echo json_encode($responseSuccess);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function validate_user_basic_information($postData)
	{
		$errors = array();
		// first name
		$this->form_validation
			->name('first_name')
			->required('required.')
			->min_length(1, 'required..')
			->max_length(100, 'must be less than 100 characters only.');
		$result = $this->check_input('first_name');
		$result != null ? $errors['first_name'] = $result : '';
		// last name
		$this->form_validation
			->name('last_name')
			->required('required.')
			->min_length(1, 'required..')
			->max_length(100, 'must be less than 100 characters only.');
		$result = $this->check_input('last_name');
		$result != null ? $errors['last_name'] = $result : '';
		// birth date
		$this->form_validation
			->name('birth_date')
			->required('required.')
			->min_length(1, 'required..')
			->max_length(100, 'must be less than 100 characters only.');
		$result = $this->check_input('birth_date');
		$result != null ? $errors['birth_date'] = $result : '';
		// sex
		if (!($_POST['sex'] == 'Female' || $_POST['sex'] == 'Male'))
			$errors['sex'] = 'invalid';
		// contact
		if (!preg_match('/^09\d{9}$/', $_POST['contact']))
			$errors['contact'] = 'must be 11 digits long and starts with 09';
		// street
		$this->form_validation
			->name('street')
			->required('required.')
			->min_length(1, 'required..')
			->max_length(100, 'must be less than 100 characters only.');
		$result = $this->check_input('street');
		$result != null ? $errors['street'] = $result : '';
		// barangay
		$barangayExists = $this->db->table('barangays')->where('id', $this->m_encrypt->decrypt($_POST['barangay']))->get();
		if (!is_array($barangayExists))
			$errors['barangay'] = 'invalid data';

		if (count($errors) > 0)
			return $errors;
		else
			return true;
	}

	function check_input($input)
	{
		$this->form_validation->run();
		$result = isset($this->form_validation->get_errors()[0]) ? $this->form_validation->get_errors()[0] : null;
		$this->form_validation->errors = array();
		return $result;
	}

	function validate_password_values($oldPassword, $newPassword, $retypeNewPassword)
	{
		$user = $this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get();
		if (password_verify($oldPassword, $user['password']) == false)
			return 'incorrect old password';
		else if ($newPassword != $retypeNewPassword)
			return 'new password must be the same';
		else if (!(strlen($newPassword) >= 8 &&  strlen($newPassword) <= 16))
			return 'new password must be 8-16 characters.';
		else
			return true;
	}

	// cancel order
	function cancel_order()
	{
		try {
			$this->is_authorized();
			$responseResult = 0;
			$cartID = $_POST['cartID'];
			$cart = $this->db->table('cart')->where('id', $cartID)->get();
			if ($cart['status'] == 'for approval') {
				$this->db->table('cart')->where('id', $cartID)->update(array('status' => 'canceled'));
				$responseResult = 1;
			} else
				$responseResult = 0;
			echo json_encode($responseResult);
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
