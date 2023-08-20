<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class Account extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->call->model('M_account');
		date_default_timezone_set("Asia/Singapore");
	}
	public function index()
	{
		$this->call->view('welcome_page');
	}

	public function login()
	{
		$this->session->unset_userdata('user');
		$this->call->view('Account/login', [
			'pageTitle' => 'login'
		]);
	}

	public function register()
	{
		$this->call->database();
		$this->call->view('Account/register', [
			'pageTitle' => 'register',
			'barangays' => $this->db->table('barangays')->where_null('deleted_at')->get_all()
		]);
	}
	public function forgot_password()
	{
		$this->call->view('Account/forgot-password', [
			'pageTitle' => 'forgot-password'
		]);
	}

	public function verify_email($email)
	{
		$this->call->database();
		$this->call->model('M_encrypt');
		$encryptedEmail = $email;
		$email = $this->M_encrypt->decrypt($email);

		// $this->send_email_code($email);
		$this->call->view('Account/verify-email', [
			'pageTitle' => 'verify email address',
			'email' => $encryptedEmail
		]);
	}

	public function handle_register_submit()
	{
		if ($this->form_validation->submitted()) {

			$this->form_validation
				->name('first_name')->required('First name is required.')
				->min_length(1, 'First name must be atleast 1 characters in length.')
				->max_length(50, 'First name must be less than 50 characters in length.')
				->name('last_name')->required('Last name is required.')
				->min_length(1, 'Last name must be atleast 1 characters in length.')
				->max_length(50, 'Last name must be less than 50 characters in length.')
				->name('sex')->required('Sex is required')
				->min_length(4)
				->max_length(6)
				->name('birth_date')->required('Birthdate is required.')
				->name('street')->required('Street is required.')
				->min_length(1, 'Street must be between 1-100 characters only.')
				->max_length(100, 'Street must be between 1-100 characters only.')
				->name('barangay')->required('Barangay is required.')
				->numeric('Data is invalid.')
				->name('contact')->required('Contact is required.')
				->min_length(11, 'Contact number in not valid!')
				->max_length(11, 'Contact number in not valid!')
				->name('email')->required('Email is required.')
				->valid_email('Your email is not valid!')
				->name('password')
				->matches('retype_password', 'Password are not the same.')
				->min_length(8, 'Password length must be 8-16 characters!')
				->max_length(16, 'Password length must be 8-16 characters!');

			if (!preg_match('/@gmail\.com$/i', $this->io->post('email'))) {
				$formData = array('formData' => $_POST);
				$this->session->set_flashdata(['errorMessage' => 'Email is not a valid gmail address.']);
				$this->session->set_flashdata($formData);
				redirect('Account/register');
			} else 
					if ($this->form_validation->run()) {
				$result = $this->M_account->register_user(
					$this->io->post('first_name'),
					$this->io->post('last_name'),
					$this->io->post('contact'),
					$this->io->post('barangay'),
					$this->io->post('street'),
					$this->io->post('birth_date'),
					$this->io->post('sex'),
					$this->io->post('email'),
					$this->io->post('password'),
					$this->io->post('middle_name'),
				);
				if ($result == 'exists') {
					$formData = array('formData' => $_POST);
					$this->session->set_flashdata(['errorMessage' => 'Email already exists, please log in instead to check your account.']);
					$this->session->set_flashdata($formData);
					redirect('Account/register');
				} else {
					$this->call->model('M_encrypt');
					redirect('Account/verify_email/' . $this->M_encrypt->encrypt($this->io->post('email')));
				}
			} else {
				$formData = array('formData' => $_POST);
				$this->session->set_flashdata(['errorMessage' => $this->form_validation->get_errors()[0]]);
				$this->session->set_flashdata($formData);
				redirect('Account/register');
			}
		} else {
			$this->call->view('errors/error_404', ['heading' => '404 Not Found', 'message' => 'Page not Found']);
		}
	}

	public function send_email_code($email = '')
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->call->model('M_mailer');
			$this->call->model('M_encrypt');
			$this->call->database();

			$code = $this->db->raw('select code from email_codes where user_email = ? limit 1', array($email))[0]['code'];

			// $this->M_mailer->send_mail($email, 'Account Verification', $code, $this->M_encrypt->encrypt($email));
			$this->M_mailer->send_mail($email, 'Account Verification', $code);
			return 'email sent';
		} else {
			return 'not sent';
		}
	}

	function handle_login_submit()
	{
		if ($this->form_validation->submitted()) {
			$this->form_validation
				->name('email')->required('Email name is required.')
				->valid_email('Enter a valid gmail address.')
				->name('password')->required('Password is required.');
			if ($this->form_validation->run()) {
				$this->call->database();
				$user = $this->db->table('users as u')->select('u.*, b.delivery_fee')->inner_join('barangays as b', 'u.barangay=b.id')->where('u.email', $this->io->post('email'))->where_not_null('verified_at')->limit(1)->get_all();
				if (count($user) > 0) {
					if ($user[0]['is_banned']) {
						$this->session->set_flashdata(['error' => 'Banned: please contact the administrator.']);
					} else {
						if (password_verify($this->io->post('password'), $user[0]['password'])) {
							$this->session->set_userdata('user', $user[0]);
							if ($user[0]['is_admin'])
								redirect('Admin/dashboard');
							else
								redirect('Customer/homepage');
						} else {
							$this->session->set_flashdata(['error' => 'Wrong credentials']);
						}
					}
				} else if (count($user) == 0) {
					$this->session->set_flashdata(['error' => 'User does not exists.']);
				}
			} else {
				$this->session->set_flashdata(['error' => $this->form_validation->get_errors()[0]]);
			}
			$formData = array('formData' => $_POST);
			$this->session->set_flashdata($formData);
			redirect('Account/login');
		}
	}

	function reset_password($email)
	{
		$this->call->database();
		$exists = $this->db->table('reset_password_code')->where('code', $email)->get();
		if ($exists)
			$this->call->view('Account/reset-password', [
				'pageTitle' => 'Reset Password',
				'encryptedEmail' => $email
			]);
		else
			$this->call->view('errors/error_404', [
				'heading' => '404 not found',
				'message' => 'Link expired'
			]);
	}

	function handle_reset_password_submit($email)
	{
		$this->form_validation
			->name('password')
			->matches('retype_password', 'Password are not the same.')
			->min_length(8, 'Password length must be 8-16 characters!')
			->max_length(16, 'Password length must be 8-16 characters!');

		$this->call->model('M_encrypt');
		$encryptedEmail = $email;
		$email = $this->M_encrypt->decrypt($email);

		if ($this->form_validation->run()) {
			$result = $this->M_account->update_password(
				$email,
				$this->io->post('password'),
			);
			redirect('Account/login');
		} else {
			$this->session->set_flashdata(['error' => $this->form_validation->get_errors()[0]]);
			redirect('Account/reset-password/' . $encryptedEmail);
		}
	}

	function change_email($userID)
	{
		$this->call->model('M_encrypt');
		$userID = $this->M_encrypt->decrypt($userID);
		$this->call->database();
		$newEmail = $this->db->table('change_email_code')->where('user_id', $userID)->get()['email'];
		echo $this->db->table('users')->where('id', $userID)->update(['email' => $newEmail]);
		$this->db->table('change_email_code')->where('user_id', $userID)->delete();
		redirect('Account/login');
	}
}
