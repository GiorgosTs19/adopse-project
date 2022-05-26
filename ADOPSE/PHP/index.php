<?php
session_start();
if(!$_SESSION["LoggedIn"])
    {
        header("Location: http://localhost/ADOPSE/PHP/Login.php");
    }
?>
<?php 
    require_once "Functions/Functions.php";
    require_once "Functions/QuizFunctions.php";
    include_once("Objects/User.php");
    //User Initialization
    $user = new User();
    $user->setID($_SESSION["UserId"]);  
    $user->setName($_SESSION["UserN"]);
    $user->setLastName($_SESSION["UserLN"]);
    $user->setEmail($_SESSION["UserE"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="../Css/StylesIndex.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="../Css/Answers.scss" rel="stylesheet" type="text/css" media="screen"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../Javascript/Javascript.js"></script>
    <script src="../Javascript/indexJavascript.js"></script>
    <script src="../Javascript/CommonFunctions.js"></script>

    <style>
    .auto-style3 {
    border-style: solid;
    border-width: 2px;
    }

    .auto-style1 {
        text-decoration: none;
    }
    .auto-style2 {
        text-align: center;
    }

    </style>

</head>
<body>
    <div id="wrapper">

        <div id="top">
            <div id="logo">
                <a href="index.php">
                    <img src="../images/UniversityLogo.jpeg" height="100" width="133" /></a>
            </div>
        </div>

        <!-- Trigger/Open The Modal -->

        <!-- The Modal -->
        <div id="myModal" class="modal" >
            <div class="modal-content" id="modal-content">

            </div>
        </div>

        <div class="sidenav" id="mySidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div>
                <a href="myProfile.php"><img src="../images/profile-icon.jpg" alt="Avatar" id="avatar" ></a>
            </div>

            <br>
            <a href="">Profile</a>
            <br>
            <br>
            <a class="active" href="index.php">Home</a>
            <br>
            <br>
            <a href="Questions.php">Questions</a>
            <a href="Quizes.php">My Quizes</a>
            <a href="Logout.php" style="margin-top: 50%">Log Out</a>
        </div>

        <div id="content">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
            <h1>Home Page</h1>
        </div>

        <section id="contentbody">
            <div class="container">
                <div class="row">
                    <div class=" col-sm-12 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="leftbar_content" id="leftbar_content">
                                <h2>Recent Quizes</h2>
                                <div id="recentquizes">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="rightbar_content">
                                <h2>Random exams</h2>
                                <h1> This section is currently not available.</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>