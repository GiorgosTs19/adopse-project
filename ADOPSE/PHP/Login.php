<?php
session_start();
if(isset($_SESSION["LoggedIn"]))
{
    if($_SESSION["LoggedIn"])
        {
            header("Location: http://localhost/ADOPSE/PHP/index.php");
        }

}
?>
<?php 
        require_once "Functions/Functions.php";
        include_once("Objects/User.php");
        include_once("DatabaseConnection.php");

            $conn = DatabaseConnection::connect();
            $eError = "This Field is Required";
            $emailErr =$passErr = $Success = $genError = "";
            $email = $password = "";
            $eok = $passok = false;
            $temp2 = $temp3 = "";
            function setUser($email)
                {
                    $conn = DatabaseConnection::connect();
                    try
                        {                           
                            $q = "SELECT userid, name, lname, email FROM users WHERE email=? LIMIT 1";
                            $stmt = $conn->prepare($q);
                            $stmt->execute([$email]);
                            $results = $stmt->fetch(PDO::FETCH_ASSOC);
                            $_SESSION["UserN"] = $results["name"];
                            $_SESSION["UserLN"] = $results["lname"];
                            $_SESSION["UserId"] = $results["userid"];
                            $_SESSION["UserE"] = $results["email"];
//                            $_SESSION["UserN"] = "Giorgos";
//                            $_SESSION["UserLN"] = "Tsourdiou";  
//                            $_SESSION["UserId"] = "01";  
//                            $_SESSION["UserE"] = "geontsou52@gmail.com";                           
                       } 
                    catch (Exception $ex) {$genError = $ex;}
                }
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
                {
                    if (empty(htmlspecialchars($_POST["email"])))
                        {
                          //$emailErr = $eError;
                          $eok = false;
                        } 
                    else 
                        {
                            $eok = false;
                            if(emailExists(htmlspecialchars($_POST["email"]),$genError))
                                {
                                    $eok = true;
                                    $email = $_POST["email"];
                                    
                                    if (empty(htmlspecialchars($_POST["password"])))
                                        {
                                            //$passErr = $eError;
                                            $passok = false;
                                          } 
                                    else 
                                        {
                                            if(PasswordIsAuthenticated(htmlspecialchars($_POST["password"]),$genError,htmlspecialchars($_POST["email"])))
                                                {
                                                    $password1 = htmlspecialchars($_POST["password"]);
                                                    $passok = true;
                                                    //$passErr = "";
                                                    setUser(htmlspecialchars($_POST["email"]));
                                                    $_SESSION["LoggedIn"] = true;
                                                    $Success = "You have successfully signed in";
                                                    header("Location: http://localhost/ADOPSE/PHP/index.php");
                                                    exit(); 
                                                }
                                            else
                                                {
                                                    $passErr = "The password you’ve entered is incorrect.";
                                                    $passok = true;
                                                }
                                        }
                                }
                            else
                                {
                                    if (!empty(htmlspecialchars($_POST["email"])))
                                        {
                                            $eok = false;
                                            $emailErr = "No user associated with this email was found";
                                        }                                   
                                }
                        }
                }       
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../Javascript/Javascript.js"></script>
    </head>
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
    <body>
        <div id="wrapper">

    <div id="top">

        <div id="logo">
            <a href="index.php">
                <img src="../images/myQuiz.png" height="100" width="133" /></a>
        </div>

    </div>


<!--<div class="sidenav" id="mySidenav">

        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a class="active" href="index.php">Home</a>
        <a href="Questions.php">Questions</a>
        <a href="Exams.html">Exams</a>
        <a href="Contact.html">Contact</a>
        <a href="About.html">About</a>

    </div>-->

    <div id="content">

<!--        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>-->

        <br>
        <form  id="LoginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
            <fieldset>
                <legend>Login in to your Account</legend>
                <br>
                <br>
                <br>
                Your Email Address *
                <br>
                <input type="email" name="email" required placeholder = "Enter a valid Email" />
                <br>
                <span class="error"><?php echo $emailErr;?></span>
                <br>
                <br>
                Password *
                <br>
                <input type="password" required placeholder="Enter password" name="password">  
                <br>
                <span class="error"><?php echo $passErr;?></span>
                <br>
                <br>
                <button id="signupButton" type="submit">Login</button>
                <br>
                <span class="Success"><?php echo $Success;?></span>
                <br>
                <span class="error"> <?php echo $genError;?></span>
            </fieldset>
        </form>
        <a href="SignUp.php">Don't have an account? Sign Up.</a>
    </div>
</div>
    </body>
</html>

