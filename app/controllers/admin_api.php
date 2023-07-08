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
	function product_index($page, $q, $category)
	{
		try {
			$this->is_authorized();
			echo json_encode($this->m_admin->product_index($page, $q, $category));
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
