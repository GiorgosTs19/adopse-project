<!DOCTYPE html>
<?php
session_start();
if(!$_SESSION["LoggedIn"])
{
    header("Location: http://localhost/ADOPSE/PHP/Login.php");
}
?>
<html lang="en">
    <?php
        require_once "Functions/Functions.php";
        include_once("Objects/User.php");
        //DB Info
        include_once("DatabaseConnection.php");
        $conn = DatabaseConnection::connect();
        //User Info
        $user = new User();
        $user->setID($_SESSION["UserId"]);  
        $user->setName($_SESSION["UserN"]);
        $user->setLastName($_SESSION["UserLN"]);
        $user->setEmail($_SESSION["UserE"]);
        //Form Inputs
        $questiontype = $questiontext = $questiontopic = "";
        $qtextok = $qtopicok = $qtypeok = false;
        $Success = $genError = "";
        //Οι τιμές των πεδίων που έχουν συμπληρωθεί παραμένουν
        $InTopic = $InType = $InText = "";
        $questionid = null;
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                if (empty($_POST["QuestionType"])) 
                    {
                      //$qtypeok= $eError;
                      $qtypeok = false;
                    } 
                else 
                    {
                      $questiontype = $_POST["QuestionType"];
                      $qtypeok = true;
                    }
                if (empty($_POST["QuestionText"])) 
                    {
                      //$qtypeok= $eError;
                      $qtextok = false;
                    } 
                else 
                    {
                      $questiontext = $_POST["QuestionText"];
                      $qtextok = true;
                    }
                if (empty($_POST["QuestionTopic"])) 
                    {
                      //$qtypeok= $eError;
                      $qtopicok = false;
                    } 
                else 
                    {
                      $questiontopic = $_POST["QuestionTopic"];
                      $qtopicok = true;
                    }
                if($qtopicok && $qtextok &&  $qtypeok)   
                    {
                        try
                            {
                                $q = "INSERT INTO questions (question, type, topic, idcreator) VALUES (?, ?, ?, ?);";
                                $stmt = $conn->prepare($q);
                                $stmt->execute([$questiontext,$questiontype, $questiontopic, $user->ID]);
                                $Success = "Question $questiontext Successfully Created";
                                $InTopic = "";
                                $InText = "";
                                $InType = "";
                            } 
                        catch (Exception $ex) 
                            {   
                                $genError = $ex;
                            }   
                        try
                            {
                                $questionid = selectMaxFromCreator($user->ID,"questions");
                            } 
                        catch (Exception $ex) 
                            {

                            }
                            
                        if(!strcmp($questiontype, "MCSCA"))
                            {
                                for($i = 0; $i <$_POST['answercount']; $i++) 
                                    {
                                        $q = "INSERT INTO answers (text, correct, parent, idcreator) VALUES (?, ?, ?, ?);";
                                        $stmt = $conn->prepare($q);
                                            if($i==$_POST["correctanswerid"])
                                                {
                                                    $stmt->execute([$_POST["answer"][$i],1, $questionid, $user->ID]);
                                                }
                                            else
                                                {
                                                    $stmt->execute([$_POST["answer"][$i],0, $questionid, $user->ID]);
                                                }                                                                  
                                    }
                            }
                        else if(!strcmp($questiontype, "MCMCA"))
                            {
                                for($i = 0; $i <$_POST['answercount']; $i++) 
                                    {
                                        $temp='correctcheck'.$i;
                                        $q = "INSERT INTO answers (text, correct, parent, idcreator) VALUES (?, ?, ?, ?);";
                                        $stmt = $conn->prepare($q);
                                            if(isset($_POST[$temp]))
                                                {
                                                    $stmt->execute([$_POST["answer"][$i],1, $questionid, $user->ID]);
                                                }
                                            else
                                                {
                                                    $stmt->execute([$_POST["answer"][$i],0, $questionid, $user->ID]);
                                                }                                                                  
                                    }
                            }
                        else if (!strcmp($questiontype, "ToF"))
                            {
                            for($i = 0; $i <$_POST['answercount']; $i++) 
                                {
                                    $q = "INSERT INTO answers (text, correct, parent, idcreator) VALUES (?, ?, ?, ?);";
                                        $stmt = $conn->prepare($q);
                                            if($i==$_POST["correctanswerid"])
                                                {
                                                    $stmt->execute([$_POST["radioanswer"][$i],1, $questionid, $user->ID]);
                                                }
                                            else
                                                {
                                                    $stmt->execute([$_POST["radioanswer"][$i],0, $questionid, $user->ID]);
                                                }
                                }
                            }
                    } 
