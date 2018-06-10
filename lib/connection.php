<?php 
session_start();
$servername = "localhost";
$username = "steg";
$password = "137946";
$dbname = "steg";
$conn = new mysqli($servername, $username, $password, $dbname) or die("Fail");
?>