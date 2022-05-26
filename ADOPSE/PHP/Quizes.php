<?php
session_start();
if(!$_SESSION["LoggedIn"])
{
    header("Location: http://localhost/ADOPSE/PHP/Login.php");
}
?>
<!DOCTYPE html>
<html>
    <?php
        require_once "Functions/Functions.php";
        include_once("Objects/User.php");
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
        //Form Variables
        $title = $topic = $password = $attempts = $neggrade = $shortdesc = $timelimit = $viewable = "";
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
        
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")
            {

                //Quiz Title
                if (empty($_POST["Title"]))
                {$titleok = false;}
                else {$title = $_POST["Title"]; $titleok = true;}
                //Quiz Topic
                if (empty($_POST["Topic"])) {$topicok = false;}
                else {$topic = $_POST["Topic"]; $topicok = true;}
                //Quiz Short Description
                if (empty($_POST["ShortDesc"])) {$shortdescok = false;}
                else {$shortdesc = $_POST["ShortDesc"]; $shortdescok = true;}
                //Option to shuffle the questions
                if (isset($_POST["Shuffled"])){$shuffled = 1;}
                else {$shuffled = 0;}
                //Option to make the Quiz Forward-Only
                if (isset($_POST["ForwardOnly"])){$fwdonly = 1; $fwdonlyok=true;}
                else {$fwdonly = 0; $fwdonlyok=true;}

//              Option to allow multiple attempts
            if (isset($_POST["Attemps"]))
            {
                $mattempts = 1; //Boolean 1 for Multiple Attempts

                if($_POST["AttemptCount"]==0)
                {
                    $attempts = 10000;
                    $attemptsok = true;
                    $attempt1error="";
                }
                else if($_POST["AttemptCount"]==1)
                {
                    $attempt1error = "If you wish to only allow 1 attempt, "
                        . "uncheck the corresponding checkbox.";
                    $attemptsok = false;
                }
                else
                {
                    $attempts = $_POST["AttemptCount"];
                    $attempt1error="";
                    $attemptsok = true;
                }
            }
            else
                {
                    $mattempts = 0; //Boolean 0 for One Attempt
                    $attempts=1;
                    $attemptsok = true;
                }

//              Option to have Negative Grading
            if (isset($_POST["NegGrading"]))
                {
                    $neggradeon = 1;
                    if($_POST["NegGrade"]==0)
                    {
                        $neggradeok = false;
                        $neggradeerror="The value of Negative Grading cannot be set to 0, "
                            . "uncheck the corresponding checkbox for no Negative Grading.";
                    }
                    else
                    {
                        $neggrade = $_POST["NegGrade"];
                        $neggradeerror="";
                        $neggradeok = true;
                    }
                }
            else
                {
                    $neggradeon = 0;
                    $neggradeok = true;
                    $neggrade=null;
                }

            if (isset($_POST["Viewable"]))
                {
                    $viewable=0;
                }
            else
                {
                    $viewable=1;
                }

//              Option to make the Quiz have a time limit
            if (isset($_POST["Timed"]))
            {
                $timed = 1; //Boolean 1 for Timed Quiz
                if(empty($_POST["QuizTimeLimit"]))
                {
                    $time0error = "Uncheck the corresponding checkbox for no time limit.";
                    $timelimitok=false;
                }
                if($_POST["QuizTimeLimit"]==0)
                {
                    $time0error = "Uncheck the corresponding checkbox for no time limit.";
                    $timelimitok=false;
                }
                else
                {
                    $timelimit = $_POST["QuizTimeLimit"];
                    $timelimitok=true;
                    $time0error = "";
                }
            }
            else
            {
                $timed = 0; //Boolean 0 for Timeless Quiz
                $time0error = "";
                $timelimit=null;
                $timelimitok = true;
            }
//              Option to make your Quiz be accessible only with a password
            if (isset($_POST["PassOnly"]))
                {
                    $passonly = 1;
                    if(empty($_POST["QuizPassword"]))
                        {
                            $passemptyerror = "Uncheck the corresponding checkbox "
                                . "if you don't want a password-only accessible quiz.";
                            $passok=false;
                        }
                    else
                        {
                            $password = $_POST["QuizTimeLimit"];
                            $passok=true;
                            $passemptyerror = "";
                        }
                }
            else
                {
                    $passonly = 0;
                    $passemptyerror = $passwordtip = "";
                    $password=null;
                    $passok=true;
                }
                if ($_POST['buttonpressed']=='Publish')
                    {


                    if($passok && $attemptsok && $titleok && $topicok
                        && $fwdonlyok && $neggradeok && $timelimitok && $shortdescok)
                    {
//                        try
//                            {
                        $now = date("Y-m-d H:i:s");
                        $quizesq = "INSERT INTO quizes (title, sdesc, topic, idcreator, datetimecreated, viewable) VALUES (?, ?, ?, ?, ?, ?);";
                        $qq = $conn->prepare($quizesq);
                        $qq->execute([$title, $shortdesc, $topic, $user->ID,$now, $viewable]);
//                            }
//                        catch (Exception $ex)
//                            {
//                                $genError = $ex;
//                            }
                        $quizid = selectMaxFromCreator($user->ID,"quizes");
//                       try
//                            {
                        $quizattq = "INSERT INTO quizattributes (quizid, timed, multipleattempts, shuffled, "
                            . "forwardonly, negativegrading, passonly, password, attempts, neggrade,timelimit) "
                            . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                        $qaq = $conn->prepare($quizattq);
                        $qaq->execute([$quizid, $timed, $mattempts, $shuffled, $fwdonly
                            , $neggradeon, $passonly, $password, $attempts, $neggrade, $timelimit]);
                        $lquizid = selectMaxFromCreator($user->ID,"quizes");
//                            }
//                        catch (Exception $ex)
//                            {
//                                $genError = $ex;
//                            }
                    }
                    }
                elseif ($_POST["buttonpressed"]=='Update')
                    {
                        if($passok && $attemptsok && $titleok && $topicok
                            && $fwdonlyok && $neggradeok && $timelimitok && $shortdescok)
                        {
                            $quizid = selectMaxFromCreator($user->ID,"quizes");
                            //                        try
                            //                            {
                            $quizupdt = "UPDATE quizes SET title=?, sdesc=?, topic=? , viewable=? WHERE id=?";
                            $qu= $conn->prepare($quizupdt);
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
                            $lquizid = selectMaxFromCreator($user->ID,"quizes");
                            //                            }
                            //                        catch (Exception $ex)
                            //                            {
                            //                                $genError = $ex;
                            //                            }
                        }
                    }

           }   
    ?>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="../Css/Answers.scss" rel="stylesheet" type="text/css" media="seen"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../Javascript/Javascript.js"></script>
        <script src="../Javascript/Create_Test.js"></script>
        <script src="../Javascript/CommonFunctions.js"></script>
    </head>
    
    <template id="">

    </template>
    <style>

    </style>
    <body>
        
        <div id="wrapper">   
            <div id="top">
               <div id="logo">
                   <a href="index.php">
                       <img src="../images/UniversityLogo.jpeg" height="100" width="133" /></a>
               </div>
                
           </div>
            <span id="CTBurger" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
            <br>
            <br>
            
