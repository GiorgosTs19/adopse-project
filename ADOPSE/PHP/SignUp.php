<?php
session_start();
?>
<html>
    <?php
        require_once "Functions/Functions.php";
        include_once("DatabaseConnection.php");
            $conn = DatabaseConnection::connect();
            $eError = "This Field is Required";
            $nameErr = $lnameErr = $emailErr = $pass1Err = $pass2Err = $passdmErr = $Success = $genError = "";
            $name = $email = $password2 = $password1 = $lastname = $fpassword = "";
            $nok = $lnok = $eok = $pass1ok = $pass2ok = $passok = false;
            //Οι τιμές των πεδίων που έχουν συμπληρωθεί παραμένουν
            $InLastName = $InName = $InEmail = "";
            $temp2 = $temp3 = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") 
                {
                    if (empty(htmlspecialchars($_POST["name"])))
                        {
                          $nameErr = $eError;
                          $nok = false;
                        } 
                    else 
                        {
                          $name = htmlspecialchars($_POST["name"]);
                          $nok = true;
                          $nameErr = "";
                        }

                    if (empty(htmlspecialchars($_POST["email"])))
                        {
                          $emailErr = $eError;
                          $eok = false;
                        } 
                    else 
                        {
                            $eok = false;
                            if(emailExists(htmlspecialchars($_POST["email"]),$genError))
                                {
                                    $eok = false;
                                    $emailErr = "This Email is already in use";
                                }
                            else
                                {
                                if (!htmlspecialchars(empty($_POST["email"])))
                                    {
                                        $email = htmlspecialchars($_POST["email"]);
                                        $eok = true;
                                    }                                   
                                }
                        }

                    if (empty(htmlspecialchars($_POST["lastname"])))
                        {
                          $lnameErr = $eError;
                          $lnok = false;
                        } 
                    else 
                        {
                          $lname = htmlspecialchars($_POST["lastname"]);
                          $lnok = true;
                          $lnameErr = "";
                        }
                        
                    if (empty(htmlspecialchars($_POST["password1"])))
                        {
                          $pass1Err = $eError;
                          $pass1ok = false;
                                } 
                    else 
                        {
                          $password1 = htmlspecialchars($_POST["password1"]);
                          $pass1ok = true;
                          $pass1Err = "";
                        }

                    if (empty(htmlspecialchars($_POST["password2"])))
                        {
                          $pass2Err = $eError;
                          $pass2ok = false;
                        } 
                    else 
                        {
                          $password2 = htmlspecialchars($_POST["password2"]);
                          $pass2ok = true;
                          $pass2Err = "";
                        }
                        
                    if($pass1ok && $pass2ok)
                        {
                             if (strcmp(htmlspecialchars($password1),htmlspecialchars($password2)))
                                {
                                  $passdmErr = "Passwords do not match";
                                  $passok = false;
//                                  $pass2Err = "";
//                                  $pass1Err = "";
                                } 
                            else 
                                {
                                  $fpassword= htmlspecialchars($_POST["password1"]);
                                  $passdmErr = "";
                                  $passok = true;
                                }
                        }
                            
                    if($passok && $nok &&  $lnok && $eok )   
                        {
                            try
                                {
                                    $q = "INSERT INTO users (name, lname, password, email) VALUES (?, ?, ?, ?);";
                                    $stmt = $conn->prepare($q);
                                    $stmt->execute([$name,$lname, $fpassword, $email]);
                                    $Success = "User $name Successfully Created";
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
                            $InLastName = $lname;
                            $InName = $name;
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
            <fieldset>
                <legend>Create an account</legend>
                <br>
                <br>
                Name *
                <br>
                <input type="text" name="name" required placeholder = "First Name" value="<?= $InName?>"/>
                <br>
                <span class="error"><?php echo $nameErr;?></span>
                <br>
                Last Name *
                <br>
                <input type="text" name="lastname" required  placeholder = "Last Name" value="<?= $InLastName?>"/> 
                <br>
                <span class="error"><?php echo $lnameErr;?></span>
                <br>
                Your Email Address *
                <br>
                <input type="email" name="email" required placeholder = "Enter a valid Email" value="<?= $InEmail?>"/>
                <br>
                <span class="error"><?php echo $emailErr;?></span>
                <br>
                Password *
                <br>
                <input type="password" required placeholder="Enter password" name="password1">  
                <br>
                <span class="error"><?php echo $pass1Err;?></span>
                <br>
                Confirm Password *
                <br>
                <input type="password" required placeholder="Enter password" name="password2"/>
                <br>
                <span class="error"><?php echo $pass2Err;?></span>
                <br>
                <span class="error"> <?php echo $passdmErr;?></span>
                <br>
                <button id="signupButton" type="submit">Create Account</button>
                <br>
                <span class="Success"><?php echo $Success;?></span>
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
        <a href="Login.php">Already have an account? Login.</a>
        <!--<div id="footer">

        </div>-->
    </div>
</div>

    </body>
</html>