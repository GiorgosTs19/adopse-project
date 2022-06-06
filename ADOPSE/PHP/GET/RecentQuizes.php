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
        include_once("../DatabaseConnection.php");
        $id = $_SESSION["UserId"];
        $user = new User();
        $user->setID($_SESSION["UserId"]);
        $user->setName($_SESSION["UserN"]);
        $user->setLastName($_SESSION["UserLN"]);
        $user->setEmail($_SESSION["UserE"]);
        $conn = DatabaseConnection::connect();

        if($_GET['self']==0)
            {
                $q = "SELECT * FROM quizes AS t1 
                        JOIN quizattributes t2 ON t1.id = t2.quizid 
                        ORDER BY t1.datetimecreated DESC LIMIT 10;";
                $stmt = $conn->prepare($q);
                $stmt->execute();
            }
//        else if ($_GET['self']==0 && $_GET['fav']==1)
//            {
//                $q = "SELECT * FROM quizes AS t1
//                        JOIN quizattributes t2 ON t1.id = t2.quizid WHERE idcreator=?
//                        ORDER BY t1.datetimecreated DESC LIMIT 10;";
//                $stmt = $conn->prepare($q);
//                $stmt->execute([$user->ID]);
//            }
        else
            {
                $q = "SELECT * FROM quizes AS t1 
                        JOIN quizattributes t2 ON t1.id = t2.quizid WHERE idcreator=?
                        ORDER BY t1.datetimecreated DESC;";
                $stmt = $conn->prepare($q);
                $stmt->execute([$user->ID]);
            }

        $results = $stmt->fetchAll();

//        foreach ($results as $quiz)
//            {
                if($_GET['self']==1)
                    {
//                        echo '<div class="single_stuff wow fadeInDown">';
//                        echo    '<div class="imagewrap">';
//                        echo        '<div class="single_stuff_img">';
//                        echo            '<img src="../images/questionmarks.png" alt="Italian Trulli" height="531" width="956">';
//                        echo            '<div class="middle">';
//                        echo                    '<br>';
//                        echo                    setStartButton($quiz['id']);
//                        echo                    '<br>';
//                        echo                    Editable($quiz['idcreator'],$user->ID,$quiz['id']);
//                        echo                    '<br>';
//                        echo                    Favorite($isFavorite, $quiz['id']);
//                        echo            '</div>';
//                        echo        '</div>';
//                        echo        '<div class="single_stuff_article">';
//                        echo            '<div class="single_sarticle_inner">';
//                        echo                '<span class="stuff_category" >Created '.time_elapsed_string($quiz['datetimecreated'],true).'</span>';
//                        echo                '<br><span class="stuff_category" >'.PasswordOnly($quiz['passonly']).'</span>';
//                        echo                    '<div class="stuff_article_inner">' ;
//                        echo                       '<span class="stuff_date"><strong>'. $quiz['topic'] .'</strong></span>';
//                        echo                        '<br> <span>Question Count : '.countQuestions($quiz['id']).'</span>';
//                        echo                        '<h2 onclick="showQuizProperties('.$quiz['id'].')">'.$quiz['title'].'</h2>';
//                        echo                        '<p>';
//                        echo                            $quiz['sdesc'];
//                        echo                        '</p>';
//                        echo                    '</div>';
//                        echo             '</div>';
//                        echo             '<div class="single_sarticle_inner_attributes">';
//                        echo                '<br><br> <span>'.Timed($quiz['timed'],$quiz['timelimit']).'</span><br>';
//                        echo                '<br> <span>'.ForwardOnly($quiz['forwardonly']).'</span><br>';
//                        echo                '<br> <span>'.MultipleAttempts($quiz['multipleattempts'],$quiz['attempts']).'</span><br>';
//                        echo                '<br> <span>'.NegativeGrading($quiz['negativegrading']).'</span><br>';
//                        echo            '</div>';
//                        echo        '</div>';
//                        echo     '</div>';
//                        echo  '</div>';
                        echo    '<table class="table table-bordered" id="viewmyquizes-table">';
                        echo    '<thead>';
                        echo    '<tr>';
                        echo    '<th>Run</th>';
                        echo    '<th>Favorite</th>';
                        echo    '<th>Title</th>';
                        echo    '<th>Topic</th>';
                        echo    '<th>Desc</th>';
                        echo    '<th>No Of Questions</th>';
                        echo    '<th>Viewable</th>';
                        echo    '<th>Edit</th>';
                        echo    '<th>Delete</th>';
                        echo    '</tr>';
                        echo    '</thead>';
                        echo    '<tbody>';
                        echo    '<tr>';
                        foreach ($results as $quiz)
                            {
                                $isFavorite = isFavorite($user->ID, $quiz['id']);
                                 echo'<td>'.setStartButton($quiz['id']).'</td>';
                                 echo'<td>'.Favorite($isFavorite, $quiz['id']).'</td>';
                                 echo"<td>".$quiz['title']."</td>";
                                 echo"<td>".$quiz['topic']."</td>";
                                 echo"<td>".$quiz['sdesc']."</td>";
                                 echo'<td>'.countQuestions($quiz['id']).'</td>';//No Of questions
                                 if($quiz['viewable']==1)
                                     {
                                         echo'<td>Yes</td>';
                                     }
                                 else
                                     {
                                         echo'<td>No</td>';
                                     }
                                 echo'<td><img class="editbutton" src="../images/edit_icon.png" onclick="editThisQuizOnQuizes('.$quiz['id'].')" style="width: 40px;height: 40px;"></td>';//No Of questions
                                 echo '<td>'.setDeletionIcon($quiz['id']).'</td>';
                                 echo "</tr>";
                             }

                        echo    '</table>';
                    }
                else
                    {
                        foreach ($results as $quiz)
                            {
                                if($quiz['viewable']==1 && countQuestions($quiz['id'])>3)
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

                    }
//            }
        ?>
<!--    </body>-->
<!--</html>-->
