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
require_once "../Functions/QuizFunctions.php";
include_once("../Objects/User.php");
$id = $_SESSION["UserId"];
include_once("../DatabaseConnection.php");
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
$conn = DatabaseConnection::connect();
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
$results = selectQuestionsAlreadyInCurrentQuiz($user->ID,$quizid);
if(empty($results))
    {
        echo 'You have not added any questions to this quiz yet.';
    }
else
    {
        foreach ($results as $question)
            {
                echo '<div class="questionWrap" id='.$question['id'].'>';
                echo    '<div class="question Properties">';
                echo        '<h1>'.$question['question'].'</h1>';
                echo            '<span>'.getQuestionType($question['type']).'</span>';
                echo         '<div class="topic">';
                echo            '<br>';
                echo            '<span>Topic : '.$question['topic'].'</span>';
                echo         '</div>';
                echo         '<div class="text">';
                echo            '<br>';
                echo         '</div>';
                echo    '</div>';
                echo    '<div class="question Answers">';
                echo        '<div>';
                echo            '<br>';
                echo            '<span>Answers :</span>';
                echo        '</div>';
                echo            '<div>';
                $i=0;

                foreach (selectQuestionAnswers($question['id']) as $answer)
                {
                    $i++;
                    echo    '<br>';
                    echo    '<p>'.$answer['text'].'. : <span>'.$answer['correct'].'</span></p>';
                    echo    '';
                }
                echo            '</div>';
                echo    '</div>';
                if($_GET['id']>0 || $_GET['id']==0)
                    {
                        echo '<form id="remove'.$question['id'].'" action=" " method="post">';
                        echo '<fieldset>';
                        echo '<input type="text" class ="removeFromThisQuiz" id="removeFromThisQuiz'.$quizid.'" name = "removeFromThisQuiz" value="'.$quizid.'" hidden>';
                        echo '<input type="text" class ="thisQuestion" id="thisQuestion'.$question['id'].'" name = "thisQuestion" value="'.$question['id'].'" hidden>';
                        echo '<input type="submit" value="Remove" >';
                        echo '</fieldset>';
                        echo '</form>';
                    }
                echo '</div>';
            }
    }

?>
<!--</body>-->
<!--</html>-->