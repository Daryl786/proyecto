<?php
$password = '1234'; // cambia por la contraseña deseada
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash . PHP_EOL;

