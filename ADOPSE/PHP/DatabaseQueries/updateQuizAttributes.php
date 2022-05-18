<?php
session_start();
?>
<?php
require_once "Functions.php";
include_once("Objects/User.php");
$servername = "localhost";
$dbusername = "adopse";
$dbpassword = "Adopse@2022";
$conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//User Initialization
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
//Form Variables
$title = $topic = $password = $attempts = $neggrade = $shortdesc = $timelimit = "";
$quizid = null;
//Errors
$time0error = $attempt1error  = $neggradeerror = $passemptyerror = "";
//Booleans for Quiz Attributes
$mattempts = $neggradeon = $shuffled = $fwdonly = $passonly = $timed = false;
//Booleans for integrity checks
$shortdescok = $titleok = $topicok = $attemptsok =
$passok = $timelimitok  = $fwdonlyok = $neggradeok = false;
//Tips for specific fields
$attemptstip = "Set to 0 for no limit.";
$passwordtip = "The password is Case-Sensitive.";
$neggradetip = "Tip : The Negative Grading will be equal to "
    . "(Grade of a correct answer / your input )."
    . " Cannot be set to 0.";


if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //Quiz Title

    }
?>


