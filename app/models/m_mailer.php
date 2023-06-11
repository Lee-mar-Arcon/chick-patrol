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
        $this->call->database();
        $this->call->library('email');
        $this->call->model('m_encrypt');
        $this->email->sender($this->sender);
        $this->email->recipient($email);
        $this->email->subject($subject);
        $this->email->reply_to($this->sender);
        $encryptedEmail = $this->m_encrypt->encrypt($email);
        $this->email->email_content($this->forgot_password_body($encryptedEmail, $subject), 'html');
        $result = $this->email->send();
        if ($result) {
            $exists = $this->db->table('reset_password_code')->where('email', $email)->get();
            if ($exists)
                $this->db->table('reset_password_code')->where('email', $email)->update(['code' => $encryptedEmail, 'email' => $email]);
            else
                $this->db->table('reset_password_code')->insert(['code' => $encryptedEmail, 'email' => $email]);
        }
        return $result;
    }

    public function forgot_password_body($email, $subject)
    {
        $htmlVal = '                            
        <div style="
        padding-top: 15px;
        padding-bottom: 25px;
        background-color: white;
        border-top: 10px solid;
        border-color: #0f0f11 ;">
            <center>
                <h1 style="
                    color:#0f0f11;
                    margin-bottom: 20px;">
                        ' . $subject . '
                </h1>
                <img src="' . BASE_URL . PUBLIC_DIR . '/logo.png' . '" alt="chick-patrol logo">
                <h2 style="color:black;">
                    To reset you password, open the link below: 
                </h2>
                <a href="' . BASE_URL . 'account/reset-password/' . $email . '" style="text-decoration: none; color: white; border: solid #f0ffffba 2px; border-radius: 1rem; padding: 1rem 1.5rem; background-color: black; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Reset Password Link</a>
                <p style="color:#0f0f11; padding-top: 5rem">Thank you for Choosing us!</p>
            </center>
        </div>';

        return $htmlVal;
    }
}
