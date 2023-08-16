<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class Admin extends Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('M_admin');

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
		$this->call->view('Admin/dashboard', [
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
		$barangays = $this->M_admin->barangay_index();

		$this->call->view('Admin/barangay', [
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
		redirect('Admin/barangay');
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
			$this->call->model('M_encrypt');
			$id = $this->M_encrypt->decrypt($this->io->post('id'));
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
		redirect('Admin/barangay');
	}

	function barangay_restore()
	{
		$this->form_validation
			->name('id')->required('ID is required.');
		if ($this->form_validation->run()) {
			$this->call->model('M_encrypt');
			$id = $this->M_encrypt->decrypt($this->io->post('id'));
			$this->db->table('barangays')->where('id', $id)->update(['deleted_at' => null]);
			$this->session->set_flashdata(['formMessage' => 'restored']);
			redirect('Admin/barangay');
		} else {
			echo 'ID is required';
		}
	}

	function barangay_destroy()
	{
		$this->form_validation
			->name('id')->required('ID is required.');

		if ($this->form_validation->run()) {
			$this->call->model('M_encrypt');
			$id = $this->M_encrypt->decrypt($this->io->post('id'));
			$this->db->table('barangays')->where('id', $id)->update(['deleted_at' => date("Y-m-d H:i:s")]);
			$this->session->set_flashdata(['formMessage' => 'deleted']);
			redirect('Admin/barangay');
		} else {
			echo 'ID is required';
		}
	}



	// CATEGORY
	function category()
	{
		$categories = $this->M_admin->category_index();
		$this->call->view('Admin/category', [
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
					$this->M_admin->category_store($this->io->post('name'), $filename);
				} else {
					$this->session->set_flashdata(['formMessage' => $this->form_validation->get_errors()[0]]);
					$this->session->set_flashdata(['formData' => $_POST]);
				}
			else
				$this->session->set_flashdata(['formMessage' => 'upload error']);
			redirect('Admin/category');
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
			$id = $this->M_encrypt->decrypt($this->io->post('id'));
			$currentCategory = $this->db->table('categories')->where('id', $id)->get();
			$filename = $currentCategory['image'];
			if (strlen($_FILES['imageInput']['name']) > 0) {
				unlink('././public/images/category/cropped/' . $currentCategory['image']);
				unlink('././public/images/category/original/' . $currentCategory['image']);
				$filename = $this->upload_cropped_image($this->uploadOriginalImage('category'), 'category');
			}

			$this->M_admin->category_update($this->io->post('id'), $this->io->post('name'), $filename);
		} else {
			$this->session->set_flashdata(['formMessage' => $this->form_validation->get_errors()[0]]);
			$this->session->set_flashdata(['formData' => $_POST]);
		}
		redirect('Admin/category');
	}

	function category_destroy()
	{
		$this->form_validation
			->name('id')->required('ID is required.');

		if ($this->form_validation->run()) {
			$this->M_admin->category_destroy($this->io->post('id'));
			redirect('Admin/category');
		} else {
			echo 'ID is required';
		}
	}

	function category_restore()
	{
		$this->form_validation
			->name('id')->required('ID is required.');
		if ($this->form_validation->run()) {
			$this->M_admin->category_restore($this->io->post('id'));
			redirect('Admin/category');
		} else {
			echo 'ID is required';
		}
	}

	function user()
	{
		$this->call->view('Admin/user', [
			'pageTitle' => 'Admin | Users',
			'breadCrumb' => 'Users',
		]);
	}

	// PRODUCT
	function product()
	{
		$this->call->model('M_encrypt');
		$categoriesForForm = $this->M_encrypt->encrypt($this->db->table('categories')->where_null('deleted_at')->get_all());
		$this->call->view('Admin/product', [
			'pageTitle' => 'Admin | Products',
			'breadCrumb' => 'Products',
			'categories' => $this->M_admin->category_index(),
			'categoriesForForm' => $categoriesForForm,
			'formMessage' => $this->session->flashdata('formMessage') !== null ? $this->session->flashdata('formMessage') : null,
			'formData' => $this->session->flashdata('formData') !== null ? $this->session->flashdata('formData') : null,
			'formErrors' => $this->session->flashdata('formErrors') !== null ? $this->session->flashdata('formErrors') : null,
		]);
	}

	function product_available()
	{
		$this->form_validation
			->name('id')->required('ID is required.');
		if ($this->form_validation->run()) {
			$this->call->model('M_encrypt');
			$id = $this->M_encrypt->decrypt($this->io->post('id'));
			$this->db->table('products')->where('id', $id)->update(['selling' => 1]);
			$this->session->set_flashdata(['formMessage' => 'selling']);
			redirect('Admin/product');
		} else {
			echo 'ID is required';
		}
	}

	function product_unavailable()
	{
		$this->form_validation
			->name('id')->required('ID is required.');
		if ($this->form_validation->run()) {
			$this->call->model('M_encrypt');
			$id = $this->M_encrypt->decrypt($this->io->post('id'));
			$this->db->table('products')->where('id', $id)->update(['selling' => 0]);
			$this->session->set_flashdata(['formMessage' => 'unavailable']);
			redirect('Admin/product');
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
			$this->call->model('M_encrypt');
			$id = $this->M_encrypt->decrypt($this->io->post('id'));
			$this->db->table('users')->where('id', $id)->update(['is_banned' => 1]);
			$this->session->set_flashdata(['formMessage' => 'deleted']);
			redirect('Admin/user');
		} else {
			echo 'ID is required';
		}
	}

	function reactivate_user()
	{
		$this->form_validation
			->name('id')->required('ID is required.');

		if ($this->form_validation->run()) {
			$this->call->model('M_encrypt');
			$id = $this->M_encrypt->decrypt($this->io->post('id'));
			$this->db->table('users')->where('id', $id)->update(['is_banned' => 0]);
			$this->session->set_flashdata(['formMessage' => 'deleted']);
			redirect('Admin/user');
		} else {
			echo 'ID is required';
		}
	}

	function approval()
	{
		$this->call->view('Admin/for-approval', [
			'pageTitle' => 'Admin | For Approval',
			'breadCrumb' => 'For Approval'
		]);
	}

	function rejected_order()
	{
		$this->call->view('Admin/rejected-order', [
			'pageTitle' => 'Admin | Rejected Orders',
			'breadCrumb' => 'Rejected Orders'
		]);
	}

	function preparing()
	{
		$this->call->view('Admin/preparing', [
			'pageTitle' => 'Admin | On Preparation',
			'breadCrumb' => 'On Preparation'
		]);
	}

	function on_delivery()
	{
		$this->call->view('Admin/on-delivery', [
			'pageTitle' => 'Admin | On Delivery',
			'breadCrumb' => 'On Delivery'
		]);
	}

	function profile()
	{
		$this->call->view('Admin/profile', [
			'pageTitle' => 'Admin | Profile',
			'breadCrumb' => 'User Profile',
			'barangays' => $this->M_admin->barangay_index(),
			'user' => array_merge($this->db->table('users')->where('id', $this->session->userdata('user')['id'])->get(), $this->db->table('barangays')->select('name as barangay_name, delivery_fee')->where('id', $this->session->userdata('user')['barangay'])->get()),
		]);
	}

	function view_product($id)
	{
		$id = $this->M_encrypt->decrypt($id);
		$product = $this->M_encrypt->encrypt($this->db->raw(
			"SELECT p.*, c.name AS category_name, SUM(pi.quantity) AS quantity
			FROM products AS p
			INNER JOIN categories AS c ON p.category = c.id
			LEFT JOIN product_inventory AS pi ON p.id = pi.product_id
			WHERE p.id = ? AND (pi.expiration_date > CURRENT_DATE OR pi.expiration_date IS NULL)
			GROUP BY p.id",
			array($id)
		))[0];
		$this->call->view('Admin/view-product', [
			'pageTitle' => 'Admin | View Product',
			'breadCrumb' => 'View Product',
			'product' => $product
		]);
	}

	function ingredients()
	{
		$this->call->view('Admin/ingredients', [
			'pageTitle' => 'Admin | Ingredients',
			'breadCrumb' => 'Ingredients'
		]);
	}
}
