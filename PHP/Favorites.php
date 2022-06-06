<?php ?>


<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="../Css/Answers.scss" rel="stylesheet" type="text/css" media="seen"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../Javascript/Javascript.js"></script>
    <script src="../Javascript/Favorites.js"></script>
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
                <img src="../images/myQuiz.png" height="100" width="133" /></a>
        </div>

    </div>

    <br>
    <br>

    <!--            Burger Navigation-->
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
        <a href="Logout.php" style="margin-top: 50%">Log Out</a>
    </div>

    <div id="contentbody" class="myquizes">
        <div id="content">
            <span id="CTBurger" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
            <br>
            <h1>Favorites</h1>
            <div class="btn-group">
                <button class="button" id="favQuizes" onclick="viewFavoriteQuizes()" >Favorite Quizes</button>
                <button class="button" id="favQuestions" onclick="" >Favorite Questions</button>
            </div>

            <div id="myQuizModal" class="modal" >
                <div class="modal-content" id="quiz-modal-content">

                </div>
            </div>

            <div id="myFavQuizes" hidden>
            </div>

            <div id="myFavQuestions" hidden>
            </div>
        </div>
    </div>
</body>
</html>
