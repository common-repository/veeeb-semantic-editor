<?php

/*----------------------------------------
|
| This class has two methods to en- and decrypt
| a string. It uses TripleDES (ECB with PKCS5 Padding)
|
|-----------------------------------------*/

class TokenHelper
{
	/*
	 * Enrypts the string with the given key and
	 * return the url encoded result.
	 *
	 * @param input The string to be encrypted.
	 * @param ky The key that is used to encrypt the string
	 * 
	 * @return The url encoded and encrypted string
	 */
	public function encrypt($input,$ky)
	{
	   $key = $ky;
	   $size = mcrypt_get_block_size(MCRYPT_TRIPLEDES, 'ecb');
	   $input = $this->pkcs5_pad($input, $size);
	   $td = mcrypt_module_open(MCRYPT_TRIPLEDES, '', 'ecb', '');
	   $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	   mcrypt_generic_init($td, $key, $iv);
	   $data = mcrypt_generic($td, $input);
	   mcrypt_generic_deinit($td);
	   mcrypt_module_close($td);
	   $data = base64_encode($data);
	   $data = urlencode($data); //push it out so i can check it works
	   return $data;
	}
	 
	/*
	 * Decrypts the string with the given key and
	 * return result.
	 *
	 * @param input The url encoded string to be decrypted.
	 * @param ky The key that is used to decrypt the string
	 * 
	 * @return The decrypted string
	 */ 
	public function decrypt($crypt,$ky,$urlDecode)
	{
		if($urlDecode == true)
			$crypt = urldecode($crypt);
			
		$crypt = base64_decode($crypt);
		$key = $ky;
		$td = mcrypt_module_open (MCRYPT_TRIPLEDES, '', 'ecb', '');
		$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$decrypted_data = mdecrypt_generic ($td, $crypt);
		mcrypt_generic_deinit ($td);
		mcrypt_module_close ($td);
		$decrypted_data = $this->pkcs5_unpad($decrypted_data);
		$decrypted_data = rtrim($decrypted_data);
		return $decrypted_data;
	}
	 
	private function pkcs5_pad($text, $blocksize)
	{
	   $pad = $blocksize - (strlen($text) % $blocksize);
	   return $text . str_repeat(chr($pad), $pad);
	}
	 
	private function pkcs5_unpad($text)
	{
	   $pad = ord($text{strlen($text)-1});
	   if ($pad > strlen($text)) return false;
	   return substr($text, 0, -1 * $pad);
	}
 
}
?>