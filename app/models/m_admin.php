<?php
class m_admin extends Model
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('m_encrypt');
	}

	// BARANGAY FUNCTIONS
	function barangay_index()
	{
		return $this->m_encrypt->encrypt($this->db->table('barangays')->order_by('name', 'asc')->get_all());
	}

	// CATEGORY FUNCTIONS
	function category_index()
	{
		return $this->m_encrypt->encrypt($this->db->table('categories')->order_by('name', 'asc')->get_all());
	}

	function category_store($name)
	{
		$exists = $this->db->table('categories')->where('LOWER(name)', strtolower($name))->get();
		if ($exists) {
			if ($exists['deleted_at'] == null) {
				$this->session->set_flashdata(['formMessage' => 'exists']);
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

	function category_update($id, $name)
	{
		$id = $this->m_encrypt->decrypt($id);
		$name = $name;
		$exists = $this->db->table('categories')->where('LOWER(name)', strtolower($name))->not_where('id', $id)->get();

		if ($exists) {
			$this->session->set_flashdata(['formMessage' => 'exists']);
			$this->session->set_flashdata(['formData' => $_POST]);
		} else {
			$this->db->table('categories')->where('id', $id)->update(['name' => $name]);
			$this->session->set_flashdata(['formMessage' => 'updated']);
		}
	}

	function category_destroy($id)
	{
		$id = $this->m_encrypt->decrypt($id);
		$this->db->table('categories')->where('id', $id)->update(['deleted_at' => date("Y-m-d H:i:s")]);
		$this->session->set_flashdata(['formMessage' => 'deleted']);
	}

	function category_restore($id)
	{
		$id = $this->m_encrypt->decrypt($this->io->post('id'));
		$this->db->table('categories')->where('id', $id)->update(['deleted_at' => null]);
		$this->session->set_flashdata(['formMessage' => 'restored']);
	}

	// USERS FUNCTIONS
	function user_index($page, $status, $q)
	{
		if (ctype_space($q) || $q == 'all')
			$q = '%%';
		else
			$q = '%' . trim($q) . '%';

		$totalRows = $this->db->raw(
			"
			SELECT
			COUNT(u.id) as total
			FROM
			users AS u
			INNER JOIN barangays AS b ON u.barangay = b.id
			WHERE
			u.is_admin = 0
			AND u.is_banned NOT LIKE ?
			AND (u.first_name LIKE ? OR u.middle_name LIKE ? OR u.last_name LIKE ?)
		",
			[$status, $q, $q, $q]
		)[0]['total'];

		return [
			'users' => $this->m_encrypt->encrypt($this->db->raw(
				"
				SELECT
				u.id AS id,
				u.first_name AS first_name,
				u.middle_name AS middle_name,
				u.last_name AS last_name,
				u.email AS email,
				b.name AS barangay_name,
				u.street,
				u.contact,
				u.birth_date,
				u.sex,
				u.verified_at,
				u.is_banned
				FROM
				users AS u
				INNER JOIN barangays AS b ON u.barangay = b.id
				WHERE
				u.is_admin = 0
				AND u.is_banned NOT LIKE ?
				AND (u.first_name LIKE ? OR u.middle_name LIKE ? OR u.last_name LIKE ?) order by u.first_name LIMIT 10 OFFSET ? 
			",
				[$status, $q, $q, $q, ($page - 1)  * 10]
			)),
			'pagination' => [
				'totalRows' => $totalRows,
				'totalPage' => ceil($totalRows / 10),
				'currentPage' => (int)$page
			]
		];
	}
}
