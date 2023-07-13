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
			"SELECT COUNT(u.id) as total FROM users AS u INNER JOIN barangays AS b ON u.barangay = b.id WHERE u.is_admin = 0 AND u.is_banned NOT LIKE ? AND (u.first_name LIKE ? OR u.middle_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ?)",
			[$status, $q, $q, $q, $q]
		)[0]['total'];

		return [
			'users' => $this->m_encrypt->encrypt($this->db->raw(
				" SELECT u.id AS id, u.first_name AS first_name, u.middle_name AS middle_name, u.last_name AS last_name, u.email AS email, b.name AS barangay_name, u.street, u.contact, u.birth_date, u.sex, u.verified_at, u.is_banned FROM users AS u INNER JOIN barangays AS b ON u.barangay = b.id WHERE u.is_admin = 0 AND u.is_banned NOT LIKE ? AND (u.first_name LIKE ? OR u.middle_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ?) order by u.first_name LIMIT 10 OFFSET ?",
				[$status, $q, $q, $q, $q, ($page - 1)  * 10]
			)),
			'pagination' => [
				'totalRows' => $totalRows,
				'totalPage' => ceil($totalRows / 10),
				'currentPage' => (int)$page
			]
		];
	}

	// PRODUCT FUNCTIONS
	function product_store($name, $category, $price, $description, $filename)
	{
		$bind = array(
			'name' => $name,
			'category' => $this->m_encrypt->decrypt($category),
			'price' => $price,
			'description' => $description,
			'image' => $filename
		);
		$this->db->table('products')->insert($bind);
	}

	function product_index($page, $q, $category, $availability)
	{
		if (ctype_space($availability) || $availability == 'all')
			$availability = '%%';
		else {
			$availability = '%' . trim($availability) . '%';
		}

		if (ctype_space($category) || $category == 'all')
			$category = '%%';
		else {
			$category = $this->m_encrypt->decrypt($category);
			$category = '%' . trim($category) . '%';
		}

		if (ctype_space($q) || $q == 'all')
			$q = '%%';
		else
			$q = '%' . trim($q) . '%';

		$totalRows = $this->db->raw(
			"SELECT COUNT(p.id) as total FROM products AS p INNER JOIN categories AS c ON p.category = c.id WHERE p.name LIKE ? AND p.category LIKE ? AND p.available LIKE ?",
			[$q, $category, $availability]
		)[0]['total'];

		return [
			'products' => $this->m_encrypt->encrypt($this->db->raw(
				"SELECT p.*, c.name as category_name FROM products AS p INNER JOIN categories AS c ON p.category = c.id WHERE p.name LIKE ? AND p.category LIKE ? AND p.available LIKE ? order by p.name LIMIT 10 OFFSET ?",
				[$q, $category, $availability, ($page - 1)  * 10]
			)),
			'pagination' => [
				'totalRows' => $totalRows,
				'totalPage' => ceil($totalRows / 10),
				'currentPage' => (int)$page
			]
		];
	}

	function product_search($q)
	{
		if (strlen($q) == 0) $q = '%%';
		else $q = '%' . $q . '%';
		return $this->m_encrypt->encrypt($this->db->table('products')->select('name, id')->like('name', $q)->order_by('name', 'ASC')->limit(10)->get_all());
	}

	function barangay_search($q)
	{
		if (strlen($q) == 0) $q = '%%';
		else $q = '%' . $q . '%';
		return $this->m_encrypt->encrypt($this->db->table('barangays')->select('name, id')->like('name', $q)->order_by('name', 'ASC')->limit(10)->get_all());
	}

	function delivery_fee_history($id, $date)
	{
		$date .= '%';
		$result['history'] = $this->db->table('delivery_fee_history as d')->select("DATE_FORMAT(d.added_at, '%b %d') as added_at, d.delivery_fee")->where('barangay_id', $this->m_encrypt->decrypt($id))->like('added_at', $date)->order_by('added_at', 'ASC')->get_all();
		$result['barangay'] = $this->db->table('barangays')->where('id', $this->m_encrypt->decrypt($id))->get();
		return $result;
	}

	function product_price_history($id, $date)
	{
		$date .= '%';
		$result['history'] = $this->db->table('product_price_history as p')->select("DATE_FORMAT(p.added_at, '%b %d') as added_at, p.price")->where('product_id', $this->m_encrypt->decrypt($id))->like('added_at', $date)->order_by('added_at', 'ASC')->get_all();
		$result['product'] = $this->db->table('products as p')->select('p.name, p.price, categories.name as category')->inner_join('categories', 'p.category=categories.id')->where('p.id', $this->m_encrypt->decrypt($id))->get();
		return $result;
	}
}
