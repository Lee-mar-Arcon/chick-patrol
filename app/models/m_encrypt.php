<?php
// $encrypted = openssl_encrypt('Secret message to be encrypted', $this->cipher, $this->key, 0, $iv);
// echo '<br>' . openssl_decrypt($encrypted, $this->cipher, $this->key, 0, $iv);
class m_encrypt extends Model
{
   var $key = 'fwl40t39jeogih2';
   var $cipher = 'aes-256-cbc';

   function generate_iv()
   {
      $length = 16;
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $iv = '';
      for ($i = 0; $i < $length; $i++) {
         $iv .= $characters[rand(0, $charactersLength - 1)];
      }
      return $iv;
   }


   public function encrypt($data)
   {

      if (is_array($data)) {
         function modify_id_with_offset($cipher, $key, $iv, $item)
         {
            $ciphertext = openssl_encrypt($item['id'], $cipher, $key, 0, $iv);
            $item['id'] = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode($iv . $ciphertext));
            return $item;
         }
         $data = array_map(fn ($item) => modify_id_with_offset($this->cipher, $this->key, $this->generate_iv(), $item), $data);
      } else {
         $iv = $this->generate_iv();
         $ciphertext = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
         $data = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode($iv . $ciphertext));
      }
      return $data;
   }


   public function decrypt($data)
   {
      if (is_array($data)) {
         function perf_decryption($cipher, $key, $item)
         {
            $ciphertext = base64_decode($item['id']);
            $iv = substr($ciphertext, 0, 16);
            $decrypted_id = openssl_decrypt(substr($ciphertext, 16), $cipher, $key, 0, $iv);
            $item['id'] = $decrypted_id;
            return $item;
         }
         $data = array_map(fn ($item) => perf_decryption($this->cipher, $this->key, $item), $data);
      } else {
         $ciphertext = base64_decode($data);
         $iv = substr($ciphertext, 0, 16);
         $data = openssl_decrypt(substr($ciphertext, 16), $this->cipher, $this->key, 0, $iv);
      }

      return $data;
   }
}
