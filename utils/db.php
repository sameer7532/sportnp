<?php
// new mysqli connection to the database

$host = 'localhost';
$user = 'root';
$pass = '1234';
$db = 'sportsnp';

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die('Database error: ' . $conn->connect_error);
}