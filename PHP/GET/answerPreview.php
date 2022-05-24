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

if($_GET['preview']==="1")
    {
        $questions = getQuizQuestions(195);
        $currentquiz = (int)$_SESSION['cqid'];
        $currentattemptid = getLastAttemptonQuizID($currentquiz,$user->ID);
        $i=0;
        foreach ($questions as $question)
            {
                $i++;
                if(answerSubmitted($currentattemptid['attemptid'], $user->ID, $currentquiz, $question))
                    {
                        echo    '<p class="grid-preview-element" onclick="fetchQuestion('.$question.')"><span>'.$i.'</span> <img src="../images/tick.png" width="20px" height="20px" style="border: none;"></p>';
                    }
                else
                    {
                        echo    '<p class="grid-preview-element" onclick="fetchQuestion('.$question.')"><span>'.$i.'</span> <img src="../images/unsubmitted.png" width="20px" height="20px" style="border: none;" ></p>';
                    }
            }
    }

?>



