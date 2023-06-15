<?php
class m_admin extends Model
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
	}

	// BARANGAY FUNCTIONS
	function barangay_index()
	{
		$this->call->model('m_encrypt');
		return $this->m_encrypt->encrypt($this->db->table('barangays')->order_by('name', 'asc')->get_all());
	}

	// CATEGORY FUNCTIONS
	function category_index()
	{
		$this->call->model('m_encrypt');
		return $this->m_encrypt->encrypt($this->db->table('categories')->order_by('name', 'asc')->get_all());
	}

	function category_store($name)
	{
		$exists = $this->db->table('categories')->where('LOWER(name)', strtolower($name))->get();
		if ($exists) {
			if ($exists['deleted_at'] == null) {
				$this->session->set_flashdata(['formMessage' => 'Name already exists']);
				$this->session->set_flashdata(['formData' => $_POST]);
			} else {
				$this->db->table('categories')->where('LOWER(name)', strtolower($name))->update(['deleted_at' => null]);
				$this->session->set_flashdata(['formMessage' => 'restored']);
			}
		} else {
			$this->db->table('categories')->insert(['name' => $name]);
			$this->session->set_flashdata(['formMessage' => 'success']);
		}
	}
}
