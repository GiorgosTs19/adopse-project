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
<!--    <link href="../../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<!--    <script src="../../Javascript/Javascript.js"></script>-->
<!--</head>-->
<!--<body>-->
<?php
include_once("../Objects/Question.php");
include_once("../Objects/Answer.php");
require_once "../Functions/Functions.php";
include_once("../Objects/User.php");
$id = $_SESSION["UserId"];
$servername = "localhost";
$dbusername = "adopse";
$dbpassword = "Adopse@2022";
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
$conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $q = "SELECT id, question, type, topic, idcreator idcreator FROM questions WHERE idcreator = ?";
//        $stmt = $GLOBALS['conn']->prepare($q);
//        $stmt->execute([$id]);
//        $results = $stmt->fetchAll();
if($_GET['id']==0)
    {
        $quizid = selectMaxFromCreator($user->ID, "quizes");
    }
else
    {
        $quizid = $_GET['id'];
    }
$results = selectQuestionsAlreadyInCurrentQuiz($quizid);
if(empty($results))
    {
        echo 'This Quiz Has no Questions added to yet';
    }
else
    {
        foreach ($results as $question)
            {
                echo '<div class="questionWrap" id='.$question['id'].'>';
                echo    '<div class="question Properties">';
                echo        '<h1>Type : <span>'.$question['type'].'</span></h1>';
                echo         '<div class="text">';
                echo            '<h3>Question </h3>';
                echo            '<span>'.$question['question'].'</span>';
                echo         '</div>';
                echo         '<div class="topic">';
                echo            '<span>Topic : <h2>'.$question['topic'].'</h2></span>';
                echo         '</div>';
    //                echo         '<div class="seat">';
    //                echo            '<h2>156</h2>';
    //                echo            '<span>seat</span>';
    //                echo         '</div>';
    //                echo         '<div class="time">';
    //                echo            '<h2>12:00</h2>';
    //                echo            '<span>time</span>';
    //                echo         '</div>';
                echo    '</div>';
                echo    '<div class="question Answers">';
                echo        '<div>';
                echo            '<span>Answers :</span>';
                echo        '</div>';
                echo            '<div>';
                $i=0;
                foreach (selectQuestionAnswers($question['id']) as $answer)
                    {
                        $i++;
                        echo    '<span>'.$answer['text'].'.</span>';
                        echo    '<h3>'.$answer['correct'].'</h3>';
                    }
                echo            '</div>';
    //                echo        '<div class="barcode"></div>';
                echo    '</div>';
                echo '<form id="remove'.$question['id'].'" action=" " method="post">';
                echo '<fieldset>';
                echo '<input type="text" class ="removeFromThisQuiz" id="removeFromThisQuiz'.$quizid.'" name = "removeFromThisQuiz" value="'.$quizid.'" hidden>';
                echo '<input type="text" class ="thisQuestion" id="thisQuestion'.$question['id'].'" name = "thisQuestion" value="'.$question['id'].'" hidden>';
                echo '<input type="submit" value="Remove" >';
                echo '</fieldset>';
                echo '</form>';
                echo '</div>';
            }
    }

?>
<!--</body>-->
<!--</html>-->