<?php
session_start();
if(!$_SESSION["LoggedIn"])
{
    header("Location: http://localhost/ADOPSE/PHP/Login.php");
}
?>
<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--<!--    <link href="../../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>-->-->
<!--<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->-->
<!--<!--    <script src="../../Javascript/Javascript.js"></script>-->-->
<!--</head>-->
<!--<body>-->
<?php
include_once("../Objects/Question.php");
include_once("../Objects/Answer.php");
include_once("../Objects/User.php");
require_once "../Functions/Functions.php";
include_once("../DatabaseConnection.php");
$id = $_SESSION["UserId"];
//User Initialization
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
$conn = DatabaseConnection::connect();
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$q = "DELETE FROM quizquestions WHERE quizid=? AND questionid=?;";
$stmt = $conn->prepare($q);
$stmt->execute([$_POST["removeFromThisQuiz"], $_POST["thisQuestion"]]);
$conn = null;
?>
<!--</body>-->