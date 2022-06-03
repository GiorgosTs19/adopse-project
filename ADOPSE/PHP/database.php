<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "adopse";
$conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$GLOBALS['conn']  = $conn;

function getConnection()
    {
        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "adopse";
        $conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $GLOBALS['conn']  = $conn;
        return $conn;
    }
?>



