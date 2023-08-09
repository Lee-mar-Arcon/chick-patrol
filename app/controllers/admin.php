<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class admin extends Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('m_admin');

		// session handler
		if (!$this->session->has_userdata('user'))
			redirect('account/login');
		else
			if (!$this->session->userdata('user')['is_admin'])
			redirect('account/login');
	}

	// OTHERS
	public function dashboard()
	{
		$this->call->view('admin/dashboard', [
			'pageTitle' => 'Admin | Dashboard',
			'breadCrumb' => 'Dashboard'
		]);
	}

	function upload_cropped_image($filename, $table)
	{
		$base64Image = $_POST['croppedImage'];
		$data = str_replace('data:image/png;base64,', '', $base64Image);
		$imageData = base64_decode($data);
		$savePath = $table == 'product' ? 'public/images/products/cropped/' . $filename : 'public/images/category/cropped/' . $filename;
		file_put_contents($savePath, $imageData);
		return $filename;
	}

	function check_input($input)
	{
		$this->form_validation->run();
		$result = isset($this->form_validation->get_errors()[0]) ? $this->form_validation->get_errors()[0] : null;
		$this->form_validation->errors = array();
		return $result;
	}

	public function paginator($total, $records_per_page, $page, $link)
	{
		$this->call->library('pagination');
		$this->pagination->initialize($total, $records_per_page, $page, $link);
		return $this->pagination->paginate();
	}

	// UPLOAD IMAGE 
	function uploadOriginalImage($table)
	{
		$directory = $table == 'product' ? 'public/images/products/original' : 'public/images/category/original';
		$this->call->library('upload', $_FILES['imageInput']);
		$this->upload->max_size(10)->set_dir($directory)->allowed_extensions(array('jpg', 'png'))->is_image()->encrypt_name();
		if ($this->upload->do_upload()) {
			return $this->upload->get_filename();
		}
	}

	// BARANGAY
	public function barangay()
	{
		$barangays = $this->m_admin->barangay_index();

		$this->call->view('admin/barangay', [
			'pageTitle' => 'Admin | Barangay',
			'breadCrumb' => 'Barangay',
			'barangays' => $barangays
		]);
	}

	function barangay_store()
	{
		$this->form_validation
			->name('name')
			->required()
			->min_length(1, 'Must be 1-100 characters in length only.')
			->max_length(100, 'Must be 1-100 characters in length only.')
			->name('delivery_fee')
			->required('Delivery fee is required.')
			->numeric('Delivery fee is required.');
		if ($this->form_validation->run()) {
			$name = $this->io->post('name');
			$delivery_fee = $this->io->post('delivery_fee');

			$exists = $this->db->table('barangays')->where('LOWER(name)', strtolower($name))->get();
			if ($exists) {
				if ($exists['deleted_at'] == null) {
					$this->session->set_flashdata(['formMessage' => 'Name already exists']);
					$this->session->set_flashdata(['formData' => $_POST]);
				} else {
					$this->db->table('barangays')->where('LOWER(name)', strtolower($name))->update(['deleted_at' => null]);
					$this->session->set_flashdata(['formMessage' => 'restored']);
				}
			} else {
				$this->db->table('barangays')->insert(['name' => $name, 'delivery_fee' => $delivery_fee]);
				$this->session->set_flashdata(['formMessage' => 'success']);
			}
		} else {
			$this->session->set_flashdata(['formMessage' => $this->form_validation->get_errors()[0]]);
			$this->session->set_flashdata(['formData' => $_POST]);
		}
		redirect('admin/barangay');
	}

	function barangay_update()
	{
		$this->form_validation
			->name('id')->required('ID is required.')
			->name('name')
			->min_length(1, 'Must be 1-100 characters in length only.')
			->max_length(100, 'Must be 1-100 characters in length only.')
			->name('delivery_fee')
			->required('Delivery fee is required')
			->numeric('Delivery fee is required');

		if ($this->form_validation->run()) {
			$this->call->model('m_encrypt');
			$id = $this->m_encrypt->decrypt($this->io->post('id'));
			$name = $this->io->post('name');
			$delivery_fee = $this->io->post('delivery_fee');

			$currentRow = $this->db->table('barangays')->where('id', $id)->get();
			$exists = $this->db->table('barangays')->where('LOWER(name)', strtolower($name))->not_where('id', $id)->get();
			// update row if delivery fee is only changed
			if ($currentRow['name'] == $name && $currentRow['delivery_fee'] != $delivery_fee) {
				$this->session->set_flashdata(['formMessage' => 'updated']);
				$this->db->table('delivery_fee_history')->insert(['barangay_id' => $id, 'delivery_fee' => $currentRow['delivery_fee'], 'added_at' => $currentRow['updated_at']]);
				$this->db->table('barangays')->where('id', $id)->update(['delivery_fee' => $delivery_fee, 'updated_at' => date('Y-m-d H:i:s'), 'name' => $this->io->post('name')]);
			}
			// send error if new name exists 
			else if ($exists) {
				$this->session->set_flashdata(['formMessage' => 'Name already exists']);
				$this->session->set_flashdata(['formData' => $_POST]);
			}
			// update row if new name is unique
			else {
				if ($currentRow['delivery_fee'] != $delivery_fee)
					$this->db->table('delivery_fee_history')->insert(['barangay_id' => $id, 'delivery_fee' => $currentRow['delivery_fee'], 'added_at' => $currentRow['updated_at']]);
				$this->db->table('barangays')->where('id', $id)->update(['delivery_fee' => $delivery_fee, 'updated_at' => date('Y-m-d H:i:s'), 'name' => $this->io->post('name')]);
				$this->session->set_flashdata(['formMessage' => 'updated']);
			}
		} else {
			$this->session->set_flashdata(['formMessage' => $this->form_validation->get_errors()[0]]);
			$this->session->set_flashdata(['formData' => $_POST]);
		}
		redirect('admin/barangay');
	}

	function barangay_restore()
	{
		$this->form_validation
			->name('id')->required('ID is required.');
		if ($this->form_validation->run()) {
			$this->call->model('m_encrypt');
			$id = $this->m_encrypt->decrypt($this->io->post('id'));
			$this->db->table('barangays')->where('id', $id)->update(['deleted_at' => null]);
			$this->session->set_flashdata(['formMessage' => 'restored']);
			redirect('admin/barangay');
		} else {
			echo 'ID is required';
		}
	}

	function barangay_destroy()
	{
		$this->form_validation
			->name('id')->required('ID is required.');

		if ($this->form_validation->run()) {
			$this->call->model('m_encrypt');
			$id = $this->m_encrypt->decrypt($this->io->post('id'));
			$this->db->table('barangays')->where('id', $id)->update(['deleted_at' => date("Y-m-d H:i:s")]);
			$this->session->set_flashdata(['formMessage' => 'deleted']);
			redirect('admin/barangay');
		} else {
			echo 'ID is required';
		}
	}



	// CATEGORY
	function category()
	{
		$categories = $this->m_admin->category_index();
		$this->call->view('admin/category', [
			'pageTitle' => 'Admin | Category',
			'breadCrumb' => 'Category',
			'categories' => $categories,
			'formMessage' => $this->session->flashdata('formMessage') !== null ? $this->session->flashdata('formMessage') : null,
			'formData' => $this->session->flashdata('formData') !== null ? $this->session->flashdata('formMessage') : null
		]);
	}

	function category_store()
	{
		// sa product
		if ($this->form_validation->submitted()) {
			$imageUploaded = true;

			$this->form_validation
				->name('name')
				->min_length(1, 'Must be 1-100 characters in length only.')
				->max_length(100, 'Must be 1-100 characters in length only.');
			// product image
			if (strlen($_FILES['imageInput']['name']) == 0)
				$imageUploaded = false;



			if ($imageUploaded)
				if ($this->form_validation->run()) {
					$filename = $this->upload_cropped_image($this->uploadOriginalImage('category'), 'category');
					$this->m_admin->category_store($this->io->post('name'), $filename);
				} else {
					$this->session->set_flashdata(['formMessage' => $this->form_validation->get_errors()[0]]);
					$this->session->set_flashdata(['formData' => $_POST]);
				}
			else
				$this->session->set_flashdata(['formMessage' => 'upload error']);
			redirect('admin/category');
		}
	}

	function category_update()
	{
		$this->form_validation
			->name('id')->required('ID is required.')
			->name('name')
			->min_length(1, 'Must be 1-100 characters in length only.')
			->max_length(100, 'Must be 1-100 characters in length only.');


		if ($this->form_validation->run()) {
			// perform file handling if new image is added
			$id = $this->m_encrypt->decrypt($this->io->post('id'));
			$currentCategory = $this->db->table('categories')->where('id', $id)->get();
			$filename = $currentCategory['image'];
			if (strlen($_FILES['imageInput']['name']) > 0) {
				unlink('././public/images/category/cropped/' . $currentCategory['image']);
				unlink('././public/images/category/original/' . $currentCategory['image']);
				$filename = $this->upload_cropped_image($this->uploadOriginalImage('category'), 'category');
			}

			$this->m_admin->category_update($this->io->post('id'), $this->io->post('name'), $filename);
		} else {
			$this->session->set_flashdata(['formMessage' => $this->form_validation->get_errors()[0]]);
			$this->session->set_flashdata(['formData' => $_POST]);
		}
		redirect('admin/category');
	}

	function category_destroy()
	{
		$this->form_validation
			->name('id')->required('ID is required.');

		if ($this->form_validation->run()) {
			$this->m_admin->category_destroy($this->io->post('id'));
			redirect('admin/category');
		} else {
			echo 'ID is required';
		}
	}

	function category_restore()
	{
		$this->form_validation
			->name('id')->required('ID is required.');
		if ($this->form_validation->run()) {
			$this->m_admin->category_restore($this->io->post('id'));
			redirect('admin/category');
		} else {
			echo 'ID is required';
		}
	}

	function user()
	{
		$this->call->view('admin/user', [
			'pageTitle' => 'Admin | Users',
			'breadCrumb' => 'Users',
		]);
	}

	// PRODUCT
	function product()
	{
		$this->call->model('m_encrypt');
		$categoriesForForm = $this->m_encrypt->encrypt($this->db->table('categories')->where_null('deleted_at')->get_all());
		$this->call->view('admin/product', [
			'pageTitle' => 'Admin | Products',
			'breadCrumb' => 'Products',
			'categories' => $this->m_admin->category_index(),
			'categoriesForForm' => $categoriesForForm,
			'formMessage' => $this->session->flashdata('formMessage') !== null ? $this->session->flashdata('formMessage') : null,
			'formData' => $this->session->flashdata('formData') !== null ? $this->session->flashdata('formData') : null,
			'formErrors' => $this->session->flashdata('formErrors') !== null ? $this->session->flashdata('formErrors') : null,
		]);
	}

	function product_update()
	{
		if ($this->form_validation->submitted()) {
			$id = $this->m_encrypt->decrypt($this->io->post('id'));
			$category = $this->m_encrypt->decrypt($this->io->post('category'));
			$errors = array();
			// name
			$this->form_validation
				->name('name')
				->required('required.')
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
			$result = $this->check_input('price');
			$result != null ? $errors['price'] = $result : '';

			// description
			$this->form_validation
				->name('description')
				->required('required.')
				->min_length(0, 'required')
				->max_length(800, 'must be less than 800 characters, current length is ' . strlen($this->io->post('description')) . '.');
			$result = $this->check_input('description');
			$result != null ? $errors['description'] = $result : '';
			$currentProductInfo = $this->db->table('products')->where('id', $id)->get();

			$exists = $this->db->table('products')->where('name', $this->io->post('name'))->not_where('id', $id)->get();

			if ($exists) {
				$this->session->set_flashdata(['formErrors' => $errors]);
				$this->session->set_flashdata(['formMessage' => 'update exists']);
				$this->session->set_flashdata(['formData' => $_POST]);
			} else {
				// insert to price history if new price is set
				if ($currentProductInfo['price'] != $this->io->post('price'))
					$this->db->table('product_price_history')->insert(array('product_id' => $id, 'price' => $currentProductInfo['price'], 'added_at' => $currentProductInfo['updated_at']));
				// perform file handling if new image is added
				$filename = $currentProductInfo['image'];
				if (strlen($_FILES['imageInput']['name']) > 0) {
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
				$this->session->set_flashdata(['formMessage' => 'updated']);
			}
		} else
			echo 'error';
		redirect('admin/product');
	}

	function product_available()
	{
		$this->form_validation
			->name('id')->required('ID is required.');
		if ($this->form_validation->run()) {
			$this->call->model('m_encrypt');
			$id = $this->m_encrypt->decrypt($this->io->post('id'));
			$this->db->table('products')->where('id', $id)->update(['selling' => 1]);
			$this->session->set_flashdata(['formMessage' => 'selling']);
			redirect('admin/product');
		} else {
			echo 'ID is required';
		}
	}

	function product_unavailable()
	{
		$this->form_validation
			->name('id')->required('ID is required.');
		if ($this->form_validation->run()) {
			$this->call->model('m_encrypt');
			$id = $this->m_encrypt->decrypt($this->io->post('id'));
			$this->db->table('products')->where('id', $id)->update(['selling' => 0]);
			$this->session->set_flashdata(['formMessage' => 'unavailable']);
			redirect('admin/product');
		} else {
			echo 'ID is required';
		}
	}

	// USER
	function ban_user()
	{
		$this->form_validation
			->name('id')->required('ID is required.');

		if ($this->form_validation->run()) {
			$this->call->model('m_encrypt');
			$id = $this->m_encrypt->decrypt($this->io->post('id'));
			$this->db->table('users')->where('id', $id)->update(['is_banned' => 1]);
			$this->session->set_flashdata(['formMessage' => 'deleted']);
			redirect('admin/user');
		} else {
			echo 'ID is required';
		}
	}

	function reactivate_user()
	{
		$this->form_validation
			->name('id')->required('ID is required.');

		if ($this->form_validation->run()) {
			$this->call->model('m_encrypt');
			$id = $this->m_encrypt->decrypt($this->io->post('id'));
			$this->db->table('users')->where('id', $id)->update(['is_banned' => 0]);
			$this->session->set_flashdata(['formMessage' => 'deleted']);
			redirect('admin/user');
		} else {
			echo 'ID is required';
		}
	}

	function approval()
	{
		$this->call->view('admin/for-approval', [
			'pageTitle' => 'Admin | For Approval',
			'breadCrumb' => 'For Approval'
		]);
	}

	function rejected_order()
	{
		$this->call->view('admin/rejected-order', [
			'pageTitle' => 'Admin | Rejected Orders',
			'breadCrumb' => 'Rejected Orders'
		]);
	}

	function preparing()
	{
		$this->call->view('admin/preparing', [
			'pageTitle' => 'Admin | On Preparation',
			'breadCrumb' => 'On Preparation'
		]);
	}

	function on_delivery()
	{
		$this->call->view('admin/on-delivery', [
			'pageTitle' => 'Admin | On Delivery',
			'breadCrumb' => 'On Delivery'
		]);
	}

	function profile()
	{
		$this->call->view('admin/profile', [
			'pageTitle' => 'Admin | Profile',
			'breadCrumb' => 'User Profile',
			'barangays' => $this->m_admin->barangay_index(),
			'user' => array_merge($this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get(), $this->db->table('barangays')->select('name as barangay_name, delivery_fee')->where('id', $this->session->userdata('user')['barangay'])->get()),
		]);
	}

	function view_product($id)
	{
		$id = $this->m_encrypt->decrypt($id);
		$product = $this->m_encrypt->encrypt($this->db->raw(
			"SELECT p.*, c.name AS category_name, SUM(pi.quantity) AS quantity
			FROM products AS p
			INNER JOIN categories AS c ON p.category = c.id
			LEFT JOIN product_inventory AS pi ON p.id = pi.product_id
			WHERE p.id = ? AND (pi.expiration_date > CURRENT_DATE OR pi.expiration_date IS NULL)
			GROUP BY p.id",
			array($id)
		))[0];
		$this->call->view('admin/view-product', [
			'pageTitle' => 'Admin | View Product',
			'breadCrumb' => 'View Product',
			'product' => $product
		]);
	}

	function ingredients()
	{
		$this->call->view('admin/ingredients', [
			'pageTitle' => 'Admin | Ingredients',
			'breadCrumb' => 'Ingredients'
		]);
	}
}
