<?php
class m_account extends Model { 

	public function register_user($firstName, $lastName, $contact, $barangay, $street, $birthDate, $sex, $email, $middleName = '')
	{
		$data = array(
			'firstName'     => $firstName,
			'middleName'    => $middleName,
			'lastName'      => $lastName,
			'contact'       => $contact,
			'barangay'      => $barangay,
			'street'        => $street,
			'birthDate'     => $birthDate,
			'email'     => $email,
			'sex'           => $sex,
			);

		$exists = $this->db->table('users')->where('email', $email)->where_not_null('verifiedAt')->get_all();
		if(count($exists) > 0) return 'exists';

		$exists = $this->db->table('users')->where('email', $email)->where_null('verifiedAt')->get_all();
		if(count($exists) > 0){
			$this->db->table('users')->where('id', $exists[0]['id'])->update($data);
		}
		else
			$this->db->table('users')->insert($data);
		return 'success';
	}
}   
?>