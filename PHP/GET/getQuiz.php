<?php
session_start();
if(!$_SESSION["LoggedIn"])
{
    header("Location: http://localhost/ADOPSE/PHP/Login.php");
}
?>

<?php
require_once "../Functions/Functions.php";
require_once "../Functions/QuizFunctions.php";
include_once("../Objects/User.php");
$servername = "localhost";
$dbusername = "adopse";
$dbpassword = "Adopse@2022";
$conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//User Initialization
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);

        if(!$_GET['id']=="")
            {
                $q1 = "SELECT * FROM quizquestions 
                WHERE quizid = ?";

                $stmt1 = $GLOBALS['conn']->prepare($q1);
                $stmt1->execute([$_GET['id']]);
                $question = $stmt1->fetch(PDO::FETCH_ASSOC);

                $q = "SELECT * FROM quizes AS q 
                JOIN quizattributes AS qa 
                ON q.id = qa.quizid 
                WHERE id = ?";

                $stmt = $GLOBALS['conn']->prepare($q);
                $stmt->execute([$_GET['id']]);
                $quiz = $stmt->fetch(PDO::FETCH_ASSOC);


                echo '<div class="quizarea" id="quizarea">';
                echo '<div id="preview-grade" class="preview-grade" hidden>';
                echo '<h1>Preview</h1>';
                echo    '<div id="previewAnswers" class= "grid-preview    grid-preview--fill">';
                echo    '</div>';
                echo '</div>';
                echo    '<div id="clear" >';
                echo        '<h1>' . $quiz['title'] . '</h1>';
                echo        '<div class="quizintro" id="quizintro">';
                echo            '<div class="quizintroinfo">';
                echo                '<p class="infoborder">Topic : ' . $quiz['topic'] . '</p>';
                echo                '<p class="infoborder">Description : ' . $quiz['sdesc'] . '</p>';
                echo                '<p class="infoborder">'.userAllowedAttempts($quiz['id']).'</p>';
                echo                '<p class="infoborder"> ' . Timed($quiz['timed'], $quiz['timelimit']) . '</p>';
                echo                '<input type="number" id="timeLimit" value="'.$quiz['timelimit'].'" hidden>';
                if ($quiz['timed'] == 1)
                    {
                        echo '<p style="color: red">Warning! The timer will begin the moment you press "Start Quiz", </p>';
                        echo '<p style="color: red">and it cannot reset or be paused.</p>';
                    }

                echo        '</div>';
                echo        '<form id="startquizform">';
                echo            '<fieldset id="startquizfieldset">';
                echo                '<input type="text" id="startquizid" value="'.$_GET["id"].'" name="startquizid" hidden>';
                if(str_contains(userAllowedAttempts($_GET["id"]),"not"))
                    {
                        echo    '<input type="submit" name="startquiz" class="startquizbutton"  value=" Start Quiz !" style="pointer-events: none; background-color: grey;">';
                    }
                else
                    {
                        echo    '<input type="submit" name="startquiz" class="startquizbutton"  value=" Start Quiz !">';
                    }
                echo            '</fieldset>';
                echo        '</form>';
                echo        '<input type="text" id="firstquizquestion" value="'.$question["questionid"].'" name="firstquizquestion" hidden>';
                echo        '</div>';
                echo        '</div>';
                echo    '<div class="quizrightnav" id="quizrightnav" hidden>';
                echo        '<div class="quizrightnavbanner" id="quizrightnavbanner">';
                if(!isTimed($_SESSION['cqid'])==0)
                    {
                        echo    '<p id="timer"></p>';
                    }
                echo        '</div>';
                echo        '<div class="rightnav-progress">';
                echo            '<h1 class="h1rightnav">Your Progress</h1>';
                echo            '<div id="qnav" class="grid-container grid-container--fill"></div>';
                echo        '</div>';
                echo        '<button type="submit" form="submitAnswer" id="submitAllAnswers" class="submit" name="submit" onclick="previewAnswersSubmitted()">Submit all</button>';
                echo    '<button id="finish" class="submit" onclick="finishAttempt()">Finish Attempt</button>';
                echo       '</div>';
                echo    '</div>';
                echo '</div>';
            }
?>