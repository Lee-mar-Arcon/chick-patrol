<?php
class m_admin extends Model
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
	}

	function barangay_index()
	{
		$this->call->model('m_encrypt');
		return $this->m_encrypt->encrypt($this->db->table('barangays')->order_by('name', 'asc')->get_all());
	}
}
