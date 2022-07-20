<?php 

$host = "localhost";
$port = 3306;
$dbname = "ScandiwebTest";
$user = "root";
$pwd = "";

$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pwd);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);