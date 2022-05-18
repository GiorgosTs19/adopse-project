<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link href="../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="../Css/Answers.scss" rel="stylesheet" type="text/css" media="screen"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../Javascript/Javascript.js"></script>
</head>
    <body>
    <?php
        include_once("../Objects/Question.php");
        include_once("../Objects/Answer.php");
        require_once "../Functions.php";
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
        $q = "SELECT id, question, type, topic, idcreator idcreator FROM questions WHERE idcreator = ?";
        $stmt = $GLOBALS['conn']->prepare($q);
        $stmt->execute([$id]);
        $results = $stmt->fetchAll();
        $quizid = selectMaxFromCreator($user->ID,"quizes");

        foreach ($results as $question)
            {
                echo '<div class="single_stuff wow fadeInDown">';
                echo    '<div class="imagewrap">';
                echo        '<div class="single_stuff_img">';
                echo            '<a href="pages/single.html">';
                echo                '<img src="images/questionmarks.png">';
                echo            '</a>';
                echo         '</div>';
                echo         '<div class="single_stuff_article">';
                echo            '<div class="single_sarticle_inner"> 
                                    <a class="stuff_category" href="#">Technology</a>';
                echo                '<div class="stuff_article_inner"> 
                                        <span class="stuff_date">Nov <strong>17</strong></span>';
                echo                   '<h2><a href="pages/single.html">Duis quis erat non nunc fringilla</a></h2>';
                echo                   '<p>
                                            Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, 
                                            egestas imperdiet nulla nisl quis mauris. Suspendisse a pharetra urna. 
                                            Morbi dui lectus, pharetra nec elementum eget, vulputate ut nisi. 
                                            Aliquam accumsan, nulla sed feugiat vehicula...
                                        </p>';
                echo                '</div>';
                echo           '</div>';
                echo         '</div>';
                echo     '</div>';
                echo     '<div>';
                echo        '<input type="button" class="button1" value="Run Exam" />';
                echo        '<input type="button" class="button2" value="Options" />';
                echo     '</div>';
                echo  '</div>';
            }
        ?>
    </body>
</html>