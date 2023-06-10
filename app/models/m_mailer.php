<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');



class m_mailer extends Model
{
	public $sender = 'chick.patrol@gmail.com';

	public function __construct()
	{
		parent::__construct();
	}

	public function send_mail($recipient, $subj, $code)
	{
		$this->call->library('email');
		$this->email->sender($this->sender);
		$this->email->recipient($recipient);
		$this->email->subject($subj);
		$this->email->reply_to($this->sender);
		$this->email->email_content($this->email_verification_body($code, $subj), 'html');
		return $this->email->send();
	}

	public function email_verification_body($code, $subj)
	{
		$htmlVal = '                            
    <div 
    style="
    padding-top: 15px;
    padding-bottom: 25px;
    background-color: white;
    border-top: 10px solid;
    border-color: #0f0f11 ;">
        <center>
            <h1 
                style="
                color:#0f0f11;
                margin-bottom: 20px;">
                    ' . $subj . '
            </h1>
            <img src="' . BASE_URL . PUBLIC_DIR . '/logo.png' . '" alt="chick-patrol logo"></img>
            <h2 style="color:black;">
                To fully verify your account and get full access to our website please use this code to verify you gmail: 
            </h2>
            <h1 style="color:black;">
              ' . $code . '
          </h1>
            <p style="color:#0f0f11; padding-top: 5rem">Thank you for Choosing us!</p>
            
        </center>
    </div>';

		return $htmlVal;
	}

	function send_forgot_password_link($email, $subject)
	{
		$this->call->library('email');
		$this->call->model('m_encrypt');
		$this->email->sender($this->sender);
		$this->email->recipient($email);
		$this->email->subject($subject);
		$this->email->reply_to($this->sender);
		$this->email->email_content($this->forgot_password_body($this->m_encrypt->encrypt($email), $subject), 'html');
		return $this->email->send();
	}

	public function forgot_password_body($email, $subject)
	{
		$htmlVal = '                            
    <div 
    style="
    padding-top: 15px;
    padding-bottom: 25px;
    background-color: white;
    border-top: 10px solid;
    border-color: #0f0f11 ;">
        <center>
            <h1 
                style="
                color:#0f0f11;
                margin-bottom: 20px;">
                    ' . $subject . '
            </h1>
            <img src="' . BASE_URL . PUBLIC_DIR . '/logo.png' . '" alt="chick-patrol logo"></img>
            <h2 style="color:black;">
                To reset you password, open the link below: 
            </h2>
            <h1 style="color:black;">
              ' . $email . '
         	</h1>
            <p style="color:#0f0f11; padding-top: 5rem">Thank you for Choosing us!</p>
            
        </center>
    </div>';

		return $htmlVal;
	}
}
