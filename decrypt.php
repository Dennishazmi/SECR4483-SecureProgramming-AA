<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv=Dotenv::createImmutable(__DIR__);

$dotenv->load();

$key=base64_decode($_ENV['APP_KEY']);

$data=base64_decode($_POST['payload']);

$iv=substr($data,0,12);

$tag=substr($data,12,16);

$ciphertext=substr($data,28);

$plaintext=openssl_decrypt(

$ciphertext,

'aes-256-gcm',

$key,

OPENSSL_RAW_DATA,

$iv,

$tag

);

if($plaintext===false){

throw new Exception("Authentication Failed");

}

echo $plaintext;

?>
