<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
include_once("../Objects/Question.php");
include_once("../Objects/Answer.php");
include_once("../Objects/User.php");
require_once "../Functions/Functions.php";
$id = $_SESSION["UserId"];
include_once("../DatabaseConnection.php");
//User Initialization
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
$conn = DatabaseConnection::connect();
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

if(isset($_GET['toRemoveID']))
    {
        $removeFromQuizes = "DELETE FROM quizes WHERE id=?;";
        $stmt1 = $conn->prepare($removeFromQuizes);
        $stmt1->execute([$_GET['toRemoveID']]);


        $removeFromQuizAttributes = "DELETE FROM quizattributes WHERE quizid=?;";
        $stmt2 = $conn->prepare($removeFromQuizAttributes);
        $stmt2->execute([$_GET['toRemoveID']]);


        $removeFromFavorites = "DELETE FROM favorites WHERE quizid=?;";
        $stmt3 = $conn->prepare($removeFromFavorites);
        $stmt3->execute([$_GET['toRemoveID']]);

        $removeFromAttempts = "DELETE FROM attempts WHERE quizid=?;";
        $stmt4 = $conn->prepare($removeFromAttempts);
        $stmt4->execute([$_GET['toRemoveID']]);

        $removeFromAttemptAnswers = "DELETE FROM attemptanswers WHERE quizid=?;";
        $stmt5 = $conn->prepare($removeFromAttemptAnswers);
        $stmt5->execute([$_GET['toRemoveID']]);

        $removeFromQuizQuestions = "DELETE FROM quizquestions WHERE quizid=?;";
        $stmt6 = $conn->prepare($removeFromQuizQuestions);
        $stmt6->execute([$_GET['toRemoveID']]);
    }

$conn = null;
?>
</body>