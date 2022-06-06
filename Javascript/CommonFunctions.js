function appendRecentQuizes(destination, self)
    {
        var xmlhttp = new XMLHttpRequest();
        var dest = document.getElementById(destination);
        xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                    {
                        dest.innerHTML = this.responseText;
                    }
            };
        xmlhttp.open("GET","../PHP/GET/RecentQuizes.php?self="+self,true);
        xmlhttp.send();
    }

function showQuizProperties($quizid)
    {

        var modal = document.getElementById("myModal");
        document.getElementById("modal-content").className="modal-content";
        var xmlhttp = new XMLHttpRequest();
        var params = "qid="+$quizid;
        xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                    {
                        document.getElementById("modal-content").innerHTML = this.responseText;
                    }
            };
        xmlhttp.open("GET","../PHP/GET/thisQuizProperties.php"+"?"+params,true);
        xmlhttp.send();


        modal.style.display = "block";
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event)
            {
                if (event.target == modal)
                    {
                        modal.style.display = "none";
                    }
            }
    }

function editThisQuiz(quizid)
    {
        document.getElementById("content").style.filter = 'blur(8px)';
        document.getElementById("contentbody").style.filter = 'blur(8px)';
        var modal = document.getElementById("myModal");
        document.getElementById("modal-content").className="modal-content-update";
        var xmlhttp = new XMLHttpRequest();
        var params = "qid="+quizid;
        xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                    {
                        document.getElementById("modal-content").innerHTML = this.responseText;
                        appendUserQuestions("editQuestionsNotUsed", quizid);
                        appendUserUsedQuestions("editQuestionsUsed", quizid);
                    }
            };
        xmlhttp.open("GET","../PHP/GET/UpdateQuizConfig.php"+"?"+params,true);
        xmlhttp.send();

        modal.style.display = "block";
    }

function deleteThisQuiz(quizid)
    {
        if (confirm("This Quiz and any reference to it will be permanently delete. This action cannot be undone. " +
            "Are you sure you want to delete this quiz?") == true)
            {
                var xmlhttp = new XMLHttpRequest();
                var params = "toRemoveID="+quizid;
                xmlhttp.onreadystatechange = function()
                    {
                        if (this.readyState === 4 && this.status === 200)
                            {
                                appendRecentQuizes("myQuizes",1);
                            }
                    };
                xmlhttp.open("GET","../PHP/DatabaseQueries/deleteQuiz.php"+"?"+params,true);
                xmlhttp.send();
            }
    }

function closeWindow()
    {
        if (confirm("Do you really want to stop editing?") == true)
            {
                document.getElementById("myModal").style.display = "none";
                document.getElementById("content").style.filter = 'blur(0px)';
                document.getElementById("contentbody").style.filter = 'blur(0px)';
            }
        else
            {
                // text = "You canceled!";
            }
    }


function appendUserQuestions(id, quizid)
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                document.getElementById(id).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","../PHP/GET/UserQuestions.php?id="+quizid,true);
        xmlhttp.send();
    }

function appendUserUsedQuestions(id, quizid)
    {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                    {
                        document.getElementById(id).innerHTML = this.responseText;
                    }
            };
        xmlhttp.open("GET","../PHP/GET/QuestionsUsedOnQuiz.php?id="+quizid,true);
        xmlhttp.send();
    }


    function favThisQuiz($quizid)
        {
            var xmlhttp = new XMLHttpRequest();
            var endpoint = "../PHP/GET/favoriteThisQuiz.php";
            var params = "qid="+$quizid;
            var url = endpoint + "?" + params;

            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("FUSubmitButton"+$quizid).innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET",url,true);
            xmlhttp.send();
        }

function unFavThisQuiz($quizid)
    {
        var xmlhttp = new XMLHttpRequest();
        var endpoint = "../PHP/GET/unFavoriteThisQuiz.php"
        var params = "qid="+$quizid;
        var url = endpoint + "?" + params;

        xmlhttp.onreadystatechange = function()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                document.getElementById('FUSubmitButton'+$quizid).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET",url,true);
        xmlhttp.send();
    }

function formatParams( params )
    {
        return "?" + Object
            .keys(params)
            .map(function(key)
            {
                return key+"="+encodeURIComponent(params[key])
            })
            .join("&")
    }

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