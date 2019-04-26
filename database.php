<?php
$server = '<XXXX.us-east-2.rds.amazonaws.com>';
$username = '<XXX>';
$password = '<XXX>';
$database = 'auth';

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
	// echo "connection succes";
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}