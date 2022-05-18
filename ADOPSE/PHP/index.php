<?php
session_start();
?>
<?php 
    require_once "Functions.php";
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
    <script src="../Javascript/Javascript.js"></script>

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
                <a href="index.html">
                    <img src="UniversityLogo.jpeg" height="100" width="133" /></a>
            </div>
        </div>

        <div class="sidenav" id="mySidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <img src="images/profile-icon.jpg" alt="Avatar" id="avatar">
            <br>
            <a href="">Profile</a>
            <br>
            <br>
            <a class="active" href="index.html">Home</a>
            <br>
            <br>

            <a href="Questions.php">Questions</a>
            <a href="Exams.html">Exams</a>
            <a href="Contact.html">Contact</a>
            <a href="About.html">About</a>
            <a href="" style="margin-top: 50%">Log Out</a>
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
                            <div class="leftbar_content">
                                <h2>Recent Exams</h2>
                                <div class="single_stuff wow fadeInDown">
                                    <div class="imagewrap">

                                    <div class="single_stuff_img">
                                        <a href="pages/single.html">
                                        <img src="images/questionmarks.png">
                                        </a>
                                    </div>
                                        <input type="button" class="button1" value="Run Exam" />
                                        <input type="button" class="button2" value="Options" />

                                    </div>
                                    <div class="single_stuff_article">
                                        <div class="single_sarticle_inner"> <a class="stuff_category" href="#">Technology</a>
                                            <div class="stuff_article_inner"> <span class="stuff_date">Nov <strong>17</strong></span>
                                                <h2><a href="pages/single.html">Duis quis erat non nunc fringilla</a></h2>
                                                <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus,
                                                    egestas imperdiet nulla nisl quis mauris. Suspendisse a pharetra urna.
                                                    Morbi dui lectus, pharetra nec elementum eget, vulputate ut nisi.
                                                    Aliquam accumsan, nulla sed feugiat vehicula...
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single_stuff wow fadeInDown">
                                    <div class="single_stuff_img"> <a href="#"><img src="images/questionmarks.png" alt=""></a> </div>
                                    <div class="single_stuff_article">
                                        <div class="single_sarticle_inner"> <a class="stuff_category" href="#">Technology</a>
                                            <div class="stuff_article_inner"> <span class="stuff_date">Nov <strong>17</strong></span>
                                                <h2><a href="#">Duis quis erat non nunc fringilla</a></h2>
                                                <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a pharetra urna. Morbi dui lectus, pharetra nec elementum eget, vulputate ut nisi. Aliquam accumsan, nulla sed feugiat vehicula...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single_stuff wow fadeInDown">
                                    <div class="single_stuff_img"> <a href="#"><img src="images/questionmarks.png" alt=""></a> </div>
                                    <div class="single_stuff_article">
                                        <div class="single_sarticle_inner"> <a class="stuff_category" href="#">Technology</a>
                                            <div class="stuff_article_inner"> <span class="stuff_date">Nov <strong>17</strong></span>
                                                <h2><a href="#">Duis quis erat non nunc fringilla</a></h2>
                                                <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a pharetra urna. Morbi dui lectus, pharetra nec elementum eget, vulputate ut nisi. Aliquam accumsan, nulla sed feugiat vehicula...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="stuffpost_paginatinonarea wow slideInLeft">
                                    <ul class="newstuff_pagnav">
                                        <li><a class="active_page" href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="rightbar_content">
                                <h2>Random exams</h2>
                                <div class="single_stuff wow fadeInDown">
                                    <div class="single_stuff_img"> <a href="pages/single.html"><img src="images/questionmarks.png" alt=""></a> </div>
                                    <div class="single_stuff_article">
                                        <div class="single_sarticle_inner"> <a class="stuff_category" href="#">Technology</a>
                                            <div class="stuff_article_inner"> <span class="stuff_date">Nov <strong>17</strong></span>
                                                <h2><a href="pages/single.html">Duis quis erat non nunc fringilla</a></h2>
                                                <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a pharetra urna. Morbi dui lectus, pharetra nec elementum eget, vulputate ut nisi. Aliquam accumsan, nulla sed feugiat vehicula...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single_stuff wow fadeInDown">
                                    <div class="single_stuff_img"> <a href="#"><img src="images/questionmarks.png" alt=""></a> </div>
                                    <div class="single_stuff_article">
                                        <div class="single_sarticle_inner"> <a class="stuff_category" href="#">Technology</a>
                                            <div class="stuff_article_inner"> <span class="stuff_date">Nov <strong>17</strong></span>
                                                <h2><a href="#">Duis quis erat non nunc fringilla</a></h2>
                                                <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a pharetra urna. Morbi dui lectus, pharetra nec elementum eget, vulputate ut nisi. Aliquam accumsan, nulla sed feugiat vehicula...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single_stuff wow fadeInDown">
                                    <div class="single_stuff_img"> <a href="#"><img src="images/questionmarks.png" alt=""></a> </div>
                                    <div class="single_stuff_article">
                                        <div class="single_sarticle_inner"> <a class="stuff_category" href="#">Technology</a>
                                            <div class="stuff_article_inner"> <span class="stuff_date">Nov <strong>17</strong></span>
                                                <h2><a href="#">Duis quis erat non nunc fringilla</a></h2>
                                                <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a pharetra urna. Morbi dui lectus, pharetra nec elementum eget, vulputate ut nisi. Aliquam accumsan, nulla sed feugiat vehicula...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="stuffpost_paginatinonarea wow slideInLeft">
                                    <ul class="newstuff_pagnav">
                                        <li><a class="active_page" href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>