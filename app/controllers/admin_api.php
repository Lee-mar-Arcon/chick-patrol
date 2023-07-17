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