<!--            Burger Navigation-->
           <div class="sidenav" id="mySidenav">
               <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
               <a class="active" href="index.php">Home</a>
               <a href="Questions.php">Questions</a>
               <a href="Quizes.php">Exams</a>
               <a href="Logout.php" style="margin-top: 50%">Log Out</a>
           </div>

            <div class="btn-group">
                <button class="button" id="createquiz" onclick="quizCreationForm()" >Create a Quiz</button>
                <button class="button" id="viewquizes" onclick="viewQuizes()" >View my Quizes</button>
            </div>

            <div id="myQuizModal" class="modal" >
                <div class="modal-content" id="quiz-modal-content">

                </div>
            </div>


            <form id="QuizCF" action="" hidden>
               <fieldset id="QuizCFfieldset">
<!--                   Quiz Title-->
                   <label for="Title" >A title for your Quiz</label>
                   <br>
                   <input required type="text" id="Title" name="Title" 
                       value="">
                   <br>
                   <br>
<!--                   Quiz Topic-->
                   <label for="Topic" >Quiz Topic</label>
                   <br>
                   <input required type="text" id="Topic" name="Topic" 
                       value="">
                   <br>
                   <p class="tip">Try to provide a maximum of 2 words, best describing the topic of your Quiz!</p>
                   <br>
                   <br>
<!--                   Quiz Description-->
                   <label for="ShortDesc" >A short description for your Quiz</label>
                   <br>
                   <input required type="text" id="ShortDesc" name="ShortDesc" 
                       value="">
                   <br>
                   <br>
<!--                   Option to Shuffle the Questions-->
                   <label for="Shuffled" >Shuffle Questions</label>
                   <input type="checkbox" id="Shuffle" name="Shuffled" 
                       value="Shuffled"> 
                   <br>
                   <br>
<!--                   Option to allow multiple attempts-->
                   <label for="Attemps">Allow Multiple Attempts</label>
                   <input type="checkbox" id="Attemps" name="Attemps" 
                       value="Attemps" onclick="Attempts()"> 
                   <label for="AttemptCount" id="AttempCountLabel" hidden>Attempt Count : </label>
                   <input type='number' id="AttemptCount" name='AttemptCount' min="0" oninput="this.value = Math.abs(this.value)" hidden>
                   <br>
                   <span class="tip" id="attemptstip" hidden><?php echo $attemptstip;?></span>
                   <span class="error"><?php echo $attempt1error;?></span>
                   <br> 
