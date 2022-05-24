$(function()
    {
        var xmlhttp = new XMLHttpRequest();
        var quizid = document.getElementById("fetchQuizID").value;
        xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                    {
                        document.getElementById("content").innerHTML = this.responseText;
                    }
            };
        xmlhttp.open("GET","http://localhost/ADOPSE/PHP/GET/getQuiz.php?id="+quizid,true);
        xmlhttp.send();
    });

$(function()
    {
        $("#content").on("submit","#startquizform",function(e)
            {
                var dataString = $(this).serialize();
                // alert(dataString); return false;
                var firstquestion = document.getElementById("firstquizquestion").value;
                $.ajax(
                    {
                        type: "POST",
                        url: "http://localhost/ADOPSE/PHP/startQuiz.php",
                        data: dataString,
                        success: function()
                            {
                                hide("quizintroinfo",500);
                                fetchQuestion(firstquestion);
                                countdown(document.getElementById("timeLimit").value,0);
                                show("quizrightnav",500);
                                Navigation();
                            }
                    });
                e.preventDefault();
            });

        $("#wrapper").on("submit","#submitAnswer",function(e)
            {
                var dataString = $(this).serialize();
                var selection = document.getElementById("buttonPressed").value;
                 $.ajax(
                     {
                         type: "POST",
                          url: "http://localhost/ADOPSE/PHP/DatabaseQueries/appendAnswer.php",
                          data: dataString,
                          success: function()
                              {
                                 hide("quizintroinfo",500);

                                 if(selection==="")
                                     {

                                     }
                                else if(selection == 0)
                                    {
                                        fetchQuestion(document.getElementById("previousQuestion").value);
                                    }
                                else if (selection == 1)
                                    {
                                        fetchQuestion(document.getElementById("nextQuestion").value);
                                    }
                              }
                    });
                  e.preventDefault();
            });


        $('.grid-element').on("click",function()
            {
                $('#submitAnswer').trigger("submit");
                this.click();
            });
    });

function fetchQuestion(quid)
    {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                    {
                        hide("preview-grade",500);
                        show("clear",500);
                        show("quizrightnav",500);
                        document.getElementById("clear").innerHTML = this.responseText;
                    }
            };
        xmlhttp.open("GET","http://localhost/ADOPSE/PHP/GET/getQuestion.php?quid="+quid,true);
        xmlhttp.send();
    }

function Navigation()
    {
        var xmlhttp = new XMLHttpRequest();
        var quizid = document.getElementById("fetchQuizID").value;
        xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                    {
                        document.getElementById("qnav").innerHTML = this.responseText;
                    }
            };
        xmlhttp.open("GET","http://localhost/ADOPSE/PHP/GET/setNavigation.php?navquizid="+quizid,true);
        xmlhttp.send();
    }

function countdown(minutes, seconds)
    {
        interval = setInterval(function()
            {
                var el = document.getElementById("timer");
                if(seconds === 0)
                    {
                        if(minutes === 0)
                            {
                                el.innerHTML = "countdown's over!";
                                alert("countdown's over!");
                                clearInterval(interval);
                                return;
                            }
                        else
                            {
                                minutes--;
                                seconds = 60;
                            }
                    }
                if(minutes > 0)
                    {
                        var minute_text = minutes + (minutes > 1 ? ' minutes' : ' minute');
                    }
                else
                    {
                        document.getElementById("clear").innerHTML = "<h1>Your Answers have been submitted.<br>Your grades will be announced soon</h1>";
                    }
                var second_text = seconds > 1 ? 'seconds' : 'second';
                el.innerHTML = minute_text + ' ' + seconds + ' ' + second_text + ' remaining';
                document.title = minute_text + ' ' + seconds + ' ' + second_text + ' remaining';
                seconds--;
            }, 1000);
    }


function addMinutes(numOfMinutes, date = new Date())
    {
        date.setMinutes(date.getMinutes() + numOfMinutes);
        return date;
    }
function setSelection(selection)
        {
            document.getElementById("buttonPressed").value=selection;
        }

    window.onbeforeunload = function(event)
        {
            return confirm("Confirm refresh");
        };

function previewAnswersSubmitted()
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                    {
                        document.getElementById("previewAnswers").innerHTML = this.responseText;
                        hide("clear",25);
                        hide("quizrightnav",25);
                        show("preview-grade",1000);
                    }
            };
        xmlhttp.open("GET","http://localhost/ADOPSE/PHP/GET/answerPreview.php?preview="+"1",true);
        xmlhttp.send();
    }

function finishAttempt()
    {
        if (confirm("Your attempt will be submitted!") == true)
            {
                hide("quizrightnav",25);
                hide("preview-grade",25);
                show("clear",100);
                document.getElementById("clear").innerHTML = "<h1>Your Answers have been submitted.<br>Your grades will be announced soon.</h1>";
                window.history.forward();
                function noBack()
                    {
                        window.history.forward();
                    }
            }

    }