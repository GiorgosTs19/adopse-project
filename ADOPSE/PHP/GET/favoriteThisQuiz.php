<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<!--    <link href="../../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>-->
<!--    <link href="../../Css/Answers.scss" rel="stylesheet" type="text/css" media="screen"/>-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<!--    <script src="../../Javascript/Javascript.js"></script>-->
</head>
<body>
<?php
include_once("../Objects/Question.php");
include_once("../Objects/Answer.php");
include_once("../Objects/User.php");
require_once "../Functions/Functions.php";
$id = $_SESSION["UserId"];
require_once "../database.php";
//User Initialization
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
$conn = getConnection();
$q = "INSERT INTO favorites (quizid, userid) VALUES (?,?);";
$stmt = $conn->prepare($q);
$stmt->execute([$_GET['qid'], $user->ID]);
$conn = null;

echo '<input type="image" id="unFavThisQuiz'.$_GET['qid'].'" class="editbutton" src="../images/favorite_filled.png" 
                        onclick="unFavThisQuiz('.$_GET['qid'].')" style="width: 40px;height: 40px;">';
?>
</body>