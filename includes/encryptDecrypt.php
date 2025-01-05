<?php

define('KEY', 'Lk5Uz3slx3BrAghS1aaW5AYgWZRV0tIX5eI0yPchFz4=');

function encryptData($data)
{
  $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
  $iv = openssl_random_pseudo_bytes($ivlen);
  $ciphertext_raw = openssl_encrypt($data, $cipher, KEY, $options = OPENSSL_RAW_DATA, $iv);
  $hmac = hash_hmac('sha256', $ciphertext_raw, KEY, $as_binary = true);
  $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);

  return $ciphertext;
}

function decryptData($data)
{
  $c = base64_decode($data);
  $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
  $iv = substr($c, 0, $ivlen);
  $hmac = substr($c, $ivlen, $sha2len = 32);
  $ciphertext_raw = substr($c, $ivlen + $sha2len);

  // Calculate the HMAC again to verify integrity
  $calcmac = hash_hmac('sha256', $ciphertext_raw, KEY, $as_binary = true);

  // Compare HMAC values in a time-safe manner
  if (!hash_equals($hmac, $calcmac)) {
    return false; // HMAC verification failed
  }

  $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, KEY, $options = OPENSSL_RAW_DATA, $iv);
  return $original_plaintext;
}
