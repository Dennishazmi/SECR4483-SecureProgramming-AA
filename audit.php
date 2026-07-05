<?php

require_once 'db_config.php';

if($_SERVER['REQUEST_METHOD']=="POST"){

$username = trim($_POST['username'] ?? '');

$inputKey = trim($_POST['auth_key'] ?? '');

if(mb_strlen($inputKey,'UTF-8')>256){

die("Invalid input length.");

}

$stmt=$conn->prepare("
SELECT auth_key_hash
FROM staff_credentials
WHERE username=:username
");

$stmt->execute([
':username'=>$username
]);

$user=$stmt->fetch();

if(!$user){

die("Invalid credentials.");

}

if(password_verify($inputKey,$user['auth_key_hash'])){

echo "Access Granted";

}else{

echo "Access Denied";

}

}
?>
