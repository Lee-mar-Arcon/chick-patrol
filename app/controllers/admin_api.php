<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json;");

class admin_api extends Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('m_admin');
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

	function is_authorized()
	{
		// session handler
		if (!$this->session->has_userdata('user'))
			throw new Exception('Not Authorized');
		else
			if (!$this->session->userdata('user')['is_admin'])
			throw new Exception('Not Authorized');
	}

	function user_index($page, $status, $q)
	{
		try {
			$this->is_authorized();
			echo json_encode($this->m_admin->user_index($page, $status, $q));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function upload_image()
	{
		try {

			if (isset($_FILES['croppedImage'])) {
				$this->is_authorized();
				$this->call->library('upload', $_FILES['croppedImage']);
				$this->upload->max_size(3)->set_dir('public/images/products')->allowed_extensions(array('jpg', 'png'))->is_image()->encrypt_name();
				$this->upload->do_upload();

				$fileToDelete = 'public/images/products/' . $_POST['toDeleteImage'];
				if (file_exists($fileToDelete))
					unlink($fileToDelete);
				echo json_encode($this->upload->get_filename());
			} else
				echo 0;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	// PRODUCT
	function product_index($page, $q, $category, $availability)
	{
		try {
			$this->is_authorized();
			echo json_encode($this->m_admin->product_index($page, $q, $category, $availability));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	// barangay chart data
	function barangay_chart_data()
	{
		try {
			$this->is_authorized();
			echo json_encode($this->db->table('users as u')->inner_join('barangays as b', 'u.barangay = b.id')->group_by('u.barangay')->select('count(u.id) as total, b.name')->get_all());
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	// category chart data
	function category_chart_data()
	{
		try {
			$this->is_authorized();
			echo json_encode($this->db->table('products as p')->inner_join('categories as c', 'p.category = c.id')->group_by('p.category')->select('count(p.id) as total, c.name')->get_all());
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	// product search in dashboard
	function product_search($q = '')
	{
		try {
			$this->is_authorized();
			echo json_encode($this->m_admin->product_search($q));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function barangay_search($q = '')
	{
		try {
			$this->is_authorized();
			echo json_encode($this->m_admin->barangay_search($q));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function delivery_fee_history($id, $date)
	{
		try {
			$this->is_authorized();
			echo json_encode($this->m_admin->delivery_fee_history($id, $date));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function product_price_history($id, $date)
	{
		try {
			$this->is_authorized();
			echo json_encode($this->m_admin->product_price_history($id, $date));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	// update inventory 
	function update_inventory()
	{
		try {
			$this->is_authorized();
			$errors = array();
			// id
			$this->form_validation
				->name('update_id')
				->required('required.');
			$result = $this->check_input('update_id');
			$result != null ? $errors['update_id'] = $result : '';
			// inventory type
			if ($this->io->post('update_inventory_type') !== null) {
				if ($this->io->post('update_inventory_type') != 'durable' && $this->io->post('update_inventory_type') != 'perishable')
					$errors['update_inventory_type'] = 'invalid';
			} else
				$errors['update_inventory_type'] = 'invalid';
			// price
			$this->form_validation
				->name('update_price')
				->required('required.')
				->numeric('invalid');
			$result = $this->check_input('update_price');
			$result != null ? $errors['update_price'] = $result : '';
			// quantity
			if ($this->io->post('update_inventory_type') == 'durable') {
				$this->form_validation
					->name('update_quantity')
					->required('required.')
					->numeric('invalid');
				$result = $this->check_input('update_quantity');
				$result != null ? $errors['update_quantity'] = $result : '';
			}

			$currentProduct = $this->db->table('products')->where('id', $this->m_encrypt->decrypt($this->io->post('update_id')))->get();
			if (count($errors) == 0) {
				$updateInventoryType = $this->io->post('update_inventory_type');
				$newQuantity = (float)$this->io->post('update_quantity');
				$newPrice = (float)$this->io->post('update_price');
				$id = (int)$this->m_encrypt->decrypt($this->io->post('update_id'));

				$unchanged = true;
				if ($updateInventoryType == 'perishable')
					$unchanged = $newPrice == $currentProduct['price'];
				else
					$unchanged = $currentProduct['quantity'] == $newQuantity && $newPrice == $currentProduct['price'];

				if ($unchanged) {
					echo json_encode(array('status' => 'unchanged', 'new' => $newPrice, 'old' => $currentProduct['price'], 'unchanged' => $unchanged));
				} else {
					$this->db->table('products')->where('id', $id)->update(array(
						'quantity' => $updateInventoryType == 'durable' ? $newQuantity : null,
						'price' => $newPrice,
						'updated_at' => date('Y-m-d H:i:s')
					));

					$this->db->table('inventory_adjustment_history')->insert(array(
						'product_id' => $id,
						'price' => $currentProduct['price'],
						'quantity_changed' => $updateInventoryType == 'durable' ? $newQuantity - $currentProduct['quantity'] : $currentProduct['quantity'],
						'updated_at' => $currentProduct['updated_at']
					));

					echo json_encode(array('status' => 'success'));
				}
			} else
				echo json_encode(array('status' => 'error', 'errors' => $errors, 'unchanged' => $this->io->post('update_price') != $currentProduct['price'], 'old' => $currentProduct['quantity']));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	// FOR APPROVAL
	function for_approval_index($page, $q)
	{
		try {
			$this->is_authorized();

			$forApprovalList = $this->m_admin->for_approval_index($page, $q);
			echo json_encode($forApprovalList);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function get_cart_details()
	{
		try {
			$this->is_authorized();
			$cartDetails = array();
			$cartID = $this->m_encrypt->decrypt($_POST['id']);
			$cartDetails['cart'] = $this->db->table('cart')->select('delivery_fee, for_approval_at, id, note, products, total, user_id, rejection_note')->where(['id' => $cartID])->get();

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

	function approve_order()
	{
		try {
			$this->is_authorized();
			$this->call->model('m_mailer');
			$cartID = $this->m_encrypt->decrypt($_POST['id']);
			$email = $this->db->table('cart as c')->select('u.email')->inner_join('users as u', 'c.user_id=u.id')->where('c.id', $cartID)->get()['email'];
			$cartDetails['cart'] = $this->db->table('cart')->select('delivery_fee, for_approval_at, id, note, products, total, user_id')->where(['id' => $cartID])->get();
			$cartDetails['user'] = $this->db->table('users as u')->select('u.first_name, u.middle_name, u.street, u.last_name, u.contact, b.name as barangay_name, u.email')->inner_join('barangays as b', 'u.barangay=b.id')->where('u.id', $cartDetails['cart']['user_id'])->get();
			$cartDetails['products'] = $this->db->table('products as p')->select('name, id, price')->in('id', $this->get_all_product_id($cartDetails['cart']['products']))->get_all();

			if ($this->m_mailer->approve_cart_mail($email, 'Your order has been approved! Our Shop is now preparing your order.', $cartDetails)) {
				echo json_encode($this->db->table('cart')->where('id', $cartID)->update(['status' => 'preparing', 'approved_at' => date('Y-m-d H:i:s')]));
			} else {
				echo json_encode(0);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	// ON preparation
	function on_preparation_index($page, $q)
	{
		try {
			$this->is_authorized();
			$onPreparationList = $this->m_admin->on_preparation_index($page, $q);
			echo json_encode($onPreparationList);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function deliver_order()
	{
		try {
			$this->is_authorized();
			$this->call->model('m_mailer');
			$cartID = $this->m_encrypt->decrypt($_POST['id']);
			$email = $this->db->table('cart as c')->select('u.email')->inner_join('users as u', 'c.user_id=u.id')->where('c.id', $cartID)->get()['email'];
			$cartDetails['cart'] = $this->db->table('cart')->select('delivery_fee, for_approval_at, id, note, products, total, user_id')->where(['id' => $cartID])->get();
			$cartDetails['user'] = $this->db->table('users as u')->select('u.first_name, u.middle_name, u.street, u.last_name, u.contact, b.name as barangay_name, u.email')->inner_join('barangays as b', 'u.barangay=b.id')->where('u.id', $cartDetails['cart']['user_id'])->get();
			$cartDetails['products'] = $this->db->table('products as p')->select('name, id, price')->in('id', $this->get_all_product_id($cartDetails['cart']['products']))->get_all();

			if ($this->m_mailer->deliver_order_mail($email, 'Order Preparation Finished! Please prepare ' . number_format($cartDetails['cart']['total'], 2) . ' Php for your payment.', $cartDetails)) {
				echo json_encode($this->db->table('cart')->where('id', $cartID)->update(['status' => 'on delivery', 'on_delivery_at' => date('Y-m-d H:i:s')]));
			} else {
				echo json_encode(0);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function reject_order()
	{
		try {
			$this->is_authorized();
			$id = $_POST['id'];
			$rejection_note = $_POST['rejection_note'];
			if (strlen($id) == 0)
				echo json_encode('id is required');
			else if (strlen($rejection_note) == 0)
				echo json_encode('note is required');
			else {
				$this->call->model('m_mailer');
				$cart = $this->db->table('cart')->where('id', $this->m_encrypt->decrypt($id))->get();
				$email = $this->db->table('cart as c')->select('u.email')->inner_join('users as u', 'c.user_id=u.id')->where('c.id', $this->m_encrypt->decrypt($id))->get()['email'];

				if ($this->m_mailer->reject_order_mail($email, 'Order Rejected.', $rejection_note)) {
					$this->db->table('cart')->where('id', $this->m_encrypt->decrypt($id))->update(array('status' => 'rejected', 'rejection_note' => $rejection_note, 'rejected_at' => date('Y-m-d H:i:s')));
					$products = $this->db->table('products as p')->select('quantity, id')->in('id', $this->get_all_product_id($cart['products']))->get_all();
					foreach ($products as $product) {
						foreach (json_decode($cart['products']) as $cartProduct) {
							if ($product['id'] == $cartProduct->id) {
								$this->db->table('products')->where('id', $product['id'])->update(array('quantity' => ($product['quantity'] + $cartProduct->quantity)));
								break;
							}
						}
					}
					echo json_encode(1);
				} else
					echo json_encode(0);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	// rejected orders
	function rejected_orders_index($page, $q)
	{
		try {
			$this->is_authorized();
			$onPreparationList = $this->m_admin->rejected_orders_index($page, $q);
			echo json_encode($onPreparationList);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	// on delivery
	function on_delivery_index($page, $q)
	{
		try {
			$this->is_authorized();
			$onDeliveryList = $this->m_admin->on_delivery_index($page, $q);
			echo json_encode($onDeliveryList);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function mark_finished()
	{
		try {
			$this->is_authorized();
			$id = $_POST['id'];
			if (strlen($id) == 0) {
				echo json_encode('id required');
			} else {
				$this->db->table('cart')->where('id', $this->m_encrypt->decrypt($id))->update(array('status' => 'finished', 'received_at' => date('Y-m-d H:i:s')));
				echo json_encode($this->m_encrypt->decrypt($id));
			}
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
