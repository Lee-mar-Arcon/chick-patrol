<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class account extends Controller {

	public function __construct()
	{
		 parent::__construct();
		//  $this->call->helper(array('form', 'alert'));
		 $this->call->model('m_account');
		 date_default_timezone_set("Asia/Singapore");
	}
	public function index() {
		$this->call->view('welcome_page');
	}

	public function login() {
		$this->call->view('account/login',[
			'pageTitle' => 'login'
		]);
	}

	public function register() {
		$this->call->view('account/register',[
			'pageTitle' => 'register'
		]);
	}
	public function forgot_password() {
		$this->call->view('account/forgot-password',[
			'pageTitle' => 'forgot-password'
		]);
	}

	public function handle_register_submit()
	{
		if ($this->form_validation->submitted()) {

			$this->form_validation
				 ->name('firstName')->required('First name is required.')
				 ->min_length(1, 'First name must be atleast 1 characters in length.')
				 ->max_length(50, 'First name must be less than 50 characters in length.')
				 ->name('lastName')->required('Last name is required.')
				 ->min_length(1, 'Last name must be atleast 1 characters in length.')
				 ->max_length(50, 'Last name must be less than 50 characters in length.')
				 ->name('sex')->required('Sex is required')
				 ->min_length(4)
				 ->max_length(6)
				 ->name('birthDate')->required('Birthdate is required.')
				 ->name('street')->required('Street is required.')
				 ->min_length(1,'asd')
				 ->max_length(50)
				 ->name('barangay')->required('Barangay is required.')
				 ->numeric()
				 ->name('contact')->required('Contact is required.')
				 ->min_length(11, 'Contact number in not valid!')
				 ->max_length(11, 'Contact number in not valid!')
				 ->name('email')->required('Email is required.')
				 ->valid_email('Your email is not valid!');

			if (!preg_match('/@gmail\.com$/i', $this->io->post('email'))) {
				$formData = array('formData' => $_POST);
				$this->session->set_flashdata(['errorMessage' => 'Email is not a valid gmail address.']);
				$this->session->set_flashdata($formData);
				redirect('account/register');
			} else 
					if ($this->form_validation->run()) {
						$result = $this->m_account->register_user(
							$this->io->post('firstName'),
							$this->io->post('lastName'),
							$this->io->post('contact'),
							$this->io->post('barangay'),
							$this->io->post('street'),
							$this->io->post('birthDate'),
							$this->io->post('sex'),
							$this->io->post('email'),
							$this->io->post('middleName'),
						);
						if ($result == 'exists'){
							$formData = array('formData' => $_POST);
							$this->session->set_flashdata(['errorMessage' => 'Email already exists, please log in instead to check you account.']);
							$this->session->set_flashdata($formData);
							redirect('account/register');
						} else{
							echo 'redirect to email verification code';
						}
					}
					else{
						$formData = array('formData' => $_POST);
						$this->session->set_flashdata(['errorMessage' => $this->form_validation->get_errors()[0]]);
						$this->session->set_flashdata($formData);
						redirect('account/register');
					}
		}else{
			$this->call->view('errors/error_404', ['heading' => '404 Not Found', 'message' => 'Page not Found']);
		}
	}
}
?>