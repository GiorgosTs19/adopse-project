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
        require_once ("../Functions/Functions.php");
        require_once ("../Functions/QuizFunctions.php");
        include_once("../Objects/User.php");
        $id = $_SESSION["UserId"];
        require_once "../database.php";
        $user = new User();
        $user->setID($_SESSION["UserId"]);  
        $user->setName($_SESSION["UserN"]);
        $user->setLastName($_SESSION["UserLN"]);
        $user->setEmail($_SESSION["UserE"]);
        $conn = getConnection();
//        $q = "SELECT id, question, type, topic, idcreator FROM questions WHERE idcreator = ?";
//        $stmt = $GLOBALS['conn']->prepare($q);
//        $stmt->execute([$id]);
//        $results = $stmt->fetchAll();
        if($_GET['id']==0)
            {
                $quizid = selectMaxFromCreator($user->ID,"quizes");
                $results = selectQuestionsNotAlreadyInCurrentQuiz($quizid);
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
                        echo        '<h1>'.$question['question'].'</h1>';
                        echo            '<span>'.getQuestionType($question['type']).'</span>';
                        echo         '<div class="topic">';
                        echo            '<br>';
                        echo            '<span>Topic : '.$question['topic'].'</span>';
                        echo         '</div>';
                        echo         '<div class="text">';
                        echo            '<br>';
                        echo         '</div>';
                        echo    '</div>';
                        echo    '<div class="question Answers">';
                        echo        '<div>';
                        echo            '<br>';
                        echo            '<span>Answers :</span>';
                        echo        '</div>';
                        echo            '<div>';
                        $i=0;

                        foreach (selectQuestionAnswers($question['id']) as $answer)
                            {
                                $i++;
                                echo    '<br>';
                                echo    '<p>'.$answer['text'].'. : <span>'.$answer['correct'].'</span></p>';
                                echo    '';
                            }
                        echo            '</div>';
                        echo    '</div>';
                        if($_GET['id']>0 || $_GET['id']==0)
                            {
                                echo '<form id="addquestion' . $question['id'] . '" action=" " method="post">';
                                echo '<fieldset>';
                                echo '<input type="text" class ="addToThisQuiz" id="addToThisQuiz' . $quizid . '" name = "addToThisQuiz" value="' . $quizid . '" hidden>';
                                echo '<input type="text" class ="thisQuestion" id="thisQuestion' . $question['id'] . '" name = "thisQuestion" value="' . $question['id'] . '" hidden>';
                                echo '<input type="submit" id="addtoQuiz" value="Add To Quiz">';
                                echo '</fieldset>';
                                echo '</form>';
                            }
                        echo '</div>';
                }
            }
        ?>
<!--    </body>-->
<!--</html>-->