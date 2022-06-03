<?php
// Start the session
session_start();
?>
<html>
<?php
require_once "Functions/Functions.php";
require_once "Functions/QuizFunctions.php";
include_once("Objects/User.php");
require_once "database.php";
$conn = getConnection();
$eError = "This Field is Required";
$nameErr = $lnameErr = $emailErr = $pass1Err = $pass2Err = $passdmErr = $Success = $genError = "";
$name = $email = $password2 = $password1 = $lastname = $fpassword = "";
$eok = $pass1ok = $pass2ok = $passok = false;
//Οι τιμές των πεδίων που έχουν συμπληρωθεί παραμένουν
$InLastName = $InName = $InEmail = "";
$temp2 = $temp3 = "";

//User Initialization
$user = new User();
$user->setID($_SESSION["UserId"]);
$user->setName($_SESSION["UserN"]);
$user->setLastName($_SESSION["UserLN"]);
$user->setEmail($_SESSION["UserE"]);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProfile']))
{
    if (!strcmp($_POST["email"], $user->Email))
        {
            $eok = false;
        }
    else
        {
            $eok = false;
            if(emailExists($_POST["email"],$genError))
                {
                    $eok = false;
                    $emailErr = "This Email is already in use";
                }
            else
                {
                    if (!empty($_POST["email"]))
                            {
                                $email = $_POST["email"];
                                $eok = true;
                            }
                }
        }

    if (empty($_POST["password1"]))
        {
            $pass1ok = false;
        }
    else
        {
            if (empty($_POST["password2"]))
                {
                    $pass2Err = $eError;
                    $pass2ok = false;
                }
            else
                {
                    $password1 = $_POST["password1"];
                    $pass1ok = true;
                    $pass1Err = "";

                    $password2 =$_POST["password2"];
                    $pass2ok = true;
                    $pass2Err = "";
                }
        }

    if($pass1ok && $pass2ok)
        {
            if (strcmp($password1,$password2))
                {
                    $passdmErr = "Passwords do not match";
                    $passok = false;
        //                                  $pass2Err = "";
        //                                  $pass1Err = "";
                }
            else
                {
                    $fpassword=$_POST["password1"];
                    $passdmErr = "";
                    $passok = true;
                }
        }

    if($passok && $eok )
        {
            try
                {
                    $q = "UPDATE users SET  password=?, email =? WHERE email=?;";
                    $stmt = $conn->prepare($q);
                    $stmt->execute([$password1, $email, $user->Email]);
                    $Success = "Email and Password Successfully updated.";
                    $user->setEmail($email);
                    $InEmail = "$email";
                }
            catch (Exception $ex)
                {
                    $genError = $ex;
                }
        }
    elseif(!$passok && $eok )
        {
            try
                {
                    $q = "UPDATE users SET  email =? WHERE email=?;";
                    $stmt = $conn->prepare($q);
                    $stmt->execute([$email, $user->Email]);
                    $Success = "Email successfully updated.";
                    $user->setEmail($email);
                    $InLastName = "";
                    $InName = "";
                    $InEmail = "";
                }
            catch (Exception $ex)
                {
                    $genError = $ex;
                }
        }
    elseif($passok && !$eok)
        {
            try
                {
                    $q = "UPDATE users SET  password =? WHERE email=?;";
                    $stmt = $conn->prepare($q);
                    $stmt->execute([$password1, $user->Email]);
                    $Success = "Password successfully updated.";
                    $InLastName = "";
                    $InName = "";
                    $InEmail = "";
                }
            catch (Exception $ex)
                {
                    $genError = $ex;
                }
        }
    else
        {
            $InEmail = $email;
        }
}
?>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../Javascript/Javascript.js"></script>
    <script src="../Javascript/myProfile.js"></script>
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
                <img src="../images/myQuiz.png" height="100" width="133" /></a>        </div>

    </div>




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
            <h1>Your profile</h1>

            <div id="content">

        <!--        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>-->

            <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
                <fieldset>
                    <legend>Edit your profile</legend>
                    <br>
                    <br>
                    Name
                    <br>
                    <input type="text" name="name" placeholder = "First Name" value="<?= $user->Name ?>" disabled>
                    <br>
                    <br>
                    Last Name
                    <br>
                    <input type="text" name="lastname" placeholder = "Last Name" value="<?= $user->LastName ?>" disabled>
                    <br>
                    <br>
                    Your Email Address
                    <br>
                    <input type="email" name="email" placeholder = "Enter a valid Email" value="<?=$user->Email?>">
                    <br>
                    <span class="error"><?php echo $emailErr;?></span>
                    <br>
                    Password
                    <br>
                    <input type="password" id="updatePassword1" placeholder="Enter password" name="password1">
                    <br>
                    <span class="error"><?php echo $pass1Err;?></span>
                    <br>
                    Confirm Password
                    <br>
                    <input type="password" id="updatePassword2" placeholder="Enter password" name="password2" disabled>
                    <br>
                    <span class="error"><?php echo $pass2Err;?></span>
                    <br>
                    <span class="error"> <?php echo $passdmErr;?></span>
                    <br>
                    <input id="UpdateProfileButton" name="updateProfile" type="submit" value="Update">
                    <br>
                    <span class="Success"><?php echo $Success;?></span>
                    <br>
                    <br>
                    <br>
                    <span class="error"> <?php echo $genError;?></span>
                    <!-- comment </br>
                    </br>
                    </br>
                    <span class="error"> <?php echo $temp2;?></span>
                    </br>
                    <span class="error"> <?php echo $temp3;?></span>-->

                </fieldset>
            </form>
    </div>
        </div>
</div>

</body>
</html>