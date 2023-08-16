<?php
class M_admin extends Model
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Singapore");
		$this->call->model('M_encrypt');
	}

	// BARANGAY FUNCTIONS
	function barangay_index()
	{
		return $this->M_encrypt->encrypt($this->db->table('barangays')->order_by('name', 'asc')->get_all());
	}

	// CATEGORY FUNCTIONS
	function category_index()
	{
		return $this->M_encrypt->encrypt($this->db->table('categories')->order_by('name', 'asc')->get_all());
	}

	function category_store($name, $image)
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
			$this->db->table('categories')->insert(['name' => $name, 'image' => $image]);
			$this->session->set_flashdata(['formMessage' => 'success']);
		}
	}

	function category_update($id, $name, $filename)
	{
		$id = $this->M_encrypt->decrypt($id);
		$name = $name;
		$exists = $this->db->table('categories')->where('LOWER(name)', strtolower($name))->not_where('id', $id)->get();

		if ($exists) {
			$this->session->set_flashdata(['formMessage' => 'exists']);
			$this->session->set_flashdata(['formData' => $_POST]);
		} else {
			$this->db->table('categories')->where('id', $id)->update(['name' => $name, 'image' => $filename]);
			$this->session->set_flashdata(['formMessage' => 'updated']);
		}
	}

	function category_destroy($id)
	{
		$id = $this->M_encrypt->decrypt($id);
		$this->db->table('categories')->where('id', $id)->update(['deleted_at' => date("Y-m-d H:i:s")]);
		$this->session->set_flashdata(['formMessage' => 'deleted']);
	}

	function category_restore($id)
	{
		$id = $this->M_encrypt->decrypt($this->io->post('id'));
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
			'users' => $this->M_encrypt->encrypt($this->db->raw(
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
	function product_store($name, $category, $price, $description, $filename, $inventoryType, $selling)
	{
		$bind = array(
			'name' => $name,
			'category' => $this->M_encrypt->decrypt($category),
			'price' => $price,
			'description' => $description,
			'image' => $filename,
			'inventory_type' => $inventoryType,
			'selling' => $selling
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
			$category = $this->M_encrypt->decrypt($category);
			$category = '%' . $category . '%';
		}

		if (ctype_space($q) || $q == 'all')
			$q = '%%';
		else
			$q = '%' . trim($q) . '%';

		$totalRows = $this->db->raw(
			"SELECT COUNT(p.id) as total
			FROM products AS p
			INNER JOIN categories AS c ON p.category = c.id
			LEFT JOIN product_inventory AS pi ON p.id = pi.product_id
			WHERE p.name LIKE ? AND p.category LIKE ? AND p.selling LIKE ? AND (pi.expiration_date > CURRENT_DATE OR p.inventory_type = 'perishable')",
			[$q, $category, $availability]
		);
		$totalRows = count($totalRows) > 0 ? $totalRows[0]['total'] : 0;
		return [
			'products' => $this->M_encrypt->encrypt($this->db->raw(
				"SELECT 
					p.*,
					c.name AS category_name,
					IF(p.inventory_type = 'durable',
						(SELECT SUM(inner_pi.remaining_quantity) FROM product_inventory AS inner_pi WHERE inner_pi.product_id = p.id AND inner_pi.expiration_date > NOW()),
						(
							SELECT MIN(can_make)
							FROM (
									SELECT FLOOR((IF(SUM(inner_ii.remaining_quantity) IS NULL, 0, SUM(inner_ii.remaining_quantity)) / pi.need_quantity)) AS can_make
									FROM product_ingredients AS pi
									INNER JOIN ingredients AS i ON pi.ingredient_id = i.id
									LEFT JOIN ingredient_inventory AS inner_ii ON pi.id = inner_ii.product_ingredient_id
									WHERE (inner_ii.expiration_date > NOW() OR inner_ii.expiration_date IS NULL)
									GROUP BY pi.id
							) AS available_quantity
						)
					) AS available_quantity
				FROM products AS p
				INNER JOIN categories AS c ON p.category = c.id		  
				WHERE p.name LIKE ? AND p.category LIKE ? AND p.selling LIKE ?
				ORDER BY p.name
				LIMIT 10 OFFSET ?",
				[$q, $category, $availability, ($page - 1)  * 10]
			)),
			'pagination' => [
				'totalRows' => $totalRows,
				'totalPage' => ceil($totalRows / 10),
				'currentPage' => (int)$page
			],
			'q' => [
				$page, $q, $category, $availability
			],
		];
	}

	function product_search($q)
	{
		if (strlen($q) == 0) $q = '%%';
		else $q = '%' . $q . '%';
		return $this->M_encrypt->encrypt($this->db->table('products')->select('name, id')->like('name', $q)->order_by('name', 'ASC')->limit(10)->get_all());
	}

	function barangay_search($q)
	{
		if (strlen($q) == 0) $q = '%%';
		else $q = '%' . $q . '%';
		return $this->M_encrypt->encrypt($this->db->table('barangays')->select('name, id')->like('name', $q)->order_by('name', 'ASC')->limit(10)->get_all());
	}

	function delivery_fee_history($id, $date)
	{
		$date .= '%';
		$result['history'] = $this->db->table('delivery_fee_history as d')->select("DATE_FORMAT(d.added_at, '%b %d') as added_at, d.delivery_fee")->where('barangay_id', $this->M_encrypt->decrypt($id))->like('added_at', $date)->order_by('added_at', 'ASC')->get_all();
		$result['barangay'] = $this->db->table('barangays')->where('id', $this->M_encrypt->decrypt($id))->get();
		return $result;
	}

	function product_price_history($id, $date)
	{
		$date .= '%';
		$result['history'] = $this->db->table('product_price_history as p')->select("DATE_FORMAT(p.added_at, '%b %d') as added_at, p.price")->where('product_id', $this->M_encrypt->decrypt($id))->like('added_at', $date)->order_by('added_at', 'ASC')->get_all();
		$result['product'] = $this->db->table('products as p')->select('p.name, p.price, categories.name as category')->inner_join('categories', 'p.category=categories.id')->where('p.id', $this->M_encrypt->decrypt($id))->get();
		return $result;
	}

	function for_approval_index($page, $q)
	{
		if (ctype_space($q) || $q == 'all')
			$q = '%%';
		else
			$q = '%' . trim($q) . '%';

		$totalRows = $this->db->raw('select count(u.id) as total from users as u inner join cart as c on u.id=c.user_id where c.status = "for approval" and (u.first_name like ? or u.middle_name like ? or u.last_name like ?)', array($q, $q, $q))[0]['total'];

		return [
			'forApprovalList' => $this->M_encrypt->encrypt($this->db->raw('SELECT u.*, DATE_FORMAT(c.for_approval_at, "%b %d, %Y %h:%i %p") as for_approval_at, c.id as id FROM users as u INNER JOIN cart as c ON u.id=c.user_id WHERE c.status = "for approval" AND (u.first_name LIKE ? OR u.middle_name LIKE ? OR u.last_name LIKE ?) ORDER BY c.for_approval_at DESC LIMIT 10 OFFSET ?', array($q, $q, $q, ($page - 1) * 10))),
			'pagination' => [
				'totalRows' => $totalRows,
				'totalPage' => ceil($totalRows / 10),
				'currentPage' => (int)$page
			],
			'q' => [
				$page, $q
			]
		];
	}

	function on_delivery_index($page, $q)
	{
		if (ctype_space($q) || $q == 'all')
			$q = '%%';
		else
			$q = '%' . trim($q) . '%';

		$totalRows = $this->db->raw('select count(u.id) as total from users as u inner join cart as c on u.id=c.user_id where c.status = "on delivery" and (u.first_name like ? or u.middle_name like ? or u.last_name like ?)', array($q, $q, $q))[0]['total'];

		return [
			'onDeliveryList' => $this->M_encrypt->encrypt($this->db->raw('SELECT u.*, DATE_FORMAT(c.on_delivery_at, "%b %d, %Y %h:%i %p") as on_delivery_at, c.id as id FROM users as u INNER JOIN cart as c ON u.id=c.user_id WHERE c.status = "on delivery" AND (u.first_name LIKE ? OR u.middle_name LIKE ? OR u.last_name LIKE ?) ORDER BY c.on_delivery_at DESC LIMIT 10 OFFSET ?', array($q, $q, $q, ($page - 1) * 10))),
			'pagination' => [
				'totalRows' => $totalRows,
				'totalPage' => ceil($totalRows / 10),
				'currentPage' => (int)$page
			],
			'q' => [
				$page, $q
			]
		];
	}

	function on_preparation_index($page, $q)
	{
		if (ctype_space($q) || $q == 'all')
			$q = '%%';
		else
			$q = '%' . trim($q) . '%';

		$totalRows = $this->db->raw('select count(u.id) as total from users as u inner join cart as c on u.id=c.user_id where c.status = "preparing" and (u.first_name like ? or u.middle_name like ? or u.last_name like ?)', array($q, $q, $q))[0]['total'];

		return [
			'onPreparationList' => $this->M_encrypt->encrypt($this->db->raw('SELECT u.*, DATE_FORMAT(c.for_approval_at, "%b %d, %Y %h:%i %p") as approved_at, c.id as id FROM users as u INNER JOIN cart as c ON u.id=c.user_id WHERE c.status = "preparing" AND (u.first_name LIKE ? OR u.middle_name LIKE ? OR u.last_name LIKE ?) ORDER BY c.approved_at DESC LIMIT 10 OFFSET ?', array($q, $q, $q, ($page - 1) * 10))),
			'pagination' => [
				'totalRows' => $totalRows,
				'totalPage' => ceil($totalRows / 10),
				'currentPage' => (int)$page
			],
			'q' => [
				$page, $q
			]
		];
	}

	function rejected_orders_index($page, $q)
	{
		if (ctype_space($q) || $q == 'all')
			$q = '%%';
		else
			$q = '%' . trim($q) . '%';

		$totalRows = $this->db->raw('select count(u.id) as total from users as u inner join cart as c on u.id=c.user_id where c.status = "rejected" and (u.first_name like ? or u.middle_name like ? or u.last_name like ?)', array($q, $q, $q))[0]['total'];

		return [
			'rejectedOrdersList' => $this->M_encrypt->encrypt($this->db->raw('SELECT u.*, DATE_FORMAT(c.rejected_at, "%b %d, %Y %h:%i %p") as rejected_at, c.id as id FROM users as u INNER JOIN cart as c ON u.id=c.user_id WHERE c.status = "rejected" AND (u.first_name LIKE ? OR u.middle_name LIKE ? OR u.last_name LIKE ?) ORDER BY c.rejected_at DESC LIMIT 10 OFFSET ?', array($q, $q, $q, ($page - 1) * 10))),
			'pagination' => [
				'totalRows' => $totalRows,
				'totalPage' => ceil($totalRows / 10),
				'currentPage' => (int)$page
			],
			'q' => [
				$page, $q
			]
		];
	}

	function ingredients_index($page, $q)
	{
		if (ctype_space($q) || $q == 'all')
			$q = '%%';
		else
			$q = '%' . trim($q) . '%';
		$totalRows = $this->db->table('ingredients')->select_count('id', 'total')->like('name', $q)->get()['total'];

		return [
			'ingredients' => $this->M_encrypt->encrypt($this->db->table('ingredients as i')->select('i.*, DATE_FORMAT(i.deleted_at, "%M %e, %Y %l:%i %p") as deleted_at')->like('i.name', $q)->get_all()),
			'pagination' => [
				'totalRows' => $totalRows,
				'totalPage' => ceil($totalRows / 10),
				'currentPage' => (int)$page
			],
		];
	}
}
