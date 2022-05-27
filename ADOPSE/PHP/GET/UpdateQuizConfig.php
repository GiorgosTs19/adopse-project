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
<!--    <link href="../../Css/StylesIndex.css" rel="stylesheet" type="text/css" media="screen"/>-->
<!--    <link href="../../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>-->
<!--   <link href="../Css/Answers.scss" rel="stylesheet" type="text/css" media="screen"/>-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<!--    <script src="../Javascript/Javascript.js"></script>-->
<!--</head>-->
<!--<body>-->
<?php
    require_once "../Functions/Functions.php";
    include_once("../Objects/User.php");
    require_once "../database.php";
    $conn = getConnection();
    //User Initialization
    $user = new User();
    $user->setID($_SESSION["UserId"]);
    $user->setName($_SESSION["UserN"]);
    $user->setLastName($_SESSION["UserLN"]);
    $user->setEmail($_SESSION["UserE"]);
    //Form Variables
    $viewable = $title = $topic = $password = $attempts = $neggrade = $shortdesc = $timelimit = "";
    $quizid = null;
    //Errors
    $time0error = $attempt1error  = $neggradeerror = $passemptyerror = "";
    //Booleans for Quiz Attributes
    $mattempts = $neggradeon = $shuffled = $fwdonly = $passonly = $timed = false;
    //Booleans for integrity checks
    $shortdescok = $titleok = $topicok = $attemptsok =
    $passok = $timelimitok  = $fwdonlyok = $neggradeok = false;
    //Tips for specific fields
    $attemptstip = "Set to 0 for no limit.";
    $passwordtip = "The password is Case-Sensitive.";
    $neggradetip = "Tip : The Negative Grading will be equal to "
    . "(Grade of a correct answer / your input )."
    . " Cannot be set to 0.";

    if(isset($_GET['qid']))
        {
            $quizfetch = "SELECT * FROM quizes AS q 
            JOIN quizattributes AS qa 
            ON q.id=qa.quizid WHERE q.id=?";
            $qf= $conn->prepare($quizfetch);
            $qf->execute([$_GET['qid']]);
            $results = $qf->fetch(PDO::FETCH_ASSOC);
        }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //Quiz Title
        if (empty($_POST["Title"])) {
            $titleok = false;
        } else {
            $title = $_POST["Title"];
            $titleok = true;
        }
        //Quiz Topic
        if (empty($_POST["Topic"])) {
            $topicok = false;
        } else {
            $topic = $_POST["Topic"];
            $topicok = true;
        }
        //Quiz Short Description
        if (empty($_POST["ShortDesc"])) {
            $shortdescok = false;
        } else {
            $shortdesc = $_POST["ShortDesc"];
            $shortdescok = true;
        }
        //Option to shuffle the questions
        if (isset($_POST["Shuffled"])) {
            $shuffled = 1;
        } else {
            $shuffled = 0;
        }
        //Option to make the Quiz Forward-Only
        if (isset($_POST["ForwardOnly"])) {
            $fwdonly = 1;
            $fwdonlyok = true;
        } else {
            $fwdonly = 0;
            $fwdonlyok = true;
        }

        //Option to allow multiple attempts
        if (isset($_POST["Attemps"])) {
            $mattempts = 1; //Boolean 1 for Multiple Attempts

            if ($_POST["AttemptCount"] == 0) {
                $attempts = 10000;
                $attemptsok = true;
                $attempt1error = "";
            } else if ($_POST["AttemptCount"] == 1) {
                $attempt1error = "If you wish to only allow 1 attempt, "
                    . "uncheck the corresponding checkbox.";
                $attemptsok = false;
            } else {
                $attempts = $_POST["AttemptCount"];
                $attempt1error = "";
                $attemptsok = true;
            }
        } else {
            $mattempts = 0; //Boolean 0 for One Attempt
            $attempts = 1;
            $attemptsok = true;
        }

        //Option to have Negative Grading
        if (isset($_POST["NegGrading"])) {
            $neggradeon = 1;
            if ($_POST["NegGrade"] == 0) {
                $neggradeok = false;
                $neggradeerror = "The value of Negative Grading cannot be set to 0, "
                    . "uncheck the corresponding checkbox for no Negative Grading.";
            } else {
                $neggrade = $_POST["NegGrade"];
                $neggradeerror = "";
                $neggradeok = true;
            }
        } else {
            $neggradeon = 0;
            $neggradeok = true;
            $neggrade = null;
        }

        //Option to make the Quiz have a time limit
        if (isset($_POST["Timed"])) {
            $timed = 1; //Boolean 1 for Timed Quiz
            if (empty($_POST["QuizTimeLimit"])) {
                $time0error = "Uncheck the corresponding checkbox for no time limit.";
                $timelimitok = false;
            }
            if ($_POST["QuizTimeLimit"] == 0) {
                $time0error = "Uncheck the corresponding checkbox for no time limit.";
                $timelimitok = false;
            } else {
                $timelimit = $_POST["QuizTimeLimit"];
                $timelimitok = true;
                $time0error = "";
            }
        } else {
            $timed = 0; //Boolean 0 for Timeless Quiz
            $time0error = "";
            $timelimit = null;
            $timelimitok = true;
        }
        //              Option to make your Quiz be accessible only with a password
        if (isset($_POST["PassOnly"]))
            {
                $passonly = 1;
                if (empty($_POST["QuizPassword"]))
                    {
                        $passemptyerror = "Uncheck the corresponding checkbox "
                            . "if you don't want a password-only accessible quiz.";
                        $passok = false;
                    }
                else
                    {
                        $password = $_POST["QuizTimeLimit"];
                        $passok = true;
                        $passemptyerror = "";
                    }
            }
        else
            {
                $passonly = 0;
                $passemptyerror = $passwordtip = "";
                $password = null;
                $passok = true;
            }
        if(isset($_POST["Viewable"]))
            {
                $viewable=0;
            }
        else
            {
                $viewable=1;
            }

                if ($passok && $attemptsok && $titleok && $topicok
                    && $fwdonlyok && $neggradeok && $timelimitok && $shortdescok)
                        {
                            $quizid = $_POST['updatethisquiz'];
                            //                        try
                            //                            {
                            $quizupdt = "UPDATE quizes SET title=?, sdesc=?, topic=?, viewable = ? WHERE id=?";
                            $qu = $conn->prepare($quizupdt);
                            $qu->execute([$title, $shortdesc, $topic, $viewable, $quizid]);
                            //                            }
                            //                        catch (Exception $ex)
                            //                            {
                            //                                $genError = $ex;
                            //                            }
                            //$quizid = selectMaxFromCreator($user->ID,"quizes");
                            //                       try
                            //                            {
                            $quizupdtattq = "UPDATE quizattributes SET timed=?, multipleattempts=?, shuffled=?, "
                                . "forwardonly=?, negativegrading=?, passonly=?, password=?, attempts=?, neggrade=?,timelimit=? WHERE quizid=?";
                            $qaupdt = $conn->prepare($quizupdtattq);
                            $qaupdt->execute([$timed, $mattempts, $shuffled, $fwdonly
                                , $neggradeon, $passonly, $password, $attempts, $neggrade, $timelimit, $quizid]);
                            $lquizid = selectMaxFromCreator($user->ID, "quizes");
                            //                            }
                            //                        catch (Exception $ex)
                            //                            {
                            //                                $genError = $ex;
                            //                            }
                        }
    }
    echo        '<img id="close" src="../images/close_window.png" onclick="closeWindow()" style="float: right;"  />';
    echo '<form id="QuizUF" action="">';
    echo '<fieldset class="modal-fieldset">';
    echo               '<label for="Title" >A title for your Quiz</label>';
    echo               '<br>';
    echo               '<input required type="text" id="Title" name="Title" value="'.$results["title"].'">';
    echo               '<br>';
    echo               '<label for="Topic" >Quiz Topic</label>';
    echo               '<br>';
    echo               '<input required type="text" id="Topic" name="Topic" value="'.$results['topic'].'">';
    echo               '<br>';
    echo               '<p class="tip">Try to provide a maximum of 2 words, best describing the topic of your Quiz!</p>';
    echo               '<br>';
    echo               '<br>';
    echo               '<label for="ShortDesc" >A short description for your Quiz</label>';
    echo               '<br>';
    echo               '<input required type="text" id="ShortDesc" name="ShortDesc" value="'.$results['sdesc'].'">';
    echo               '<br>';
    echo               '<br>';
    echo               '<span style="color: red">Please note that adding no Questions to your Quiz will result in your quiz not being viewable to others.</span>';
    echo               '<br>';
    echo               '<br>';
    echo               '<label for="Shuffled" >Shuffle Questions</label>';
    if($results['shuffled']==1)
        {
            echo    '<input checked type="checkbox" id="Shuffle" name="Shuffled" value="Shuffled">';
        }
    else
        {
            echo    '<input type="checkbox" id="Shuffle" name="Shuffled" value="Shuffled">';
        }
    echo               '<br>';
    echo               '<br>';
    echo               '<label for="Attemps">Allow Multiple Attempts</label>';
    if($results['multipleattempts']==1)
        {
            echo    '<input checked type="checkbox" id="Attemps" name="Attemps" value="Attemps" onclick="Attempts()">';
        }
    else
        {
            echo    '<input type="checkbox" id="Attemps" name="Attemps" value="Attemps" onclick="Attempts()">';
        }
    if($results['attempts']==1)
        {
            echo    '<label for="AttemptCount" id="AttempCountLabel" hidden>Attempt Count : </label>';
            echo    '<input type="number" id="AttemptCount" name="AttemptCount" 
                min="0" oninput="this.value = Math.abs(this.value)" hidden>';
        }
    else
        {
            echo    '<label for="AttemptCount" id="AttempCountLabel">Attempt Count : </label>';
            echo    '<input type="number" id="AttemptCount" name="AttemptCount" 
                min="0" oninput="this.value = Math.abs(this.value)" value="'.$results['attempts'].'">';
        }

    echo                '<br>';
    echo                '<span class="tip" id="attemptstip" hidden><?php echo $attemptstip;?></span>';
    echo                '<span class="error"><?php echo $attempt1error;?></span>';
    echo                '<br>';
    echo    '<label for="Timed">Do you want your Quiz to have a time limit?</label>';
    if($results['timed']==0)
        {
            echo    '<input type="checkbox" id="Timed" name="Timed" value="Timed" onclick="TimeLimit()">';
            echo    '<label for="QuizTimeLimit" id="QuizTimeLimitLabel" hidden>Time Limit (Minutes) : </label>';
            echo    '<input type="number" id="QuizTimeLimit" name="QuizTimeLimit"
                min="0" oninput="this.value = Math.abs(this.value)" hidden>';
        }
    else
        {
            echo    '<input checked type="checkbox" id="Timed" name="Timed" value="Timed" onclick="TimeLimit()">';
            echo    '<label for="QuizTimeLimit" id="QuizTimeLimitLabel" >Time Limit (Minutes) : </label>';
            echo    '<input type="number" id="QuizTimeLimit" name="QuizTimeLimit"
                min="0" oninput="this.value = Math.abs(this.value)" value="'.$results['timelimit'].'">';
        }


    echo                '<br>';
    echo                '<span class="error"><?php echo $time0error;?></span>';
    echo                '<br>';
    echo                '<label for="ForwardOnly">Do you want your Quiz to be "Forward Only" ?</label>';

    if($results['forwardonly']==0)
        {
            echo    ' <input type="checkbox" id="ForwardOnly" name="ForwardOnly" value="ForwardOnly">';
        }
    else
        {
            echo    ' <input checked type="checkbox" id="ForwardOnly" name="ForwardOnly" value="ForwardOnly">';
        }

    echo                '<br>';
    echo                '<br>';
    echo                '<label for="NegGrading">Do you want your Quiz to have negative grading?</label>';
    if($results['negativegrading']==0)
        {
            echo    '<input type="checkbox" id="NegGrading" name="NegGrading" value="NegGrading" onclick="NegativeGrading()">';
        }
    else
        {
            echo    '<input checked type="checkbox" id="NegGrading" name="NegGrading" value="NegGrading" onclick="NegativeGrading()">';
        }
    if(!$results['neggrade']==null)
        {
            echo    '<label for="NegGrade" id="NegGradeLabel" >"Correct Answers Grade / "</label>';
            echo    '<input type="number" id="NegGrade" name="NegGrade" min="0" oninput="this.value = Math.abs(this.value)" value="'.$results['neggrade'].'">';
        }
    else
        {
            echo    '<label for="NegGrade" id="NegGradeLabel" hidden>"Correct Answers Grade / "</label>';
            echo    '<input checked type="number" id="NegGrade" name="NegGrade" min="0" oninput="this.value = Math.abs(this.value)" hidden>';
        }
    echo                '<br>';
    echo                '<span class="tip" id="neggradetip" hidden><?php echo $neggradetip;?></span>';
    echo                '<span class="error"><?php echo $neggradeerror;?></span>';
    echo                '<br>';
    echo                '<label for="PassOnly">Make your Quiz accessible only with a password?</label>';
    //Password Only Option
    if($results['passonly']==1)
        {
            echo '<input checked type="checkbox" id="PassOnly" name="PassOnly" value="PassOnly" onclick="QuizAccessPassword()">';
        }
    else
        {
            echo '<input type="checkbox" id="PassOnly" name="PassOnly" value="PassOnly" onclick="QuizAccessPassword()">';
        }
    //IF Password Only Option is enabled, the password
    if($results['password']==null)
        {
            echo    '<label for="QuizPassword" id="QuizPasswordLabel" hidden>Password : </label>';
            echo    '<input type="text" id="QuizPassword" name="QuizPassword" hidden>';
        }
    else
        {
            echo    '<label for="QuizPassword" id="QuizPasswordLabel">Password : </label>';
            echo    '<input type="text" id="QuizPassword" name="QuizPassword" value="'.$results['password'].'">';
        }
    echo    '<br>';
    echo    '<br>';
    if($results['viewable']==0)
        {
            echo         '<label for="Viewable" >Make your quiz visible to others?</label>';
            echo          '<br>';
            echo   '<div class="toggle-button-cover">';
            echo     '<div class="button-cover">';
            echo       '<div class="button b2" id="button-11">';
            echo         '<input checked type="checkbox" class="checkbox" name="Viewable" />';
            echo         '<div class="knobs">';
            echo           '<span></span>';
            echo         '</div>';
            echo         '<div class="layer"></div>';
            echo       '</div>';
            echo     '</div>';
            echo   '</div>';
        }
    else
        {
             echo         '<label for="Viewable" >Make your quiz visible to others?</label>';
             echo          '<br>';
             echo   '<div class="toggle-button-cover">';
             echo     '<div class="button-cover">';
             echo       '<div class="button b2" id="button-11">';
             echo         '<input type="checkbox" class="checkbox" name="Viewable" />';
             echo         '<div class="knobs">';
             echo           '<span></span>';
             echo         '</div>';
             echo         '<div class="layer"></div>';
             echo       '</div>';
             echo     '</div>';
             echo   '</div>';
        }
    echo                '<br>';
    echo                '<span class="tip" id="passwordtip" hidden><?php echo $passwordtip;?></span>';
    echo                '<span class="error"><?php echo $passemptyerror;?></span>';
    echo                '<br>';
    echo                '<br>';
    echo                    '<input id="update" type="submit" name="action" onclick="" value="Update" >';
    echo                '<br>';
echo        '<input type="text" name="updatethisquiz" id="getQuizID" value="'.$results['id'].'" hidden>';
    echo            '</fieldset>';
    echo        '</form>';
    echo                '<div id="editQuestionsNotUsed">';
    echo                '</div>';
    echo                '<div id="editQuestionsUsed">';
    echo                '</div>';
?>
<!--</body>-->