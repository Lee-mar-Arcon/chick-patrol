<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');



class M_mailer extends Model
{
    public $sender = 'chix.patrol.2023@gmail.com';

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

    public function send_change_email_mail($recipient, $user_id)
    {
        $this->call->library('email');
        $this->email->sender($this->sender);
        $this->email->recipient($recipient);
        $this->email->subject('Change Email Link');
        $this->email->reply_to($this->sender);
        $this->email->email_content($this->change_email_body($user_id, 'Change email link'), 'html');
        return $this->email->send();
    }

    public function change_email_body($user_id, $subject)
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
                    To completely change your account email, please click the link below: 
                </h2>
                <a href="' . BASE_URL . 'account/change-email/' . $user_id . '" style="text-decoration: none; color: white; border: solid #f0ffffba 2px; border-radius: 1rem; padding: 1rem 1.5rem; background-color: black; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Change Email Link</a>
                <p style="color:#0f0f11; padding-top: 5rem">Thank you for Choosing us!</p>
            </center>
        </div>';

        return $htmlVal;
    }

    public function approve_cart_mail($recipient, $subj, $cartDetails)
    {
        $this->call->library('email');
        $this->email->sender($this->sender);
        $this->email->recipient($recipient);
        $this->email->subject($subj);
        $this->email->reply_to($this->sender);
        $this->email->email_content($this->approveDeliver_cart_mail_body($cartDetails), 'html');
        return $this->email->send();
    }

    function approveDeliver_cart_mail_body($cartDetails)
    {
        $fullname = strlen($cartDetails['user']['middle_name']) == 0 ? $cartDetails['user']['first_name'] . ' ' . $cartDetails['user']['last_name'] : $cartDetails['user']['first_name'] . ' ' . $cartDetails['user']['middle_name'] . ' ' . $cartDetails['user']['last_name'];
        $productList = '';

        foreach (json_decode($cartDetails['cart']['products']) as $cartProduct) {
            foreach ($cartDetails['products'] as $product) {
                if ($cartProduct->id == $product['id']) {
                    $productList .= '
                    <tr style="border: 1px rgb(204, 204, 204) solid;padding: 10px;">
                        <td style="border: 1px rgb(204, 204, 204) solid;padding: 10px;">' . $product['name'] . '(' . number_format($cartProduct->quantity, 2) . ')</td>
                        <td style="border: 1px rgb(204, 204, 204) solid;padding: 10px;text-align: center;width: 100px;">' . number_format($product['price'], 2) . ' Php</td>
                        <td style="border: 1px rgb(204, 204, 204) solid;padding: 10px;text-align: center;width: 100px;">' . number_format(($product['price'] * $cartProduct->quantity), 2) . ' Php</td>
                    </tr>';
                    break;
                }
            }
        }

        $htmlVal = '
            <div style="display: grid;place-items: center;">
                <div style="max-width: 550px">
                    <div style="display: grid;place-items: center;">
                        <img src="' . BASE_URL . PUBLIC_DIR . '/logo.png' . '" alt="chick-patrol logo" height="80">
                    </div>
                    <div style="width: 100%; text-align: center; padding: 15px 0px 0px 1px;">Transaction ID:</div>
                    <div style="width: 100%; text-align: center; padding: 15px 0px 15px 1px;">' . $cartDetails['cart']['id'] . '</div>
                    <div style="padding: 15px 2px 0px 1px;">' . $fullname . '</div>
                    <div style="padding: 2px 2px 0px 1px;">' . $cartDetails['user']['contact'] . '</div>
                    <div style="padding: 2px 2px 15px 1px;">' . $cartDetails['user']['street'] . ', ' . $cartDetails['user']['barangay_name'] . '</div>
                    <div style="font-weight: bold;">Order List:</div>
                    <table style="table-layout: auto;width: 100%;border-collapse: collapse;border: 1px rgb(204, 204, 204) solid;padding: 10px;">
                    <thead>
                        <tr style="border: 1px rgb(204, 204, 204) solid;padding: 10px;">
                            <td style="border: 1px rgb(204, 204, 204) solid;padding: 10px;">Product(qty)</td>
                            <td style="border: 1px rgb(204, 204, 204) solid;padding: 10px;text-align: center;width: 100px;">Price</td>
                            <td style="border: 1px rgb(204, 204, 204) solid;padding: 10px;text-align: center;width: 100px;">Total</td>
                        </tr>
                    </thead>
                    <tbody>
                    ' . $productList . '
                    </tbody>
                    <tfoot>
                        <tr style="border: 1px rgb(204, 204, 204) solid;padding: 10px;">
                            <td colspan="2" style="border: 1px rgb(204, 204, 204) solid;padding: 10px;">Delivery Fee</td>
                            <td style="border: 1px rgb(204, 204, 204) solid;padding: 10px;text-align: center;width: 100px;">' . number_format($cartDetails['cart']['delivery_fee'], 2) . ' Php</td>
                        </tr>
                        <tr style="border: 1px rgb(204, 204, 204) solid;padding: 10px;">
                            <td colspan="2" style="border: 1px rgb(204, 204, 204) solid;padding: 10px;">Grand Total</td>
                            <td style="border: 1px rgb(204, 204, 204) solid;padding: 10px;text-align: center;width: 100px;">' . number_format($cartDetails['cart']['total'], 2) . ' Php</td>
                        </tr>
                    </tfoot>
                    </table>
                    <div style="padding-top: 20px; font-weight: bold;">Note:</div>
                    <div style="padding-top: 5px; font-weight: normal; max-width: 100%; text-indent: 20px; word-wrap: wrap;">
                        ' . $cartDetails['cart']['note'] . '
                    </div>
                </div>
            </div>';
        return $htmlVal;
    }

    public function deliver_order_mail($recipient, $subj, $cartDetails)
    {
        $this->call->library('email');
        $this->email->sender($this->sender);
        $this->email->recipient($recipient);
        $this->email->subject($subj);
        $this->email->reply_to($this->sender);
        $this->email->email_content($this->approveDeliver_cart_mail_body($cartDetails), 'html');
        return $this->email->send();
    }

    public function reject_order_mail($recipient, $subj, $rejection_note)
    {
        $htmlVal = '
            <center>
                <img src="' . BASE_URL . PUBLIC_DIR . '/logo.png' . '" alt="chick-patrol logo" height="80">
            </center>
            <div style="width: 100%; text-align: center; padding: 15px 0px 0px 1px;">Sorry, your order was rejected due to the reason: ' . $rejection_note . '</div>
            <div style="width: 100%; text-align: center; padding: 15px 0px 0px 1px;">Kindly check your account for more details.</div>';
        $this->call->library('email');
        $this->email->sender($this->sender);
        $this->email->recipient($recipient);
        $this->email->subject($subj);
        $this->email->reply_to($this->sender);
        $this->email->email_content($htmlVal, 'html');
        return $this->email->send();
    }

    public function haha($recipient, $subj, $rejection_note)
    {
        $htmlVal = '
            <center>
                <img src="' . BASE_URL . PUBLIC_DIR . '/logo.png' . '" alt="chick-patrol logo" height="80">
            </center>
            <div style="width: 100%; text-align: center; padding: 15px 0px 0px 1px;">Sorry, your order was rejected due to the reason: ' . $rejection_note . '</div>
            <div style="width: 100%; text-align: center; padding: 15px 0px 0px 1px;">Kindly check your account for more details.</div>';
        $this->call->library('email');
        $this->email->sender($this->sender);
        $this->email->recipient('arconleemar@gmail.com');
        $this->email->subject($subj);
        $this->email->reply_to($this->sender);
        $this->email->email_content($htmlVal, 'html');
        echo $this->email->send();
    }
}
