function showContent()
{
    var main = document.getElementById("ui");
    var temp = document.getElementById("QuestionCreationForm");
    var clon = temp.content.cloneNode(true);
    var node = document.getElementById("QCF");
    if(!main.contains(node))
    {
        main.appendChild(clon);
    }
}

function questioncreationForm()
{
    show("viewquestion", 500);
    hide("createquestion", 500);
    showContent();
    var node = document.getElementById("QCF");
    if(main.contains(node))
    {
        show("QCF", 500);
    }
}
function viewQuestions()
{
    show("createquestion", 500);
    hide("viewquestion", 500);
    var node = document.getElementById("QCF");
    if(main.contains(node))
    {
        hide("QCF", 500);
    }
}

function showSelection(value)
{
    if(value===2)
    {
        document.getElementById("value").
            innerHTML="This Question type can only have a maximum of 2 possible answers!";
        clearAnswerFields("answersdiv");
        setUpAnswers(value, "answersdiv");
        document.getElementById("answercount").value = "2";

    }
    else if (value===4)
    {
        document.getElementById("value").
            innerHTML="This Question type has by default : " + value + " possible answers!";
        clearAnswerFields("answersdiv");
        setUpAnswers(value, "answersdiv");
        document.getElementById("answercount").value = "4";
    }
    else if (value===5)
    {
        document.getElementById("value").
            innerHTML="This Question type has by default : " + value + " possible answers!";
        clearAnswerFields("answersdiv");
        setUpAnswers(value, "answersdiv");
        document.getElementById("answercount").value = "5";
    }
    else
    {
        document.getElementById("value").
            innerHTML="This Question type has by default no answer!";
        clearAnswerFields("answersdiv");
    }

}

function setUpAnswers(count, containerid)
{
    // container = document.getElementById("containerid");
    if(count===4)
    {
        var counter = 1;
        for(var i=0;i<count;i++)
        {
            //Answer TextBox
            var node = document.createElement("input");
            node.setAttribute("class", "answers");
            node.setAttribute("type", "text");
            node.setAttribute("name", "answer[]");
            //Label for the Answer TextBox
            var label = document.createElement("label");
            label.innerHTML = "Answer " + counter;
            label.setAttribute("for","Answer" + counter+"");
            label.setAttribute("class", "answerlabels");
            //Empty Line
            var el = document.createElement("br");
            el.setAttribute("class","empty");
            //Radio Button to determine if this is the correct answer
            var Correct = document.createElement("input");
            Correct.setAttribute("class", "correctradio");
            Correct.setAttribute("type", "radio");
            Correct.setAttribute("id", i);
            Correct.setAttribute("name", "correctanswer[]");
            Correct.setAttribute("value", "True");
            Correct.required = true;
            Correct.setAttribute("onclick", "setTrue(this.id)");
            //Label for the Radio Button mentioned above
            var CorrectL = document.createElement("label");
            CorrectL.innerHTML = "Is this the correct answer?";
            CorrectL.setAttribute("for","Correct");
            CorrectL.setAttribute("class", "answerlabels");

            document.getElementById(containerid).appendChild(label);
            document.getElementById(containerid).appendChild(node);
            document.getElementById(containerid).appendChild(CorrectL);
            document.getElementById(containerid).appendChild(Correct);
            document.getElementById(containerid).appendChild(el);
            counter++;
        }
    }
    else if(count===5)
    {
        var counter = 1;
        for(var i=0;i<count;i++)
        {
            //Answer TextBox
            var node = document.createElement("input");
            node.setAttribute("class", "answers");
            node.setAttribute("type", "text");
            node.setAttribute("name", "answer[]");
            //Label for the Answer TextBox
            var label = document.createElement("label");
            label.innerHTML = "Answer " + counter;
            label.setAttribute("for","Answer" + counter+"");
            label.setAttribute("class", "answerlabels");
            //Empty Line
            var el = document.createElement("br");
            el.setAttribute("class","empty");
            //Radio Button to determine if this is the correct answer
            var Correct = document.createElement("input");
            Correct.setAttribute("class", "correctcheck");
            Correct.setAttribute("type", "checkbox");
            Correct.setAttribute("name", `correctcheck${i}`);
            Correct.setAttribute("value", "True");
            Correct.setAttribute("onclick", "checkrequirement()");
            //Correct.setAttribute("onclick", "setTrue(this.id)");
            //Label for the Check Boxes mentioned above
            var CorrectL = document.createElement("label");
            CorrectL.innerHTML = "Is this a correct answer?";
            CorrectL.setAttribute("for","Correct");
            CorrectL.setAttribute("class", "answerlabels");

            document.getElementById(containerid).appendChild(label);
            document.getElementById(containerid).appendChild(node);
            document.getElementById(containerid).appendChild(CorrectL);
            document.getElementById(containerid).appendChild(Correct);
            document.getElementById(containerid).appendChild(el);
            counter++;
        }
    }
    else if(count===2)
    {
        var True = document.createElement("input");
        True.setAttribute("class", "answers");
        True.setAttribute("type", "radio");
        True.setAttribute("name", "radioanswer");
        True.setAttribute("value", "True");
        True.setAttribute("id", 0);
        True.setAttribute("onclick", "setTrue(this.id)");

        var TrueL = document.createElement("label");
        TrueL.innerHTML = "True";
        TrueL.setAttribute("for","True");
        TrueL.setAttribute("class", "answerlabels");

        var False = document.createElement("input");
        False.setAttribute("class", "answers");
        False.setAttribute("type", "radio");
        False.setAttribute("name", "radioanswer");
        False.setAttribute("id", 1);
        False.setAttribute("onclick", "setTrue(this.id)");
        False.setAttribute("value", "False");
        False.required = true;

        var FalseL = document.createElement("label");
        FalseL.innerHTML = "False";
        FalseL.setAttribute("for","False");
        FalseL.setAttribute("class", "answerlabels");

        var el1 = document.createElement("br");
        var el2 = document.createElement("br");
        el1.setAttribute("class","empty");

        document.getElementById(containerid).appendChild(TrueL);
        document.getElementById(containerid).appendChild(True);
        document.getElementById(containerid).appendChild(el1);
        document.getElementById(containerid).appendChild(FalseL);
        document.getElementById(containerid).appendChild(False);
    }
}

