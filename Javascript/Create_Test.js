function QuizAccessPassword()
    {
        if(document.getElementById("QuizPassword").hidden===true &&
            document.getElementById("QuizPasswordLabel").hidden===true &&
            document.getElementById("passwordtip").hidden===true)
        {
            document.getElementById("QuizPassword").hidden=false;
            document.getElementById("QuizPasswordLabel").hidden=false;
            document.getElementById("passwordtip").hidden=false;
        }
        if(document.getElementById("PassOnly").checked)
        {
            showTip("passwordtip", true, 500);
            setRequired("QuizPassword", true);
            show("QuizPassword", 600);
            show("QuizPasswordLabel", 600);
        }
        else
        {
            showTip("passwordtip", false, 500);
            setRequired("QuizPassword", false);
            hide("QuizPassword", 600);
            hide("QuizPasswordLabel", 600);
        }
    }

function Attempts()
{
    if(document.getElementById("AttemptCount").hidden===true &&
        document.getElementById("AttempCountLabel").hidden===true &&
        document.getElementById("attemptstip").hidden===true)
    {
        document.getElementById("AttemptCount").hidden=false;
        document.getElementById("AttempCountLabel").hidden=false;
        document.getElementById("attemptstip").hidden=false;
    }
    if(document.getElementById("Attemps").checked)
    {
        showTip("attemptstip", true, 500);
        setRequired("AttemptCount", true);
        show("AttemptCount", 600);
        show("AttempCountLabel", 600);
    }
    else
    {
        showTip("attemptstip", false, 500);
        setRequired("AttemptCount", false);
        hide("AttemptCount", 600);
        hide("AttempCountLabel", 600);
    }
}

function TimeLimit()
{
    if(document.getElementById("QuizTimeLimit").hidden===true &&
        document.getElementById("QuizTimeLimitLabel").hidden===true
    )
    {
        document.getElementById("QuizTimeLimit").hidden=false;
        document.getElementById("QuizTimeLimitLabel").hidden=false;
    }
    if(document.getElementById("Timed").checked)
    {
        setRequired("QuizTimeLimit", true);
        show("QuizTimeLimit", 600);
        show("QuizTimeLimitLabel", 600);
    }
    else
    {
        setRequired("QuizTimeLimit", false);
        hide("QuizTimeLimit", 600);
        hide("QuizTimeLimitLabel", 600);
    }
}

function NegativeGrading()
{
    if(document.getElementById("NegGradeLabel").hidden===true &&
        document.getElementById("NegGrade").hidden===true &&
        document.getElementById("neggradetip").hidden===true)
    {
        document.getElementById("NegGradeLabel").hidden=false;
        document.getElementById("NegGrade").hidden=false;
        document.getElementById("neggradetip").hidden=false;
    }
    if(document.getElementById("NegGrading").checked)
    {
        showTip("neggradetip", true, 500);
        setRequired("NegGrade", true);
        show("NegGrade", 600);
        show("NegGradeLabel", 600);
    }
    else
    {
        showTip("neggradetip", false, 500);
        setRequired("NegGrade", false);
        hide("NegGrade", 600);
        hide("NegGradeLabel", 600);
    }
}

function setRequired($id, $condition)
{
    document.getElementById($id).required=$condition;
}

function showTip($id, $condition, $ms)
{
    if($condition===true)
    {
        show($id,$ms);
    }
    else
    {
        hide($id,$ms);
    }
}

$(function()
    {
        $("#wrapper").on("submit","#QuizCF",function(e)
            {
                var dataString = $(this).serialize();
                // alert(dataString); return false;

                $.ajax(
                    {
                        type: "POST",
                        url: "../PHP/Quizes.php",
                        data: dataString,
                        success: function()
                            {
                                document.getElementById("QuizCF").hidden=true;
                                document.getElementById("QuizCFfieldset").hidden=true;
                                document.getElementById("BackToConfig").hidden=false;
                                document.getElementById("myQuestionsList").hidden=false;
                                document.getElementById("questionsAlreadyInTheQuiz").hidden=false;
                                document.getElementById("submitquiz").hidden=false;
                                appendUserQuestions("myQuestionsList",0);
                                setToUpdate();
                            }
                    });

                e.preventDefault();
            });
    });

$(function()
    {
        $("#myQuestionsList").on("submit","form[id^='addquestion']", function(e)
            {
                var dataString = $(this).serialize();
                // alert(dataString); return false;

                $.ajax(
                    {
                        type: "POST",
                        url: "../PHP/DatabaseQueries/addQuestionToQuiz.php",
                        data: dataString,
                        success: function ()
                            {
                                appendUserQuestions("myQuestionsList",0);
                                appendUserUsedQuestions("questionsAlreadyInTheQuiz",0);
                            }
                    });
                e.preventDefault();
            });

        $("#questionsAlreadyInTheQuiz").on("submit","form[id^='remove']", function(e)
            {
                var dataString = $(this).serialize();
                // alert(dataString); return false;

                $.ajax(
                    {
                        type: "POST",
                        url: "../PHP/DatabaseQueries/removeQuestionFromQuiz.php",
                        data: dataString,
                        success: function ()
                            {
                                appendUserQuestions("myQuestionsList",0);
                                appendUserUsedQuestions("questionsAlreadyInTheQuiz",0);
                            }
                    });
                e.preventDefault();
            });
    });

function backToConfig()
{
    document.getElementById("QuizCF").hidden=false;
    document.getElementById("QuizCFfieldset").hidden=false;
    document.getElementById("publish").hidden=true;
    document.getElementById("myQuestionsList").hidden=true;
    document.getElementById("questionsAlreadyInTheQuiz").hidden=true;
    document.getElementById("BackToConfig").hidden=true;
    document.getElementById("update").hidden=false;
    document.getElementById("submitquiz").hidden=true;
}
function backToQuizQuestions()
{
    document.getElementById("QuizCF").hidden=true;
    document.getElementById("QuizCFfieldset").hidden=true;
    document.getElementById("BackToConfig").hidden=false;
    document.getElementById("myQuestionsList").hidden=false;
    document.getElementById("questionsAlreadyInTheQuiz").hidden=false;
    document.getElementById("update").hidden=true;
    document.getElementById("submitquiz").hidden=false;
}
function setToUpdate()
    {
        document.getElementById("buttonpressed").value="Update";
    }

function quizCreationForm()
    {
        //show("viewquestion", 500);
        show("QuizCF", 500);
        hide("createquiz",500);
        hide("viewquizes",500);
        hide("myQuizes",500);
    }

function viewQuizes()
    {
        hide("QuizCF", 500);
        //hide("viewquestion", 500);
        hide("viewquizes",500);
        show("myQuizes",500);
        appendRecentQuizes("myQuizes",1);
    }