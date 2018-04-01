<?php

$servername = 'localhost';
$dbusername   = 'root';
$dbpassword   = 'b4b8b7536bc203b176b2f30ed15eee1fe3f69cb52728c3a2';
$dbname     = 'alicebeta';

$link = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

$db = new mysqli($servername, $dbusername, $dbpassword, $dbname);
