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
require_once "../database.php";
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
$conn = getConnection();

    finishLastAttempt($_SESSION['cqid'],$user->ID);
    $lastAttempt = getLastAttemptOnQuiz($_SESSION['cqid'],$user->ID);
    $quiz = getQuizInfo($_SESSION['cqid']);
            echo    '<h1>Recent Attempts On Quiz</h1>';
            echo    '<table class="table table-bordered">';
            echo    '<thead>';
            echo    '<tr>';
            echo    '<th><h2>Quiz</h2></th>';
            echo    '<th><h2>Started</h2></th>';
            echo    '<th><h2>Ended</h2></th>';
            echo    '<th><h2>Grade</h2></th>';
            echo    '</tr>';
            echo    '</thead>';
            echo    '<tbody>';
            echo    '<tr>';
            foreach (getLastFiveAttemptsOnQuiz($_SESSION['cqid'],$user->ID) as $attempt)
                {
                    echo"<td>".$quiz['title']."     </td>";
                    echo"<td>".$attempt['started']."      </td>";
                    echo"<td>".$attempt['ended']."    </td>";
                    if($attempt['grade']==0)
                        {
                            echo'<td>-</td>';
                        }
                    else
                        {
                            echo'<td>'.$attempt['grade'].'</td>';
                        }
                    echo "</tr>";
                }

            echo    '</table>';
?>

