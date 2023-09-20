<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json;");

class Paypal_api extends Controller
{
   function generate_token()
   {
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v2/checkout/orders");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);

      $headers = array(
         'Content-Type: application/json',
         'PayPal-Request-Id: 7b92603e-77ed-4896-8e78-5dea2050476a',
         'Authorization: Bearer 6V7rbVwmlM1gFZKW_8QtzWXqpcwQ6T5vhEGYNJDAAdn3paCgRpdeMdVYmWzgbKSsECednupJ3Zx5Xd-g'
      );

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $data = '{
        "intent": "CAPTURE",
        "purchase_units": [
          {
            "reference_id": "d9f80740-38f0-11e8-b467-0ed5f89f718b",
            "amount": {
              "currency_code": "USD",
              "value": "100.00"
            }
          }
        ],
        "payment_source": {
          "paypal": {
            "experience_context": {
              "payment_method_preference": "IMMEDIATE_PAYMENT_REQUIRED",
              "brand_name": "EXAMPLE INC",
              "locale": "en-US",
              "landing_page": "LOGIN",
              "shipping_preference": "SET_PROVIDED_ADDRESS",
              "user_action": "PAY_NOW",
              "return_url": "https://example.com/returnUrl",
              "cancel_url": "https://example.com/cancelUrl"
            }
          }
        }
      }';

      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

      $response = curl_exec($ch);

      if (curl_errno($ch)) {
         echo 'Error:' . curl_error($ch);
      }

      curl_close($ch);

      echo $response;
   }
}
