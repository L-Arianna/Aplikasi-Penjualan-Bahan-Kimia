<?php
$host = 'localhost';
$username = 'u100622648_05';
$password = 'Admin123!';
$database = 'u100622648_05';

$pdo = new PDO('mysql:host=' . $host . ';dbname=' . $database, $username, $password);

// error_reporting(E_ALL ^ E_DEPRECATED);
// $servername = "localhost";
// $username = "u100622648_05";
// $password = "Admin123!";
// $dbname = "u100622648_05";

// $koneksi = mysqli_connect('localhost', 'root', '');
// $db = mysqli_select_db($koneksi, $dbname);

// // Create connection
// global $conn;
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// // Check connection
// if (!$conn) {
// 	die("Connection failed: " . mysqli_connect_error());
// }
