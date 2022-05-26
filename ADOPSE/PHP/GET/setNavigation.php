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

if(isset($_GET['navquizid']))
    {
        $questions = getQuizQuestions($_GET['navquizid']);
        $i=0;
        foreach ($questions as $question)
            {
//                $i++;
//                if(ForwardOnlyCondition($_GET['navquizid'])==1)
//                    {
//                        echo    '<button type="submit" form="submitAnswer" class="grid-element">'.$i.'</button>';
//                    }
//                else
//                    {
//                        echo    '<button type="submit" form="submitAnswer" class="grid-element" onclick="fetchQuestion('.$question.')">'.$i.'</button>';
//                    }

            $i++;
                    if(ForwardOnlyCondition($_GET['navquizid'])==1)
                        {
                            if($_GET['currentquestion']==$question)
                                {
                                    echo    '<p class="grid-preview-element" style="background-color: #03a9f4;"><span>'.$i.'</span> <img src="../images/circle.png" width="20px" height="20px" style="border: none;"></p>';
                                }
                            else
                                {
                                    echo    '<p class="grid-preview-element"><span>'.$i.'</span> <img src="../images/circle.png" width="20px" height="20px" style="border: none;"></p>';
                                }

                        }
                    else
                        {
                            if($_GET['currentquestion']==$question)
                                {
                                    echo    '<p class="grid-preview-element" style="background-color: #03a9f4;" onclick="fetchQuestion('.$question.')"><span>'.$i.'</span> <img src="../images/circle.png" width="20px" height="20px" style="border: none; background-color: #03a9f4;"></p>';
                                }
                            else
                                {
                                    echo    '<p class="grid-preview-element" onclick="fetchQuestion('.$question.')"><span>'.$i.'</span> <img src="../images/circle.png" width="20px" height="20px" style="border: none;"></p>';
                                }
                        }
                }

    }
?>