function clearAnswerFields(containerid)
{
    const answers = document.querySelectorAll('.answers');
    answers.forEach(answer => {answer.remove();});
    const answerlabels = document.querySelectorAll('.answerlabels');
    answerlabels.forEach(label => {label.remove();});
    const emptlines = document.querySelectorAll('.empty');
    emptlines.forEach(empty => {empty.remove();});
    const radios = document.querySelectorAll('.correctradio');
    radios.forEach(radio => {radio.remove();});
    const checkboxes = document.querySelectorAll('.correctcheck');
    checkboxes.forEach(checkbox => {checkbox.remove();});
}

function setTrue(id)
{
    const radios = document.querySelectorAll('.correctradio');
    radios.forEach(radio => {radio.value="False";});
    document.getElementById(id).value="True";
    document.getElementById("correctanswerid").value=id;
}

var CheckBoxes = new Array();

function checkrequirement()
{
    var i=0;
    const checkboxes = document.querySelectorAll('.correctcheck');
    checkboxes.forEach
    (
        checkbox =>
        {
            if(checkbox.checked)
            {
                i=i+1;
                if(i>=2)
                {
                    checkboxes.forEach(checkbox => {checkbox.required = false;});

                }
                else
                {
                    checkboxes.forEach(checkbox => {checkbox.required = true;});
                }
            }
        }
    );
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

function appendUserQuestions()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            document.getElementById("myQuestionsList").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","../PHP/GET/UserQuestions.php",true);
    xmlhttp.send();
}

$(function()
{
    $("#QuizCF").on("submit",function(e)
        {
            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax(
                {
                    type: "POST",
                    url: "../PHP/Create_Test.php",
                    data: dataString,
                    success: function()
                    {
                        document.getElementById("QuizCF").hidden=true;
                        document.getElementById("BackToConfig").hidden=false;
                        document.getElementById("myQuestionsList").hidden=false;
                        document.getElementById("submitquiz").hidden=false;
                        appendUserQuestions();
                        setToUpdate();
                    }
                });

            e.preventDefault();
        });
});

$(function()
{
    $("#myQuestionsList").on("submit","form[id^='addtoquestion']", function(e)
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
                    appendUserQuestions();
                }
            });
        e.preventDefault();
    });
});

function backToConfig()
{
    document.getElementById("QuizCF").hidden=false;
    document.getElementById("publish").hidden=true;
    document.getElementById("myQuestionsList").hidden=true;
    document.getElementById("BackToConfig").hidden=true;
    document.getElementById("update").hidden=false;
    document.getElementById("submitquiz").hidden=true;
}
function backToQuizQuestions()
{
    document.getElementById("QuizCF").hidden=true;
    document.getElementById("BackToConfig").hidden=false;
    document.getElementById("myQuestionsList").hidden=false;
    document.getElementById("update").hidden=true;
    document.getElementById("submitquiz").hidden=false;
}
function setToUpdate()
    {
        document.getElementById("buttonpressed").value="Update";
    }