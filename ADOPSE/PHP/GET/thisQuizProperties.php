<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link href="../../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../Javascript/Javascript.js"></script>
    <script src="../../Javascript/indexJavascript.js"></script>
</head>
<body>
<?php
include_once("../Objects/Question.php");
include_once("../Objects/Answer.php");
require_once "../Functions/Functions.php";
require_once "../Functions/QuizFunctions.php";
include_once("../Objects/User.php");
$id = $_SESSION["UserId"];
require_once "../database.php";
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
$conn = getConnection();
$q = "SELECT * 
        FROM quizes AS t1 
        JOIN quizattributes t2 
        ON t1.id = t2.quizid 
        WHERE t1.id=?;";

$stmt = $conn->prepare($q);
$stmt->execute([$_GET['qid']]);
$quiz = $stmt->fetch();

        echo '<div class="single_stuff wow fadeInDown">';
        echo    '<div class="imagewrap">';
        echo         '<div class="single_stuff_article">';
        echo            '<div class="single_sarticle_inner">';
        echo                '<span class="stuff_category" >Created '.time_elapsed_string($quiz['datetimecreated'],true).'</span>';
        echo                '<br><span class="stuff_category" >'.PasswordOnly($quiz['passonly']).'</span>';
        echo                '<div class="stuff_article_inner">' ;
        echo                       '<span class="stuff_date"><strong>'. $quiz['topic'] .'</strong></span>';
        echo                   '<h2>'.$quiz['title'].'</h2>';
        echo                   '<p>';
        echo                        $quiz['sdesc'];
        echo                        '<br><br> <span>'.Timed($quiz['timed'],$quiz['timelimit']).'</span>';
        echo                        '<br> <span>'.ForwardOnly($quiz['forwardonly']).'</span>';
        echo                        '<br> <span>'.MultipleAttempts($quiz['multipleattempts'],$quiz['attempts']).'</span>';
        echo                        '<br> <span>'.NegativeGrading($quiz['negativegrading']).'</span>';
        echo                    '</p>';
        echo                '</div>';
        echo           '</div>';
        echo         '</div>';
        echo     '</div>';
        echo     '<div>';
        echo     '</div>';
        echo  '</div>';
?>
</body>
</html>
