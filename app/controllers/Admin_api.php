<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json;");

class Admin_api extends Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('M_admin');
		$this->call->model('M_encrypt');
		$this->call->database();
	}

	function check_input()
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
			echo json_encode($this->M_admin->user_index($page, $status, $q));
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
			echo json_encode($this->M_admin->product_index($page, $q, $category, $availability));
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
			echo json_encode($this->M_admin->product_search($q));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function barangay_search($q = '')
	{
		try {
			$this->is_authorized();
			echo json_encode($this->M_admin->barangay_search($q));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function delivery_fee_history($id, $date)
	{
		try {
			$this->is_authorized();
			echo json_encode($this->M_admin->delivery_fee_history($id, $date));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function product_price_history($id, $date)
	{
		try {
			$this->is_authorized();
			echo json_encode($this->M_admin->product_price_history($id, $date));
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
			$result = $this->check_input();
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
			$result = $this->check_input();
			$result != null ? $errors['update_price'] = $result : '';
			// quantity
			if ($this->io->post('update_inventory_type') == 'durable') {
				$this->form_validation
					->name('update_quantity')
					->required('required.')
					->numeric('invalid');
				$result = $this->check_input();
				$result != null ? $errors['update_quantity'] = $result : '';
			}

			$currentProduct = $this->db->table('products')->where('id', $this->M_encrypt->decrypt($this->io->post('update_id')))->get();
			if (count($errors) == 0) {
				$updateInventoryType = $this->io->post('update_inventory_type');
				$newQuantity = (float)$this->io->post('update_quantity');
				$newPrice = (float)$this->io->post('update_price');
				$id = (int)$this->M_encrypt->decrypt($this->io->post('update_id'));

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

			$forApprovalList = $this->M_admin->for_approval_index($page, $q);
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
			$cartID = $this->M_encrypt->decrypt($_POST['id']);
			$cartDetails['cart'] = $this->db->table('cart')->select('delivery_fee, location, for_approval_at, id, note, products, total, user_id, rejection_note')->where(['id' => $cartID])->get();

			$cartDetails['user'] = $this->db->table('users as u')->select('u.first_name, u.middle_name, u.street, u.last_name, u.contact, b.name as barangay_name, u.email')->inner_join('barangays as b', 'u.barangay=b.id')->where('u.id', $cartDetails['cart']['user_id'])->get();
			$cartDetails['products'] = $this->db->table('products as p')->select('name, id')->in('id', $this->get_all_product_id($cartDetails['cart']['products']))->get_all();
			// para lang saf yung id sa front end
			$cartDetails['cart']['user_id'] = $this->M_encrypt->encrypt($cartDetails['cart']['user_id']);
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
			$this->call->model('M_mailer');
			$cartID = $this->M_encrypt->decrypt($_POST['id']);
			$email = $this->db->table('cart as c')->select('u.email')->inner_join('users as u', 'c.user_id=u.id')->where('c.id', $cartID)->get()['email'];
			$cartDetails['cart'] = $this->db->table('cart')->select('delivery_fee, for_approval_at, id, note, products, total, user_id')->where(['id' => $cartID])->get();
			$cartDetails['user'] = $this->db->table('users as u')->select('u.first_name, u.middle_name, u.street, u.last_name, u.contact, b.name as barangay_name, u.email')->inner_join('barangays as b', 'u.barangay=b.id')->where('u.id', $cartDetails['cart']['user_id'])->get();
			$cartDetails['products'] = $this->db->table('products as p')->select('name, id, price')->in('id', $this->get_all_product_id($cartDetails['cart']['products']))->get_all();

			if ($this->M_mailer->approve_cart_mail($email, 'Your order has been approved! Our Shop is now preparing your order.', $cartDetails)) {
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
			$onPreparationList = $this->M_admin->on_preparation_index($page, $q);
			echo json_encode($onPreparationList);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function deliver_order()
	{
		try {
			$this->is_authorized();
			$this->call->model('M_mailer');
			$cartID = $this->M_encrypt->decrypt($_POST['id']);
			$email = $this->db->table('cart as c')->select('u.email')->inner_join('users as u', 'c.user_id=u.id')->where('c.id', $cartID)->get()['email'];
			$cartDetails['cart'] = $this->db->table('cart')->select('delivery_fee, for_approval_at, id, note, products, total, user_id')->where(['id' => $cartID])->get();
			$cartDetails['user'] = $this->db->table('users as u')->select('u.first_name, u.middle_name, u.street, u.last_name, u.contact, b.name as barangay_name, u.email')->inner_join('barangays as b', 'u.barangay=b.id')->where('u.id', $cartDetails['cart']['user_id'])->get();
			$cartDetails['products'] = $this->db->table('products as p')->select('name, id, price')->in('id', $this->get_all_product_id($cartDetails['cart']['products']))->get_all();

			if ($this->M_mailer->deliver_order_mail($email, 'Order Preparation Finished! Please prepare ' . number_format($cartDetails['cart']['total'], 2) . ' Php for your payment.', $cartDetails)) {
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
				$this->call->model('M_mailer');
				$cart = $this->db->table('cart')->where('id', $this->M_encrypt->decrypt($id))->get();
				$email = $this->db->table('cart as c')->select('u.email')->inner_join('users as u', 'c.user_id=u.id')->where('c.id', $this->M_encrypt->decrypt($id))->get()['email'];

				if ($this->M_mailer->reject_order_mail($email, 'Order Rejected.', $rejection_note)) {
					$this->db->table('cart')->where('id', $this->M_encrypt->decrypt($id))->update(array('status' => 'rejected', 'rejection_note' => $rejection_note, 'rejected_at' => date('Y-m-d H:i:s')));
					$products = $this->db->table('products as p')->select('quantity, id')->in('id', $this->get_all_product_id($cart['products']))->get_all();
					foreach ($products as $product) {
						foreach (json_decode($cart['products']) as $cartProduct) {
							if ($product['id'] == $cartProduct->id && $product['quantity'] != null) {
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
			$onPreparationList = $this->M_admin->rejected_orders_index($page, $q);
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
			$onDeliveryList = $this->M_admin->on_delivery_index($page, $q);
			echo json_encode($onDeliveryList);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function mark_finished()
	{
		try {
			$this->is_authorized();
			$cartID = $_POST['id'];
			if (strlen($cartID) == 0) {
				echo json_encode('id required');
			} else {
				$this->call->model('M_mailer');
				$cartID = $this->M_encrypt->decrypt($_POST['id']);
				$email = $this->db->table('cart as c')->select('u.email')->inner_join('users as u', 'c.user_id=u.id')->where('c.id', $cartID)->get()['email'];
				$cartDetails['cart'] = $this->db->table('cart')->select('delivery_fee, for_approval_at, id, note, products, total, user_id')->where(['id' => $cartID])->get();
				$cartDetails['user'] = $this->db->table('users as u')->select('u.first_name, u.middle_name, u.street, u.last_name, u.contact, b.name as barangay_name, u.email')->inner_join('barangays as b', 'u.barangay=b.id')->where('u.id', $cartDetails['cart']['user_id'])->get();
				$cartDetails['products'] = $this->db->table('products as p')->select('name, id, price')->in('id', $this->get_all_product_id($cartDetails['cart']['products']))->get_all();

				if ($this->M_mailer->deliver_order_mail($email, 'Order Marked Received! Kindly Check your email for more information.', $cartDetails)) {
					$this->db->table('cart')->where('id', $cartID)->update(array('status' => 'finished', 'received_at' => date('Y-m-d H:i:s')));
					echo json_encode(1);
				} else {
					echo json_encode(0);
				}
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function product_store()
	{
		try {
			$this->is_authorized();
			if ($this->form_validation->submitted()) {
				$errors = array();

				// name
				$this->form_validation
					->name('name')
					->required('required.')
					->custom_pattern('^[A-Za-z0-9 .()-]+$', 'valid characters: alpha, numbers, ().-')
					->min_length(1, 'required..')
					->max_length(100, 'must be less than 100 characters only.');
				$result = $this->check_input('name');
				$result != null ? $errors['name'] = $result : '';
				// category
				$this->form_validation
					->name('category')
					->required('required.');
				$result = $this->check_input();
				// check if category id exists
				if ($result != null) {
					$errors['category'] = $result;
				} else 
					if ($this->db->table('categories')->where('id', $this->M_encrypt->decrypt($this->io->post('category')))->get() == false) $errors['category'] = 'invalid ID';
				// inventory type
				$this->form_validation
					->name('inventory_type')
					->required('required.');
				$result = $this->check_input();
				if ($result != null) {
					$errors['inventory_type'] = $result;
				} else 
				if (!($this->io->post('inventory_type') == 'durable' || $this->io->post('inventory_type') == 'perishable'))
					$errors['inventory_type'] = 'invalid inventory type';

				if ($this->io->post('inventory_type') == 'durable') {
					// quantity
					$this->form_validation
						->name('quantity')
						->required('required.');
					$result = $this->check_input();
					$result != null ? $errors['quantity'] = $result : '';
					// expiration_date
					$this->form_validation
						->name('expiration_date')
						->required('required');
					$result = $this->check_input();
					$result != null ? $errors['expiration_date'] = $result : '';
					// check if input is valid date
					if (!isset($errors['expiration_date'])) {
						$dateTime = DateTime::createFromFormat('Y-m-d', $_POST['expiration_date']);
						if (!($dateTime && $dateTime->format('Y-m-d') === $_POST['expiration_date'])) {
							$errors['expiration_date'] = 'invalid date';
							// check if date is later than current date
						} else if (strtotime($_POST['expiration_date']) < time()) {
							$errors['expiration_date'] = 'expiration date must be later that today';
						}
					}
				}
				$this->form_validation
					->name('price')
					->required('required.')
					->numeric('invalid value');
				$this->io->post('price') < 1 &&  $errors['price'] = 'invalid price';
				$result = $this->check_input();
				$result != null ? $errors['price'] = $result : '';
				// description
				$this->form_validation
					->name('description')
					->required('required.')
					->min_length(0, 'required')
					->custom_pattern("^[A-Za-z0-9 .():\-!\"',]+$", 'valid characters: alpha, numbers, space and ".():\-!"\',"')
					->max_length(800, 'must be less than 800 characters, current length is ' . strlen($this->io->post('description')) . '.');
				$result = $this->check_input();
				$result != null ? $errors['description'] = $result : '';
				// product image
				if (isset($_FILES['imageInput']['name']) == 0)
					$errors['imageInput'] = 'required.';

				// perform insert
				if (count($errors) == 0) {
					if ($this->db->table('products')->where('name', $this->io->post('name'))->get() == true) {
						echo json_encode('product name already exists');
					} else {
						$filename = $this->upload_cropped_image($this->uploadOriginalImage('product'), 'product');
						// set selling to false if product is perishable
						$selling = $this->io->post('inventory_type') == 'durable' ? 1 : 0;
						$this->M_admin->product_store(
							$this->io->post('name'),
							$this->io->post('category'),
							$this->io->post('price'),
							$this->io->post('description'),
							$filename,
							$this->io->post('inventory_type'),
							$selling
						);
						$lastProductId = $this->db->last_id();
						$data = array(
							'product_id' => $lastProductId,
							'quantity' => $this->io->post('inventory_type') == 'durable' ? $this->io->post('quantity') : null,
							'expiration_date' => $this->io->post('inventory_type') == 'durable' ? $this->io->post('expiration_date') : null
						);
						// add expiration date if product is durable
						$this->io->post('inventory_type') == 'durable' ? $data['remaining_quantity'] = $this->io->post('quantity') : "";

						$this->db->table('product_inventory')->insert($data);
						echo json_encode('success');
					}
				} else
					echo json_encode($errors);
			} else
				echo json_encode("something went wrong");
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	// UPLOAD CROPPED IMAGE 
	function upload_cropped_image($filename, $table)
	{
		$base64Image = $_POST['croppedImage'];
		$data = str_replace('data:image/png;base64,', '', $base64Image);
		$imageData = base64_decode($data);
		$savePath = $table == 'product' ? 'public/images/products/cropped/' . $filename : 'public/images/category/cropped/' . $filename;
		file_put_contents($savePath, $imageData);
		return $filename;
	}

	// UPLOAD ORIGINAL IMAGE 
	function uploadOriginalImage($table)
	{
		$directory = $table == 'product' ? 'public/images/products/original' : 'public/images/category/original';
		$this->call->library('upload', $_FILES['imageInput']);
		$this->upload->max_size(10)->set_dir($directory)->allowed_extensions(array('jpg', 'png'))->is_image()->encrypt_name();
		if ($this->upload->do_upload()) {
			return $this->upload->get_filename();
		}
	}

	function delete_product()
	{
		try {
			$this->is_authorized();
			$user = $this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get();
			$productID = $this->M_encrypt->decrypt($_POST['productID']);
			if ($this->db->table('products')->where('id', $productID)->get() == false) {
				echo json_encode('invalid ID');
			} else if (password_verify($_POST['password'], $user['password'])) {
				$productImage = $this->db->table('products')->where('id', $productID)->get()['image'];
				$this->db->table('products')->where('id', $productID)->delete();
				unlink('public/images/products/cropped/' . $productImage);
				unlink('public/images/products/original/' . $productImage);
				echo json_encode('success');
			} else {
				echo json_encode('wrong password');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function delete_ingredient()
	{
		try {
			$this->is_authorized();
			$user = $this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get();
			$ingredientID = $this->M_encrypt->decrypt($_POST['ingredientID']);
			if ($this->db->table('ingredients')->where('id', $ingredientID)->get() == false) {
				echo json_encode('invalid ID');
			} else if (password_verify($_POST['password'], $user['password'])) {
				$this->db->table('ingredients')->where('id', $ingredientID)->delete();
				echo json_encode('success');
			} else {
				echo json_encode('wrong password');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function ingredients_index($page, $q)
	{
		try {
			$this->is_authorized();
			echo json_encode($this->M_admin->ingredients_index($page, $q));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function ingredient_store()
	{
		try {
			$this->is_authorized();
			$errors = array();
			// name
			$this->form_validation
				->name('name')
				->alpha_numeric_space('invalid name')
				->required('required.')
				->min_length(1, 'required.')
				->max_length(100, 'must be less than 100 characters only.');
			$result = $this->check_input();
			$result != null ? $errors['name'] = $result : '';
			if (count($errors) == 0) {
				$name = $this->io->post('name');
				$exists = $this->db->table('ingredients')->where('LOWER(name)', strtolower($name))->get();

				if ($exists) {
					if ($exists['deleted_at'] == null) {
						$errors['name'] = 'already exists';
						echo json_encode($errors);
					} else {
						$this->db->table('ingredients')->where('LOWER(name)', strtolower($name))->update(['deleted_at' => null]);
						echo json_encode('restored');
					}
				} else {
					$this->db->table('ingredients')->insert(['name' => $name]);
					echo json_encode('success');
				}
			} else {
				echo json_encode($errors);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function ingredient_update()
	{
		try {
			$this->is_authorized();
			$errors = array();
			// name
			$this->form_validation
				->name('name')
				->alpha_numeric_space('invalid name')
				->required('required.')
				->min_length(1, 'required.')
				->max_length(100, 'must be less than 100 characters only.');
			$result = $this->check_input();
			$result != null ? $errors['name'] = $result : '';

			// id
			$this->form_validation
				->name('id')
				->required('required.');
			$result = $this->check_input();
			$result != null ? $errors['id'] = $result : '';
			// if ingredient is exists
			if (!isset($errors['id']))
				if (count($this->db->table('ingredients')->where('id', $this->M_encrypt->decrypt($_POST['id']))->limit(1)->get_all()) == 0)
					$errors['id'] = 'invalid id';

			if (count($errors) == 0) {
				$name = $this->io->post('name');
				$exists = $this->db->table('ingredients')->where('LOWER(name)', strtolower($name))->get();

				if ($exists) {
					if ($exists['deleted_at'] == null) {
						$errors['name'] = 'already exists';
						echo json_encode($errors);
					} else {
						$this->db->table('ingredients')->where('LOWER(name)', strtolower($name))->update(['deleted_at' => null]);
						echo json_encode('restored');
					}
				} else {
					$this->db->table('ingredients')->where('id', $this->M_encrypt->decrypt($_POST['id']))->update(['name' => $_POST['name']]);
					echo json_encode('success');
				}
			} else {
				echo json_encode($errors);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function get_product_ingredients()
	{
		try {
			// $this->is_authorized();
			if (!isset($_POST['productID']))
				echo json_encode('does not exists');
			else {
				$productID = $this->M_encrypt->decrypt($_POST['productID']);
				$productExists = $this->db->table('products')->where('id', $productID)->limit(1)->get_all();
				if (count($productExists)) {
					$productIngredients = $this->M_encrypt->encrypt($this->db->raw(
						'SELECT 
								pi.*, 
								i.name,
								(SELECT SUM(i_ii.remaining_quantity) FROM ingredient_inventory i_ii WHERE i_ii.product_ingredient_id = pi.id) AS available_quantity,
								FLOOR(((SELECT SUM(i_ii.remaining_quantity) FROM ingredient_inventory i_ii WHERE i_ii.product_ingredient_id = pi.id)/pi.need_quantity)) AS can_make
						FROM product_ingredients AS pi 
						INNER JOIN ingredients AS i ON pi.ingredient_id = i.id
						WHERE pi.product_id = ?;
						',
						array($productID)
					));



					echo json_encode($productIngredients, true);
				} else {
					echo json_encode('does not exists');
				}
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function add_product_ingredient_quantity()
	{
		try {
			$this->is_authorized();
			$errors = array();
			// validate ID
			$productIngredientID = $_POST['product_ingredient_id'];
			// id
			$this->form_validation
				->name('product_ingredient_id')
				->required('required');
			$result = $this->check_input();
			$result != null ? $errors['product_ingredient_id'] = $result : '';
			// check if id exists
			$productIngredientID = $this->M_encrypt->decrypt($productIngredientID);
			$productIngredientExists = $this->db->table('product_ingredients')->where('id', $productIngredientID)->limit(1)->get_all();
			if (!count($productIngredientExists)) {
				$errors['product_ingredient_id'] = 'invalid id';
			}
			// quantity
			$this->form_validation
				->name('quantity')
				->numeric('invalid quantity')
				->required('required');
			$result = $this->check_input();
			$result != null ? $errors['quantity'] = $result : '';

			// expiration_date
			$this->form_validation
				->name('expiration_date')
				->required('required');
			$result = $this->check_input();
			$result != null ? $errors['expiration_date'] = $result : '';
			// check if input is valid date
			if (!isset($errors['expiration_date'])) {
				$dateTime = DateTime::createFromFormat('Y-m-d', $_POST['expiration_date']);
				if (!($dateTime && $dateTime->format('Y-m-d') === $_POST['expiration_date'])) {
					$errors['expiration_date'] = 'invalid date';
					// check if date is later than current date
				} else if (strtotime($_POST['expiration_date']) < time()) {
					$errors['expiration_date'] = 'expiration date must be later that today';
				}
			}

			if (count($errors) == 0) {
				echo json_encode($this->db->table('ingredient_inventory')->insert(array(
					'product_ingredient_id' => $productIngredientID,
					'quantity' => $_POST['quantity'],
					'remaining_quantity' => $_POST['quantity'],
					'expiration_date' => $_POST['expiration_date']
				)));
				// echo json_encode('added');
			} else {
				echo json_encode($errors);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function add_product_inventory()
	{
		try {
			// $this->is_authorized();
			$errors = array();
			// validate ID
			$inventoryProductID = $_POST['inventory_product_id'];
			// id
			$this->form_validation
				->name('inventory_product_id')
				->required('required');
			$result = $this->check_input();
			$result != null ? $errors['inventory_product_id'] = $result : '';
			// check if id exists
			$inventoryProductID = $this->M_encrypt->decrypt($inventoryProductID);
			$productInventoryExists = $this->db->table('products')->where('id', $inventoryProductID)->limit(1)->get_all();
			if (!count($productInventoryExists)) {
				$errors['inventory_product_id'] = 'invalid id';
			}
			// quantity
			$this->form_validation
				->name('inventory_quantity')
				->numeric('invalid quantity')
				->required('required');
			$result = $this->check_input();
			$result != null ? $errors['inventory_quantity'] = $result : '';

			// expiration_date
			$this->form_validation
				->name('inventory_expiration_date')
				->required('required');
			$result = $this->check_input();
			$result != null ? $errors['inventory_expiration_date'] = $result : '';
			// check if input is valid date
			if (!isset($errors['inventory_expiration_date'])) {
				$dateTime = DateTime::createFromFormat('Y-m-d', $_POST['inventory_expiration_date']);
				if (!($dateTime && $dateTime->format('Y-m-d') === $_POST['inventory_expiration_date'])) {
					$errors['inventory_expiration_date'] = 'invalid date';
					// check if date is later than current date
				} else if (strtotime($_POST['inventory_expiration_date']) < time()) {
					$errors['inventory_expiration_date'] = 'expiration date must be later that today';
				}
			}

			if (count($errors) == 0) {
				echo json_encode($this->db->table('product_inventory')->insert(array(
					'product_id' => $inventoryProductID,
					'quantity' => $_POST['inventory_quantity'],
					'remaining_quantity' => $_POST['inventory_quantity'],
					'expiration_date' => $_POST['inventory_expiration_date']
				)));
			} else {
				echo json_encode($errors);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function search_ingredients()
	{
		try {
			$this->is_authorized();
			// if required input is not sent
			if (!isset($_POST['productID']) || !isset($_POST['q']))
				echo json_encode(array());
			// check product id if valid
			else if (isset($_POST['productID'])) {
				$exists = $this->db->table('products')->where('id', $this->M_encrypt->decrypt($_POST['productID']))->limit(1)->get_all();
				if (!count($exists))
					echo json_encode(array());
				else {
					$productID = $this->M_encrypt->decrypt($_POST['productID']);
					$currentProductIngredient = $this->db->table('product_ingredients')->select('ingredient_id')->where('product_id', $productID)->get_all();
					$currentProductIngredient =
						array_map(function ($item) {
							return $item['ingredient_id'];
						}, $currentProductIngredient);
					if (count($currentProductIngredient) > 0)
						$ingredients = $this->M_encrypt->encrypt($this->db->table('ingredients')->select('name as text, id')->where_null('deleted_at')->not_in('id', $currentProductIngredient)->like('LOWER(name)', '%' . $_POST['q'] . '%')->limit(8)->get_all());
					else
						$ingredients = $this->M_encrypt->encrypt($this->db->table('ingredients')->select('name as text, id')->where_null('deleted_at')->like('LOWER(name)', '%' . $_POST['q'] . '%')->limit(8)->get_all());
					echo json_encode($ingredients);
				}
			} else {
				echo json_encode(1);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function add_product_ingredient()
	{
		try {
			$this->is_authorized();
			$errors = array();
			// product_id
			$this->form_validation
				->name('product_id')
				->required('required');
			$result = $this->check_input();
			$result != null ? $errors['product_id'] = $result : '';
			// if product is exists
			if (!isset($errors['product_id']))
				if (count($this->db->table('products')->where('id', $this->M_encrypt->decrypt($_POST['product_id']))->limit(1)->get_all()) == 0)
					$errors['product_id'] = 'invalid id';

			// ingredient_id
			$this->form_validation
				->name('ingredient_id')
				->required('required');
			$result = $this->check_input();
			$result != null ? $errors['ingredient_id'] = $result : '';
			// if ingredient is exists
			if (!isset($errors['ingredient_id']))
				if (count($this->db->table('ingredients')->where('id', $this->M_encrypt->decrypt($_POST['ingredient_id']))->limit(1)->get_all()) == 0)
					$errors['ingredient_id'] = 'invalid id';

			// need_quantity
			$this->form_validation
				->name('need_quantity')
				->required('required')
				->numeric('invalid quantity');
			$result = $this->check_input();
			$result != null ? $errors['need_quantity'] = $result : '';

			// unit_of_measurement
			$this->form_validation
				->name('unit_of_measurement')
				->required('required')
				->min_length(1, 'must be 1-10 characters')
				->max_length(10, 'must be 1-10 characters');
			$result = $this->check_input();
			$result != null ? $errors['unit_of_measurement'] = $result : '';

			if (count($errors) > 0)
				echo json_encode($errors);
			else {
				$_POST['ingredient_id'] = $this->M_encrypt->decrypt($_POST['ingredient_id']);
				$_POST['product_id'] = $this->M_encrypt->decrypt($_POST['product_id']);
				$this->db->table('product_ingredients')->insert($_POST);
				echo json_encode('success');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	function get_product_available_quantity()
	{
		try {
			// $this->is_authorized();
			if (isset($_POST['product_id'])) {
				$quantity = $this->db->raw("
				SELECT 
				IF(p.inventory_type = 'durable', 
					(SELECT SUM(inner_p_inventory.remaining_quantity) FROM product_inventory AS inner_p_inventory WHERE inner_p_inventory.product_id = p.id AND inner_p_inventory.expiration_date > NOW()), 
						(
								SELECT MIN(can_make) 
								FROM (
									SELECT FLOOR((IF(SUM(inner_ii.remaining_quantity) IS NULL, 0, SUM(inner_ii.remaining_quantity)) / pi.need_quantity)) AS can_make
									FROM products AS inner_p
									INNER JOIN product_ingredients AS pi ON inner_p.id = pi.product_id
									INNER JOIN ingredients AS i ON pi.ingredient_id = i.id
									LEFT JOIN ingredient_inventory AS inner_ii ON pi.id = inner_ii.product_ingredient_id
									WHERE (inner_ii.expiration_date > NOW() OR inner_ii.expiration_date IS NULL)
												AND inner_p.id = ?
									GROUP BY pi.id
								) AS available_quantity
						)
					)
					AS available_quantity
				FROM products AS p 
				INNER JOIN categories AS c ON p.category=c.id
				INNER JOIN product_inventory AS p_inventory ON p.id=p_inventory.product_id
				LEFT JOIN product_ingredients AS p_ingredients ON p_ingredients.product_id = p.id
				LEFT JOIN ingredient_inventory AS ii ON p_ingredients.id = ii.product_ingredient_id
				WHERE (p_inventory.expiration_date > CURRENT_DATE OR p.inventory_type = 'perishable') AND p.id = ?
				GROUP BY p.id, p_inventory.remaining_quantity
				ORDER BY p.name", array($this->M_encrypt->decrypt($_POST['product_id']), $this->M_encrypt->decrypt($_POST['product_id'])));
				echo json_encode(count($quantity) > 0 ? $quantity[0]['available_quantity'] : 0);
			} else
				echo json_encode(null);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function get_ingredient_inventory()
	{
		try {
			// $this->is_authorized();
			if (isset($_POST['ingredient_id']) && isset($_POST['product_id'])) {
				$data['list'] = $this->M_encrypt->encrypt($this->db->raw(
					'
					SELECT ii.*,i.name FROM product_ingredients AS pi 
					INNER JOIN ingredient_inventory AS ii ON ii.product_ingredient_id=pi.id
					INNER JOIN ingredients AS i ON pi.ingredient_id=i.id
					WHERE pi.product_id = ? AND pi.id = ? AND ii.expiration_date > NOW()',
					array($this->M_encrypt->decrypt($_POST['product_id']), $this->M_encrypt->decrypt($_POST['ingredient_id']))
				));
				$data['name'] = $this->db->table('ingredients as i')->inner_join('product_ingredients as pi', 'pi.ingredient_id=i.id')->where('pi.id', $this->M_encrypt->decrypt($_POST['ingredient_id']))->get()['name'];
				echo json_encode($data);
			} else {
				echo json_encode(array());
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function delete_ingredient_inventory()
	{
		try {
			$this->is_authorized();
			$user = $this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get();

			$ingredient_id = $this->M_encrypt->decrypt($_POST['ingredient_id']);
			if ($this->db->table('ingredient_inventory')->where('id', $ingredient_id)->get() == false) {
				echo json_encode('invalid ID');
			} else if (password_verify($_POST['password'], $user['password'])) {
				$this->db->table('ingredient_inventory')->where('id', $ingredient_id)->delete();
				echo json_encode('success');
			} else {
				echo json_encode('wrong password');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function delete_product_ingredient()
	{
		try {
			$this->is_authorized();
			$user = $this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get();
			$ingredient_id = $this->M_encrypt->decrypt($_POST['ingredient_id']);
			if ($this->db->table('product_ingredients')->where('id', $ingredient_id)->get() == false) {
				echo json_encode('invalid ID');
			} else if (password_verify($_POST['password'], $user['password'])) {
				$this->db->table('product_ingredients')->where('id', $ingredient_id)->delete();
				echo json_encode('success');
			} else {
				echo json_encode('wrong password');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function delete_inventory()
	{
		try {
			$this->is_authorized();
			$user = $this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get();
			$inventory_id = $this->M_encrypt->decrypt($_POST['inventory_id']);
			if ($this->db->table('product_inventory')->where('id', $inventory_id)->get() == false) {
				echo json_encode('invalid ID');
			} else if (password_verify($_POST['password'], $user['password'])) {
				$this->db->table('product_inventory')->where('id', $inventory_id)->delete();
				echo json_encode('success');
			} else {
				echo json_encode('wrong password');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function sell_archive_product()
	{
		try {
			// $this->is_authorized();
			$user = $this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get();
			// $user = $this->db->table('users')->where('id', 141)->get();
			$product_id = $this->M_encrypt->decrypt($_POST['product_id']);
			if ($this->db->table('products')->where('id', $product_id)->get() == false) {
				echo json_encode('invalid ID');
			} else if (password_verify($_POST['password'], $user['password'])) {
				$this->db->table('products')->where('id', $product_id)->update(array('selling' => $_POST['mode']));
				echo json_encode('success');
			} else {
				echo json_encode('wrong password');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function feature_remove_feature_product()
	{
		try {
			// $this->is_authorized();
			$user = $this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get();
			// $user = $this->db->table('users')->where('id', 141)->get();
			$product_id = $this->M_encrypt->decrypt($_POST['product_id']);
			if ($this->db->table('products')->where('id', $product_id)->get() == false) {
				echo json_encode('invalid ID');
			} else if (password_verify($_POST['password'], $user['password'])) {
				$this->db->table('products')->where('id', $product_id)->update(array('featured' => $_POST['mode']));
				echo json_encode('success');
			} else {
				echo json_encode('wrong password');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function product_update()
	{
		try {
			if ($this->form_validation->submitted()) {
				$id = $this->M_encrypt->decrypt($_POST['id']);
				$category = $this->M_encrypt->decrypt($this->io->post('category'));
				$errors = array();
				// name
				$this->form_validation
					->name('name')
					->required('required.')
					->custom_pattern('^[A-Za-z0-9 .()-]+$', 'valid characters: alpha, numbers, ().-')
					->min_length(1, 'required..')
					->max_length(100, 'must be less than 100 characters only.');
				$result = $this->check_input('name');
				$result != null ? $errors['name'] = $result : '';
				// category
				$this->form_validation
					->name('category')
					->required('required.');
				$result = $this->check_input('category');
				$result != null ? $errors['category'] = $result : '';
				// price
				$this->form_validation
					->name('price')
					->required('required.')
					->numeric('invalid value');
				$this->io->post('price') < 1 &&  $errors['price'] = 'invalid price';
				$result = $this->check_input('price');
				$result != null ? $errors['price'] = $result : '';

				// description
				$this->form_validation
					->name('description')
					->required('required.')
					->min_length(0, 'required')
					->custom_pattern("^[A-Za-z0-9 .():\-!\"',]+$", 'valid characters: alpha, numbers, space and ".():\-!"\',"')
					->max_length(800, 'must be less than 800 characters, current length is ' . strlen($this->io->post('description')) . '.');
				$result = $this->check_input('description');
				$result != null ? $errors['description'] = $result : '';
				$currentProductInfo = $this->db->table('products')->where('id', $id)->get();

				// check if there are errors
				if (count($errors) > 0) {
					echo json_encode($errors);
				} else {
					// check if name exists
					$exists = $this->db->raw('SELECT * FROM products WHERE LOWER(name) = ? AND id != ? LIMIT 1', array(strtolower($_POST['name']), $id));
					if ($exists) {
						echo json_encode(array('name' => 'already exists'));
					}
					// perform queries
					else {
						// insert to price history if new price is set
						if ($currentProductInfo['price'] != $this->io->post('price'))
							$this->db->table('product_price_history')->insert(array('product_id' => $id, 'price' => $currentProductInfo['price'], 'added_at' => $currentProductInfo['updated_at']));
						// perform file handling if new image is added
						$filename = $currentProductInfo['image'];
						if (isset($_FILES['imageInput']['name']) > 0) {
							unlink('././public/images/products/cropped/' . $currentProductInfo['image']);
							unlink('././public/images/products/original/' . $currentProductInfo['image']);
							$filename = $this->upload_cropped_image($this->uploadOriginalImage('product'), 'product');
						}

						$this->db->table('products')->where('id', $id)->update(array(
							'name' => $this->io->post('name'),
							'price' => $this->io->post('price'),
							'category' => $category,
							'description' => $this->io->post('description'),
							'updated_at' => date('Y-m-d H:i:s'),
							'image' => $filename
						));
						echo json_encode('success');
					}
				}
			} else
				echo 'error';
		} catch (Exception $e) {
			echo json_encode($e->getMessage());
		}
	}

	function get_all_orders_total()
	{
		try {
			$this->is_authorized();
			echo json_encode($this->db->raw('SELECT status, COUNT(id) AS total FROM cart WHERE TRIM(status) = "for approval" OR TRIM(status) = "on delivery" OR TRIM(status) = "preparing" GROUP BY status'));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function get_product_inventory()
	{
		try {
			$this->is_authorized();
			$productInventory = $this->M_encrypt->encrypt($this->db->table('product_inventory')->where('product_id', $this->M_encrypt->decrypt($_POST['productID']))->where('expiration_date', '>', date('Y-m-d H:i:s'))->get_all());
			echo json_encode($productInventory);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function sales_chart_data()
	{
		try {
			$this->is_authorized();
			if (
				empty($_POST['timePeriod']) || !in_array($_POST['timePeriod'], ['month', 'year', 'week'])
				|| !preg_match('/^(?:\d{4}-\d{2}-\d{2})\s+to\s+(?:\d{4}-\d{2}-\d{2})$/', $_POST['timePeriodRange'])
			) {
				$startDate = date('Y-01-01', strtotime(date('Y-m-d')));
				$endDate = date('Y-12-31', strtotime(date('Y-m-d')));
			} else {
				$startDate = substr($_POST['timePeriodRange'], 0, strpos($_POST['timePeriodRange'], ' '));
				$endDate = substr($_POST['timePeriodRange'], strrpos($_POST['timePeriodRange'], ' '));
			}
			switch ($_POST['timePeriod']) {
				case 'month':
					$query =
						"SELECT 
						DATE_FORMAT(c.received_at, '%b %Y') AS date, 
						SUM(c.total) AS total 
						FROM cart AS c 
						WHERE c.received_at IS NOT NULL AND (c.received_at >= ? AND c.received_at <= ?) 
						GROUP BY YEAR(c.received_at), MONTH(c.received_at), c.received_at
						ORDER BY YEAR(c.received_at) ASC, MONTH(c.received_at) ASC;
						;";
					break;
				case 'week':
					$query =
						"SELECT 
							CONCAT(
							DATE_FORMAT(STR_TO_DATE(CONCAT(YEARWEEK(c.received_at), ' Sunday'), '%X%V %W'), '%b'),
							' ',
							DATE_FORMAT(STR_TO_DATE(CONCAT(YEARWEEK(c.received_at), ' Sunday'), '%X%V %W'), '%e'),
							'-',
							DATE_FORMAT(STR_TO_DATE(CONCAT(YEARWEEK(c.received_at), ' Saturday'), '%X%V %W'), '%e'),
							' ',
							YEAR(STR_TO_DATE(CONCAT(YEARWEEK(c.received_at), ' Sunday'), '%X%V %W'))
						) AS date, 
						SUM(c.total) AS total FROM cart AS c  
						WHERE c.received_at IS NOT null  AND (c.received_at >= ? AND c.received_at <= ?) 
						GROUP BY YEAR(c.received_at), MONTH(c.received_at), YEARWEEK(c.received_at), date
						ORDER BY YEAR(c.received_at) ASC, MONTH(c.received_at) ASC, YEARWEEK(c.received_at) ASC;";
					break;
				case 'year':
					$query = "SELECT YEAR(c.received_at) AS date, SUM(c.total) AS total FROM cart AS c WHERE c.received_at IS NOT null AND (c.received_at >= ? AND c.received_at <= ?) GROUP BY YEAR(c.received_at) ORDER BY YEAR(c.received_at) ASC;";
					break;
			}

			echo json_encode($this->db->raw($query, array($startDate, $endDate)));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	// template
	// function user_index()
	// {
	// 	try {
	// 		$this->is_authorized();
	// 		echo json_encode($this->M_admin->user_index());
	// 	} catch (Exception $e) {
	// 		echo $e->getMessage();
	// 	}
	// }
}
