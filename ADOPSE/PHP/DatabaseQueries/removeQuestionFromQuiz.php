<?php
session_start();
if(!$_SESSION["LoggedIn"])
{
    header("Location: http://localhost/ADOPSE/PHP/Login.php");
}
?>

<?php
include_once("../Objects/Question.php");
include_once("../Objects/Answer.php");
include_once("../Objects/User.php");
require_once "../Functions/Functions.php";
require_once "../database.php";
$id = $_SESSION["UserId"];
//User Initialization
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
$conn = getConnection();
$q = "DELETE FROM quizquestions WHERE quizid=? AND questionid=?;";
$stmt = $conn->prepare($q);
$stmt->execute([$_POST["removeFromThisQuiz"], $_POST["thisQuestion"]]);
$conn = null;
?>
<!--</body>-->