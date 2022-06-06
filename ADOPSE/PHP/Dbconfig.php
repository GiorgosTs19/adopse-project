<?php
//$servername = "localhost";
//$dbusername = "adopse";
//$dbpassword = "Adopse@2022";
//$_SESSION["servername"] = "localhost";
//$_SESSION["dbusername"] = "adopse";
//$_SESSION["dbpassword"] = "Adopse@2022";
//$conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
//// set the PDO error mode to exception
//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$GLOBALS['conn']  = $conn;
//
//
//function getConnection()
//    {
//        $servername = "localhost";
//        $dbusername = "adopse";
//        $dbpassword = "Adopse@2022";
//        $_SESSION["servername"] = "localhost";
//        $_SESSION["dbusername"] = "adopse";
//        $_SESSION["dbpassword"] = "Adopse@2022";
//        $conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
//// set the PDO error mode to exception
//    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $GLOBALS['conn']  = $conn;
//        return $conn;
//    }
//?>

<?php
class Dbconfig
    {
        protected $serverName;
        protected $userName;
        protected $passCode;
        protected $dbName;

        function Dbconfig()
            {
                $this -> serverName = 'localhost';
                $this -> userName = 'adopse';
                $this -> passCode = 'Adopse@2022';
                $this -> dbName = 'adopse';
            }
    }
?>

