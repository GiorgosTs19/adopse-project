<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
        <link href="../../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="../../Css/Answers.scss" rel="stylesheet" type="text/css" media="screen"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../../Javascript/Javascript.js"></script>
</head>
<body>
    <?php
        include_once("../Objects/Question.php");
        include_once("../Objects/Answer.php");
        include_once("../Objects/User.php");
        require_once "../Functions.php";
        $id = $_SESSION["UserId"];
        $servername = "localhost";
        $dbusername = "adopse";
        $dbpassword = "Adopse@2022";
        //User Initialization
        $user = new User();
        $user->setID($_SESSION["UserId"]);
        $user->setName($_SESSION["UserN"]);
        $user->setLastName($_SESSION["UserLN"]);
        $user->setEmail($_SESSION["UserE"]);
        $conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $q = "INSERT INTO quizquestions (quizid, questionid) VALUES (?,?);";
        $stmt = $conn->prepare($q);
        $stmt->execute([$_POST["addToThisQuiz"], $_POST["thisQuestion"]]);
        $conn = null;
    ?>
</body>



