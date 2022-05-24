<?php
session_start();
?>
<!--<!DOCTYPE html>-->
<!--<html>-->
<!--    <head>-->
<!--        <link href="../../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>-->
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<!--        <script src="../../Javascript/Javascript.js"></script>-->
<!--        <script src="../../Javascript/Javascript.js"></script>-->
<!--    </head>-->
<!--    <body>-->
        <?php
        include_once("../Objects/Question.php");
        include_once("../Objects/Answer.php");
        require_once "../Functions/Functions.php";
        include_once("../Objects/User.php");
        $id = $_SESSION["UserId"];
        $servername = "localhost";
        $dbusername = "adopse";
        $dbpassword = "Adopse@2022";
        $user = new User();
        $user->setID($_SESSION["UserId"]);  
        $user->setName($_SESSION["UserN"]);
        $user->setLastName($_SESSION["UserLN"]);
        $user->setEmail($_SESSION["UserE"]);
        $conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $q = "SELECT id, question, type, topic, idcreator FROM questions WHERE idcreator = ?";
//        $stmt = $GLOBALS['conn']->prepare($q);
//        $stmt->execute([$id]);
//        $results = $stmt->fetchAll();
        if($_GET['id']==0)
            {
                $quizid = selectMaxFromCreator($user->ID,"quizes");
            }
        else if($_GET['id']>0)
            {
                $quizid = $_GET['id'];
                $results = selectQuestionsNotAlreadyInCurrentQuiz($quizid);
            }
        else
            {
                $results = selectAllUserQuestions($user->ID);
            }



        if(empty($results))
            {
                echo "You haven't created any Questions yet !";
            }
        elseif (empty($results) && $_GET['id']>0)
            {
                echo "You have added all your questions to this quiz!";
            }
        else
            {
                foreach ($results as $question)
                    {
                        echo '<div class="questionWrap" id='.$question['id'].'>';
                        echo    '<div class="question Properties">';
                        echo        '<h1>Type : <span>'.$question['type'].'</span></h1>';
                        echo         '<div class="text">';
                        echo            '<h3>Question </h3>';
                        echo            '<span>'.$question['question'].'</span>';
                        echo         '</div>';
                        echo         '<div class="topic">';
                        echo            '<span>Topic : <h2>'.$question['topic'].'</h2></span>';
                        echo         '</div>';
                        echo    '</div>';
                        echo    '<div class="question Answers">';
                        echo        '<div>';
                        echo            '<span>Answers :</span>';
                        echo        '</div>';
                        echo            '<div>';
                        $i=0;

                        foreach (selectQuestionAnswers($question['id']) as $answer)
                            {
                                $i++;
                                echo    '<span>'.$answer['text'].'.</span>';
                                echo    '<h3>'.$answer['correct'].'</h3>';
                            }
                        echo            '</div>';
                        echo    '</div>';

                        if(!$_GET['id']<0)
                            {
                                echo '<form id="addquestion' . $question['id'] . '" action=" " method="post">';
                                echo '<fieldset>';
                                echo '<input type="text" class ="addToThisQuiz" id="addToThisQuiz' . $quizid . '" name = "addToThisQuiz" value="' . $quizid . '" hidden>';
                                echo '<input type="text" class ="thisQuestion" id="thisQuestion' . $question['id'] . '" name = "thisQuestion" value="' . $question['id'] . '" hidden>';
                                echo '<input type="submit" value="Add To Quiz">';
                                echo '</fieldset>';
                                echo '</form>';
                            }
                        else
                            {

                            }
                        echo '</div>';
                }
            }
        ?>
<!--    </body>-->
<!--</html>-->