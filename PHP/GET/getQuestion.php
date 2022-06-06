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

if (isset($_GET['quid']))
    {
        $quid=(int)$_GET['quid'];

        $q1 = "SELECT * FROM questions 
        WHERE id= ?";

        $stmt1 = $conn->prepare($q1);
        $stmt1->execute([$quid]);
        $question = $stmt1->fetch(PDO::FETCH_ASSOC);

        $PrevNext = (getPreviousAndNextQuestionIDs($_SESSION['cqid'], $quid));
        $PreviousQuestionID = $PrevNext[0];
        $NextQuestionID = $PrevNext[2];

        $q2 = "select * from answers where parent= ?";

        $stmt2 = $conn->prepare($q2);
        $stmt2->execute([$quid]);
        $answers = $stmt2->fetchAll();

        $currentattemptid = getLastAttemptonQuizID($_SESSION['cqid'],$user->ID);





        echo '<div class="questionarea" id="questionarea">';
        echo    '<form id="submitAnswer">';
        echo        '<fieldset>';
        echo        ' <div class="questiontitle">';
        echo        '<input type="text" id="currentviewingquestion" name="currentQuestionID"  value="'.$question["id"].'" hidden>';
        echo            '<h1 id="questiontitle">'.$question["question"].'</h1>';
        echo '<br>';
        echo '<br>';
        foreach ($answers as $answer)
            {
                returnAnswerType($question['id'], $question['type'], $answer['text'],
                    $answer['id'], $currentattemptid['attemptid'], $user->ID, $_SESSION['cqid']);
                echo '<br>';
                echo '<br>';
                echo '<br>';
            }
        echo '<input type="reset" value="Reset" id="clearmychoices">';
        echo            '<div class="qbtn-group">';
        echo            '<input type="text" id="buttonPressed" hidden>';

        if(!is_null($PreviousQuestionID) )
            {
                if(ForwardOnlyCondition($_SESSION['cqid'])==1)
                    {
                        return "";
                    }
                else
                    {
                        echo    '<input type="text" id="previousQuestion"  value="'.$PreviousQuestionID.'" hidden>';
                        echo    '<input type="submit" name="prevquestion" onclick="setSelection(0)" value="Previous">';
                    }
            }
        if(!is_null($NextQuestionID))
            {
                echo    '<input type="text" id="nextQuestion"  value="'.$NextQuestionID.'" hidden>';
                echo    '<input type="submit" name="nextquestion" onclick="setSelection(1)" value="Next">';
            }
        else
            {
                echo    '<input type="submit" name="nextquestion" onclick="" value="Submit">';
            }
        echo            '</div>';
        echo       '</fieldset>';
        echo    '</form>';
        echo        '</div>';
        echo    '</div>';
//        if(!is_null($PreviousQuestionID))
//            {
//                echo    '<input type="text" id="previousQuestion"  value="'.$PreviousQuestionID.'" hidden>';
//            }
//        if(!is_null($NextQuestionID))
//            {
//                echo    '<input type="text" id="nextQuestion"  value="'.$NextQuestionID.'" hidden>';
//            }
        echo    '</div>';
    }
?>