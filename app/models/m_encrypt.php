<?php
// $encrypted = openssl_encrypt('Secret message to be encrypted', $this->cipher, $this->key, 0, $iv);
// echo '<br>' . openssl_decrypt($encrypted, $this->cipher, $this->key, 0, $iv);
class m_encrypt extends Model
{
  private  $key = 'fwl40t39jeogih2';
   var $cipher = 'aes-256-cbc';
   var $iv = '';

   // function modify_id_with_offset($cipher, $key, $iv, $item)
   // {
   //    $ciphertext = openssl_encrypt($item['id'], $cipher, $key, 0, $iv);
   //    $encrypted_id = base64_encode($iv . $ciphertext);
   //    $item['id'] = preg_replace('/[^a-zA-Z0-9]/', '', $encrypted_id);
   //    return $item;
   // }

   // public function encrypt($data)
   // {
   //    if (is_array($data)) {
   //       $data = array_map(fn ($item) => $this->modify_id_with_offset($this->cipher, $this->key, $this->iv, $item), $data);
   //    } else {
   //       $ciphertext = openssl_encrypt($data, $this->cipher, $this->key, 0, $this->iv);
   //       $data = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode($this->iv . $ciphertext));
   //    }
   //    return $data;
   // }

   // function perf_decryption($cipher, $key, $item)
   // {
   //    $ciphertext = base64_decode($item['id']);
   //    $iv = substr($ciphertext, 0, 16);
   //    $ciphertext = substr($ciphertext, 16);
   //    $decrypted_id = openssl_decrypt($ciphertext, $cipher, $key, 0, $iv);
   //    $item['id'] = $decrypted_id;
   //    return $item;
   // }

   // public function decrypt($data)
   // {
   //    if (is_array($data)) {
   //       $data = array_map(function ($item) {
   //          return $this->perf_decryption($this->cipher, $this->key, $item);
   //       }, $data);
   //    } else {
   //       $ciphertext = base64_decode($data);
   //       $iv = substr($ciphertext, 0, 16);
   //       $ciphertext = substr($ciphertext, 16);
   //       $data = openssl_decrypt($ciphertext, $this->cipher, $this->key, 0, $iv);
   //    }

   //    return $data;
   // }


   // ORIGINAL CODE!
   function generate_iv()
   {
      $length = 16;
      $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $iv = '';
      for ($i = 0; $i < $length; $i++) {
         $iv .= $characters[rand(0, $charactersLength - 1)];
      }
      return $iv;
   }

   function modify_id_with_offset($cipher, $key, $iv, $item)
   {
      $ciphertext = openssl_encrypt($item['id'], $cipher, $key, 0, $iv);
      $encrypted_id = base64_encode($iv . $ciphertext);
      $item['id'] = preg_replace('/[^a-zA-Z0-9]/', '', $encrypted_id);
      return $item;
   }

   public function encrypt($data)
   {
      $this->iv = $this->generate_iv();
      if (is_array($data)) {
         $data = array_map(fn ($item) => $this->modify_id_with_offset($this->cipher, $this->key, $this->iv, $item), $data);
      } else {
         $iv = $this->iv;
         $ciphertext = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
         $data = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode($iv . $ciphertext));
      }
      return $data;
   }

   function perf_decryption($cipher, $key, $item)
   {
      $ciphertext = base64_decode($item['id']);
      $iv = substr($ciphertext, 0, 16);
      $ciphertext = substr($ciphertext, 16);
      $decrypted_id = openssl_decrypt($ciphertext, $cipher, $key, 0, $iv);
      $item['id'] = $decrypted_id;
      return $item;
   }


   public function decrypt($data)
   {
      if (is_array($data)) {
         $data = array_map(function ($item) {
            return $this->perf_decryption($this->cipher, $this->key, $item);
         }, $data);
      } else {
         $ciphertext = base64_decode($data);
         $iv = substr($ciphertext, 0, 16);
         $ciphertext = substr($ciphertext, 16);
         $data = openssl_decrypt($ciphertext, $this->cipher, $this->key, 0, $iv);
      }

      return $data;
   }
}
