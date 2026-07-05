<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv=Dotenv::createImmutable(__DIR__);

$dotenv->load();

$key=base64_decode($_ENV['APP_KEY']);

if($_SERVER['REQUEST_METHOD']=="POST"){

$payload=$_POST['payload'] ?? '';

$iv=random_bytes(12);

$ciphertext=openssl_encrypt(

$payload,

'aes-256-gcm',

$key,

OPENSSL_RAW_DATA,

$iv,

$tag

);

$result=base64_encode(

$iv.
$tag.
$ciphertext

);

echo json_encode([

'status'=>'vaulted',

'data'=>$result

]);

}
?>
