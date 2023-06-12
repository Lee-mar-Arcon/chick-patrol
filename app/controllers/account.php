<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class account extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->call->model('m_account');
		date_default_timezone_set("Asia/Singapore");
	}
	public function index()
	{
		$this->call->view('welcome_page');
	}

	public function login()
	{
		$this->session->unset_userdata('user');
		$this->call->view('account/login', [
			'pageTitle' => 'login'
		]);
	}

	public function register()
	{
		$this->call->database();
		$this->call->view('account/register', [
			'pageTitle' => 'register',
			'barangays' => $this->db->table('barangays')->get_all()
		]);
	}
	public function forgot_password()
	{
		$this->call->view('account/forgot-password', [
			'pageTitle' => 'forgot-password'
		]);
	}

	public function verify_email($email)
	{
		$this->call->database();
		$this->call->model('m_encrypt');
		$encryptedEmail = $email;
		$email = $this->m_encrypt->decrypt($email);

		// $this->send_email_code($email);
		$this->call->view('account/verify-email', [
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
				redirect('account/register');
			} else 
					if ($this->form_validation->run()) {
				$result = $this->m_account->register_user(
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
					redirect('account/register');
				} else {
					$this->call->model('m_encrypt');
					redirect('account/verify_email/' . $this->m_encrypt->encrypt($this->io->post('email')));
				}
			} else {
				$formData = array('formData' => $_POST);
				$this->session->set_flashdata(['errorMessage' => $this->form_validation->get_errors()[0]]);
				$this->session->set_flashdata($formData);
				redirect('account/register');
			}
		} else {
			$this->call->view('errors/error_404', ['heading' => '404 Not Found', 'message' => 'Page not Found']);
		}
	}

	public function send_email_code($email = '')
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->call->model('m_mailer');
			$this->call->model('m_encrypt');
			$this->call->database();

			$code = $this->db->raw('select code from email_codes where user_email = ? limit 1', array($email))[0]['code'];

			$this->m_mailer->send_mail($email, 'Account Verification', $code, $this->m_encrypt->encrypt($email));
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
				$user = $this->db->table('users')->where('email', $this->io->post('email'))->where_not_null('verified_at')->limit(1)->get_all();
				if (count($user) > 0) {
					if (password_verify($this->io->post('password'), $user[0]['password'])) {
						$this->session->set_userdata('user', $user[0]);
						if ($user[0]['is_admin'])
							redirect('admin/dashboard');
						else
							redirect('customer/home-page');
					} else {
						$this->session->set_flashdata(['error' => 'Wrong credentials']);
					}
				} else if (count($user) == 0) {
					$this->session->set_flashdata(['error' => 'User does not exists.']);
				}
			} else {
				$this->session->set_flashdata(['error' => $this->form_validation->get_errors()[0]]);
			}
			$formData = array('formData' => $_POST);
			$this->session->set_flashdata($formData);
			redirect('account/login');
		}
	}

	function reset_password($email)
	{
		$this->call->database();
		$exists = $this->db->table('reset_password_code')->where('code', $email)->get();
		if ($exists)
			$this->call->view('account/reset-password', [
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

		$this->call->model('m_encrypt');
		$encryptedEmail = $email;
		$email = $this->m_encrypt->decrypt($email);

		if ($this->form_validation->run()) {
			$result = $this->m_account->update_password(
				$email,
				$this->io->post('password'),
			);
			redirect('account/login');
		} else {
			$this->session->set_flashdata(['error' => $this->form_validation->get_errors()[0]]);
			redirect('account/reset-password/' . $encryptedEmail);
		}
	}
}