//                else
//                    {
//                        $InText = $questiontext;
//                        $InTopic = $questiontopic;
//                        $InType = $questiontype;
//                    }                
            }
        
    ?>
    
        
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../Javascript/Javascript.js"></script>
    <script src="../Javascript/Questions.js"></script>
    <script src="../Javascript/CommonFunctions.js"></script>
    
</head>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
<body>
    
<template id="QuestionCreationForm">


    <form id="QCF" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
     <fieldset >
        <input type="radio" id="multiplechoiceSA" name="QuestionType" 
            value="MCSCA" onclick="showSelection(4)">
        <label for="multiplechoiceSA">Multiple Choice (Single Correct Answer)</label>
        <br>
        <input type="radio" id="multiplechoiceMA" name="QuestionType" 
            value="MCMCA" onclick="showSelection(5)">
        <label for="multiplechoiceMA">Multiple Choice (Multiple Correct Answers)</label>
        <br>
        <input type="radio" id="truefalse" name="QuestionType" 
            value="ToF" onclick="showSelection(2)">
        <label for="truefalse">True or False</label>
        <br>
        <input type="radio" id="plaintext" name="QuestionType" 
            value="PT" onclick="showSelection(0)" required>
        <label for="plaintext">Plain Text</label>
        <br>
        <br>
        <p id="value"></p>  
        <br>
        <label for="QuestionText" >Question Text</label>
        <input required type="text" id="QuestionText" name="QuestionText" 
            value="<?php echo htmlspecialchars($_POST['TestTitle'] ?? '', ENT_QUOTES); ?>"><br><br>
        <p class="tip">Try to provide a maximum of 2 words, best describing the topic of your question!</p>
        <br>
        <label for="QuestionTopic" >Question Topic</label>
        <input required type="text" id="QuestionTopic" name="QuestionTopic" 
            value="<?php echo htmlspecialchars($_POST['TestRef'] ?? '', ENT_QUOTES); ?>"><br><br>
        <div id="answersdiv">
        <input type='number' id="answercount" name='answercount' hidden>
        <input type='number' id="correctanswerid" name='correctanswerid' hidden>
        <br>
        <br>
        </div>
         <br>
         <br>
         <br>
         <input class="button-group-create-question" id="next" type="submit" value="Create Question" style="float: right;margin-right:250px " >

         <span id="success" class="Success"><?php echo $Success;?></span>
         <br>
         <span id="error" class="error"> <?php echo $genError;?></span>
<!--      onclick="swapToQuestions()"-->
     </fieldset>
    </form>

</template>
   
<template id="MultipleChoiceAnwers">
 <input type="text" name="Answer" 
        class="answers" value="True or False" onclick="showSelection(2)">
    <label for="Answer"></label>
</template>



<div id="wrapper">

    <div id="top">


        <div id="logo">
            <a href="index.php">
                <img src="../images/myQuiz.png" height="100" width="133" /></a>        </div>

    </div>


    <div class="sidenav" id="mySidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div>
            <a href="myProfile.php"><img src="../images/profile-icon.jpg" alt="Avatar" id="avatar" ></a>
        </div>

        <br>
        <a href="myProfile.php">Profile</a>
        <br>
        <br>
        <a class="active" href="index.php">Home</a>
        <br>
        <br>
        <a href="Questions.php">Questions</a>
        <a href="Quizes.php">My Quizes</a>
        <a href="Favorites.php">My Favorites</a>
        <a href="Logout.php" style="margin-top: 50%">Log Out</a>
    </div>

    <div id="contentbody">
        <div id="content">

            <div id="myQuestionModal" class="modal" >
                <div class="modal-content" id="question-modal-content">

                </div>
            </div>

            <br>
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
            <h1>Here you can create your own question(s) or view them.</h1>
            <div class="btn-group">
                <button class="button" id="createquestion" onclick="questioncreationForm()" >Create a question</button>
                <button class="button" id="viewquestion" onclick="viewQuestions()" >View my questions</button>
            </div>

        <div id="main">

            <div id="ui">
                <button class="button-group-create-question" onclick="addAnswer()" id="addAnswer" hidden>Add Answer</button>
                <button class="button-group-create-question" onclick="removeAnswer()" id="removeAnswer" hidden>Remove Answer</button>
            </div>

            <div id="myQuestions" hidden>

            </div>

        </div>

    </div>
</div>
</div>
</body>
</html>