<!--                   Option to make the Quiz have a time limit-->
                   <label for="Timed">Do you want your Quiz to have a time limit?</label>
                   <input type="checkbox" id="Timed" name="Timed" 
                       value="Timed" onclick="TimeLimit()">
                   <label for="QuizTimeLimit" id='QuizTimeLimitLabel' hidden>Time Limit (Minutes) : </label>
                   <input type='number' id="QuizTimeLimit" name='QuizTimeLimit' min="0" oninput="this.value = Math.abs(this.value)" hidden>
                   <br>
                   <span class="error"><?php echo $time0error;?></span>
                   <br>
<!--                   Option to make your Quiz be "Forward Only"-->
                   <label for="ForwardOnly">Do you want your Quiz to be "Forward Only" ?</label>
                   <input type="checkbox" id="ForwardOnly" name="ForwardOnly" 
                       value="ForwardOnly"> 
                   <br>
                   <br>
<!--                   Option to make your Quiz have negative grading-->
                   <label for="NegGrading">Do you want your Quiz to have negative grading?</label>
                   <input type="checkbox" id="NegGrading" name="NegGrading" 
                       value="NegGrading" onclick="NegativeGrading()">       
                   <label for="NegGrade" id="NegGradeLabel" hidden>Correct Answer's Grade / </label>
                   <input type='number' id="NegGrade" name='NegGrade' min="0" oninput="this.value = Math.abs(this.value)" hidden>
                   <br>
                   <span class="tip" id="neggradetip" hidden><?php echo $neggradetip;?></span>
                   <span class="error"><?php echo $neggradeerror;?></span>
                   <br>
<!--                   Option to make your Quiz be accessible only with a password-->
                   <label for="PassOnly">Make your Quiz accessible only with a password?</label>
                   <input type="checkbox" id="PassOnly" name="PassOnly" 
                       value="PassOnly" onclick="QuizAccessPassword()">
                   <label for="QuizPassword" id="QuizPasswordLabel" hidden>Password : </label>
                   <input type='text' id="QuizPassword" name='QuizPassword' hidden>
                   <br>
                   <span class="tip" id="passwordtip" hidden><?php echo $passwordtip;?></span>
                   <span class="error"><?php echo $passemptyerror;?></span>
                   <br>
                   <label for="Viewable" >Make your quiz immediately visible to others?</label>
                   <br>
                   <div class="toggle-button-cover">
                       <div class="button-cover">
                           <div class="button b2" id="button-11">
                               <input type="checkbox" class="checkbox" name="Viewable" />
                               <div class="knobs">
                                   <span></span>
                                   </div>
                               <div class="layer"></div>
                               </div>
                           </div>
                       </div>
                   <br>                   
                   <br>
                   <div id="answersdiv"> 
                   </div>
                   <br>
                   <input id="publish" type="submit" name="action" value="Publish">
                   <input id="update" type="submit" name="action" onclick="backToQuizQuestions()" value="Update" hidden>
                   <input type='text' id="buttonpressed" name='buttonpressed' value="Publish" hidden>
                   <br>        
                   <br>
               </fieldset>
           </form>
            <button type="button" id='BackToConfig' onclick="backToConfig()" hidden>Back to Quiz Configurations</button>
<!--        <button type="button" id='BackToQuestions' onclick="backToQuizQuestions()"  hidden>Back to Quiz Questions</button>-->
        <button id="submitquiz" onClick="window.location.reload();" hidden>Submit Quiz</button>
        </div>

                <div id="myQuestionsList" hidden>
                </div>

                <div id="questionsAlreadyInTheQuiz" hidden>
                </div>

            <div class="container" id="myQuizesContainer" hidden>
                <div class="row">
                    <div class=" col-sm-12 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="leftbar_content" id="leftbar_content">
                                <h2>My Quizes</h2>
                                <div id="myQuizes">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!--        <div>

            <p id="ok"></p>
            <p><?php echo "passok $passok";?></p>
            <p><?php echo "timeok $timelimitok";?></p>
            <p><?php echo "attemptsok $attemptsok";?></p>
            <p><?php echo "titleok $titleok";?></p>
            <p><?php echo "topicok $topicok";?></p>
            <p><?php echo "fwdonlyok $fwdonlyok";?></p>
            <p><?php echo "neggradeok $neggradeok";?></p>
            <p><?php echo "timelimitok $timelimitok";?></p>
            <p><?php echo "shortdescok $shortdescok";?></p>
        </div>-->

    </body>
</html>
