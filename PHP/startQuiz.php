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

$id = $_SESSION["UserId"];
$servername = "localhost";
$dbusername = "adopse";
$dbpassword = "Adopse@2022";
$conn = new PDO("mysql:host=$servername;dbname=adopse", $dbusername, $dbpassword);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_GET['sqid']))
    {
        $sqid = $_GET['sqid'];
        $_SESSION['cqid']=$sqid;
    }

if(isset($_POST['startquizid']))
    {
        $q3 = "INSERT INTO attempts (userid, quizid) VALUES (?,?)";
        $stmt3 = $conn->prepare($q3);
        $stmt3->execute([$user->ID, $_POST['startquizid']]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="../Css/Styles.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="../Css/StylesIndex.css" rel="stylesheet" type="text/css" media="screen"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../Javascript/Javascript.js"></script>
    <script src="../Javascript/startQuiz.js"></script>
    <script src="../Javascript/CommonFunctions.js"></script>

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

<input type="text" id="fetchQuizID" value="<?php if(isset($sqid)){echo $sqid;} ?>" hidden>
<div id="wrapper">
    <div id="top">
        <div id="logo">
            <a href="index.php">
            <img src="../images/UniversityLogo.jpeg" height="100" width="133" /></a>
        </div>
    </div>

    <div id="content" >

    </div>
</div>
</body>
</html>