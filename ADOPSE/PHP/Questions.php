<!DOCTYPE html>
<?php
// Start the session
session_start();
?>
<html lang="en">
    <?php
        require_once "Functions.php";
        include_once("Objects/User.php");
        //DB Info
        $servername = "localhost";
        $dbusername = "adopse";
        $dbpassword = "Adopse@2022";
        $_SESSION["servername"] = "localhost";
        $_SESSION["dbusername"] = "adopse";
        $_SESSION["dbpassword"] = "Adopse@2022";
        $conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
              // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

    <style>
        .auto-style3 
            {
                border-style: solid;
                border-width: 2px;
            }

        .auto-style1 
            {
                text-decoration: none;
            }
        .auto-style2 
            {
                text-align: center;
            }
        
    </style>
    
</head>

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
        <input type='number' id="answercount" name='answercount' >
        <input type='number' id="correctanswerid" name='correctanswerid' >      
            
        </div>
        <br>
        <input type="submit" value="Next" >
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
                <img src="UniversityLogo.jpeg" height="100" width="133" /></a>
        </div>

    </div>


    <div class="sidenav" id="mySidenav">

        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a class="active" href="index.php">Home</a>
        <a href="Questions.php">Questions</a>
        <a href="Exams.html">Exams</a>
        <a href="Contact.html">Contact</a>
        <a href="About.html">About</a>

    </div>

    <div id="content">

        <br>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
        <h1>Questions Section</h1>
        <p id="contenttext">Here you can create your own question(s) or view them.</p>
        <br>


    <div id="main">
            <div class="btn-group">
                <button class="button" id="createquestion" onclick="questioncreationForm()">Create a question</button>
                <button class="button" id="viewquestion" onclick="viewQuestions()">View my questions</button>
            </div>
        <div id="ui">
            
         </div>
        
        <span class="Success"><?php echo $Success;?></span>
        <br>
        <span class="error"> <?php echo $genError;?></span>
        
        
        <span id='radio1'></span>
        <br>
        <span id='radio2'></span>
        <br>
        <span id='radio3'></span>
        <br>
        <span id='radio4'></span>
    </div>
        
</div>
</div>
</body>
</html>