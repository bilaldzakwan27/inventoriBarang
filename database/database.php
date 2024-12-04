<?php
$host = 'localhost'; 
$db = 'inventory_app';
$user = 'root'; 
$pass = '';

function getConnection() {
    global $host, $db, $user, $pass;
    return new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
}
?>
