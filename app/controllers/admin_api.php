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
	}

	function barangay_store()
	{
		try {
			$this->is_authorized();

			$this->call->database();
			$postData = json_decode(file_get_contents('php://input'), true);
			$_POST = $postData;
			$this->call->library('form_validation');
			$name = $postData['name'];
			var_dump($_POST);
			$this->form_validation
				->name('name')
				->min_length(1)
				->max_length(100);

			if ($this->form_validation->run()) {
				$exists = $this->db->table('barangays')->where('name', $name)->get();
				if ($exists) {
					if ($exists['deleted_at'] == null)
						echo 'Name already exists';
					else {
						$this->db->table('barangays')->where('name', $name)->update(['deleted_at' => null]);
						echo 'success';
					}
				} else {
					$this->db->table('barangays')->insert(['name' => $name]);
					echo 'success';
				}
			}else
				echo 'haha';
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function barangay_update()
	{
		try {
			$this->is_authorized();

			$this->call->database();
			$postData = json_decode(file_get_contents('php://input'), true);
			$name = $postData['name'];
			$this->call->model('m_encrypt');
			$id = $this->m_encrypt->decrypt($postData['id']);

			$exists = $this->db->table('barangays')->where('name', $name)->not_where('id', $id)->get();
			if ($exists) {
				echo 'Name already exists';
			} else {
				$this->db->table('barangays')->where('id', $id)->update(['name' => $name]);
				echo 'success';
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
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
}
