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
<!--    <link href="../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<!--    <script src="../Javascript/Javascript.js"></script>-->
<!--    <script src="../Javascript/indexJavascript.js"></script>-->
<!--    <link href="../Css/StylesIndex.css" rel="stylesheet" type="text/css" media="screen"/>-->
<!---->
<!--</head>-->
<!--    <body>-->
    <?php
        include_once("../Objects/Question.php");
        include_once("../Objects/Answer.php");
        require_once "../Functions/Functions.php";
        require_once "../Functions/QuizFunctions.php";
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

        if($_GET['self']==0)
            {
                $q = "SELECT * FROM quizes AS t1 
                        JOIN quizattributes t2 ON t1.id = t2.quizid 
                        ORDER BY t1.datetimecreated DESC LIMIT 10;";
                $stmt = $GLOBALS['conn']->prepare($q);
                $stmt->execute();
            }
        else
            {
                $q = "SELECT * FROM quizes AS t1 
                        JOIN quizattributes t2 ON t1.id = t2.quizid WHERE idcreator=?
                        ORDER BY t1.datetimecreated DESC LIMIT 10;";
                $stmt = $GLOBALS['conn']->prepare($q);
                $stmt->execute([$user->ID]);
            }

        $results = $stmt->fetchAll();

        foreach ($results as $quiz)
            {   if($quiz['viewable']==1 && countQuestions($quiz['id'])>0)
                {
                    $isFavorite = isFavorite($user->ID, $quiz['id']);
                    echo '<div class="single_stuff wow fadeInDown">';
                    echo    '<div class="imagewrap">';
                    echo        '<div class="single_stuff_img">';
                    echo            '<img src="../images/questionmarks.png" alt="Italian Trulli" height="531" width="956">';
                    echo            '<div class="middle">';
                    echo                    '<br>';
                    echo                    setStartButton($quiz['id']);
                    echo                    '<br>';
                    echo                    Editable($quiz['idcreator'],$user->ID,$quiz['id']);
                    echo                    '<br>';
                    echo                    Favorite($isFavorite, $quiz['id']);
                    echo            '</div>';
                    echo        '</div>';
                    echo        '<div class="single_stuff_article">';
                    echo            '<div class="single_sarticle_inner">';
                    echo                '<span class="stuff_category" >Created '.time_elapsed_string($quiz['datetimecreated'],true).'</span>';
                    echo                '<br><span class="stuff_category" >'.PasswordOnly($quiz['passonly']).'</span>';
                    echo                    '<div class="stuff_article_inner">' ;
                    echo                       '<span class="stuff_date"><strong>'. $quiz['topic'] .'</strong></span>';
                    echo                        '<br> <span>Question Count : '.countQuestions($quiz['id']).'</span>';
                    echo                        '<h2 onclick="showQuizProperties('.$quiz['id'].')">'.$quiz['title'].'</h2>';
                    echo                        '<p>';
                    echo                            $quiz['sdesc'];
                    echo                        '</p>';
                    echo                    '</div>';
                    echo             '</div>';
                    echo             '<div class="single_sarticle_inner_attributes">';
                    echo                '<br><br> <span>'.Timed($quiz['timed'],$quiz['timelimit']).'</span><br>';
                    echo                '<br> <span>'.ForwardOnly($quiz['forwardonly']).'</span><br>';
                    echo                '<br> <span>'.MultipleAttempts($quiz['multipleattempts'],$quiz['attempts']).'</span><br>';
                    echo                '<br> <span>'.NegativeGrading($quiz['negativegrading']).'</span><br>';
                    echo            '</div>';
                    echo        '</div>';
                    echo     '</div>';
                    echo  '</div>';
                }
            }
        ?>
<!--    </body>-->
<!--</html>-->
