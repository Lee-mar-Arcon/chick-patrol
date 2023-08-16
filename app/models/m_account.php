<?php
class M_account extends Model
{

	public function register_user($firstName, $lastName, $contact, $barangay, $street, $birthDate, $sex, $email, $password, $middleName = '')
	{
		$data = array(
			'first_name'     => $firstName,
			'middle_name'    => $middleName,
			'last_name'      => $lastName,
			'contact'       => $contact,
			'barangay'      => $barangay,
			'street'        => $street,
			'birth_date'     => $birthDate,
			'email'     => $email,
			'sex'           => $sex,
			'password'           => password_hash($password, PASSWORD_DEFAULT),
		);

		$exists = $this->db->table('users')->where('email', $email)->where_not_null('verified_at')->get_all();
		if (count($exists) > 0) return 'exists';

		$exists = $this->db->table('users')->where('email', $email)->where_null('verified_at')->limit(1)->get_all();
		if (count($exists) > 0) {
			$this->db->table('users')->where('id', $exists[0]['id'])->update($data);
		} else
			$this->db->table('users')->insert($data);
		return 'success';
	}

	function update_password($email, $password)
	{
		$data = array(
			'password' => password_hash($password, PASSWORD_DEFAULT),
		);

		$this->db->table('reset_password_code')->where('email', $email)->delete();
		$this->db->table('users')->where('email', $email)->update($data);
	}
}
