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
require_once "../database.php";
$id = $_SESSION["UserId"];
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);
$conn = getConnection();

    if(isset($_POST['answer']))
        {
            $currentquiz = $_SESSION['cqid'];
            $currentattemptid = getLastAttemptonQuizID($_SESSION['cqid'],$user->ID);
            $currentquestionid = (int)$_POST['currentQuestionID'];

            if(empty($_POST["answer"]))
                {
                    if(answerIsSet($currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid, array(), "Single"))
                        {
                            $quizupdt = "UPDATE attemptanswers SET answerid=? WHERE attemptid=? AND userid=? AND quizid=? AND questionid=?";
                            $qu= $conn->prepare($quizupdt);
                            $qu->execute([null, $currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid]);
                        }
                    else
                        {
                            $q3 = "INSERT INTO attemptanswers (attemptid, userid, quizid, questionid, answerid) VALUES (?,?,?,?,?);";
                            $stmt3 = $conn->prepare($q3);
                            $stmt3->execute([$currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid, null]);
                        }
                }
            else
                {
                    $answerid = $_POST["answer"];
                    if(answerIsSet($currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid, $answerid, "Single"))
                        {
                            $quizupdt = "UPDATE attemptanswers SET answerid=? WHERE attemptid=? AND userid=? AND quizid=? AND questionid=?";
                            $qu= $conn->prepare($quizupdt);
                            $qu->execute([$answerid, $currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid]);
                        }
                    else
                        {
                            $q3 = "INSERT INTO attemptanswers (attemptid, userid, quizid, questionid, answerid) VALUES (?,?,?,?,?);";
                            $stmt3 = $conn->prepare($q3);
                            $stmt3->execute([$currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid, $answerid]);
                        }
                }
        }
    elseif(isset($_POST['canswer']) || empty($_POST['canswer']))
        {
            $currentquiz = (int)$_SESSION['cqid'];
            $currentattemptid = getLastAttemptonQuizID($_SESSION['cqid'],$user->ID);
            $currentquestionid = (int)$_POST['currentQuestionID'];


            if(empty($_POST["canswer"]))
                {
                    if(answerIsSet($currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid, array(), "Multiple"))
                        {
                            $quizupdt = "UPDATE attemptanswers SET answerid=? WHERE attemptid=? AND userid=? AND quizid=? AND questionid=?";
                            $qu= $conn->prepare($quizupdt);
                            $qu->execute([null, $currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid]);
                        }
                }
            else
                {
                    $answerids = $_POST["canswer"];
                    foreach ($answerids as $answer)
                        {
                            if(!answerIsSet($currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid, $answer, "Multiple"))
                                {
                                    $q3 = "INSERT INTO attemptanswers (attemptid, userid, quizid, questionid, answerid) VALUES (?,?,?,?,?);";
                                    $stmt3 = $conn->prepare($q3);
                                    $stmt3->execute([$currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid, $answer]);
                                }
                        }
                    deleteAnswerUpdate($currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid, $_POST['canswer']);
                }
            deleteNulls($currentattemptid['attemptid'], $user->ID, $currentquiz, $currentquestionid);
        }
?>

