<?php

define("SITE", "https://kimbao.goodcity.com.ru/");
define("SMS", "http://172.20.0.11:8088");
define("TOKEN", "root");
define("CRM", "https://crmclient.goodcity.com.ru/api");

$host = 'localhost';
$db   = 'personalCabinetKB';
$user = 'personalCabinet';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $opt);


?>