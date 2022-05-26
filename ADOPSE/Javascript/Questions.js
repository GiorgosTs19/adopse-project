function questioncreationForm()
    {
        show("viewquestion", 500);
        hide("createquestion", 500);
        hide("myQuestions",500);
        show("addAnswer", 500);
        show("removeAnswer", 500);
        showContent();
        var node = document.getElementById("QCF");
        if(main.contains(node))
            {
                show("QCF", 500);
            }
        document.getElementById("success").innerHTML="";
        document.getElementById("error").innerHTML="";
    }

function viewQuestions()
    {
        show("createquestion", 500);
        hide("viewquestion", 500);
        show("myQuestions",500);
        hide("addAnswer", 500);
        hide("removeAnswer", 500);
        appendUserQuestions("myQuestions",-1);
        var node = document.getElementById("QCF");
        if(main.contains(node))
            {
                hide("QCF", 500);
            }
    }

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

function showSelection(value)
    {
        if(value===2)
            {
                document.getElementById("value").
                    innerHTML="This Question type can only have a maximum of 2 possible answers!";
                clearAnswerFields("answersdiv");
                setUpAnswers(value, "answersdiv");
                document.getElementById("answercount").value = "2";
                hide("addAnswer",500);
                hide("removeAnswer",500);
                show("next",500);
            }
        else if (value===4)
            {
                document.getElementById("value").
                    innerHTML="This Question type has by default : " + value + " possible answers!";
                clearAnswerFields("answersdiv");
                setUpAnswers(value, "answersdiv");
                document.getElementById("answercount").value = "4";
                show("addAnswer",500);
                show("removeAnswer",500);
                show("next",500);

            }
        else if (value===5)
            {
                document.getElementById("value").
                    innerHTML="This Question type has by default : " + value + " possible answers!";
                clearAnswerFields("answersdiv");
                setUpAnswers(value, "answersdiv");
                document.getElementById("answercount").value = "5";
                show("addAnswer",500);
                show("removeAnswer",500);
                show("next",500);
            }
        else
            {
                // document.getElementById("value").
                //     innerHTML="This Question type has by default no answer!";
                document.getElementById("value").
                    innerHTML="This Question type is currently unavailable!";
                clearAnswerFields("answersdiv");
                hide("addAnswer",500);
                hide("removeAnswer",500);
                hide("next",500);
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
                        node.setAttribute("required", "true");
                        //Label for the Answer TextBox
                        var label = document.createElement("label");
                        label.innerHTML = "Answer " + counter;
                        label.setAttribute("for","Answer " + counter + " ");
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
                        CorrectL.innerHTML = " Is this the correct answer?";
                        CorrectL.setAttribute("for","Correct");
                        CorrectL.setAttribute("class", "ranswerlabels");

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
                        node.setAttribute("required", "true");
                        //Label for the Answer TextBox
                        var label = document.createElement("label");
                        label.innerHTML = "Answer " + counter;
                        label.setAttribute("for","Answer" + counter+" ");
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
                        CorrectL.innerHTML = " Is this a correct answer?";
                        CorrectL.setAttribute("for","Correct");
                        CorrectL.setAttribute("class", "ranswerlabels");

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
                TrueL.setAttribute("class", "ranswerlabels");

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
                FalseL.setAttribute("class", "ranswerlabels");

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
        const ranswerlabels = document.querySelectorAll('.ranswerlabels');
        ranswerlabels.forEach(label => {label.remove();});
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

function addAnswer()
    {
        if(document.getElementById('multiplechoiceSA').checked)
            {
                currentcount = document.getElementById('answercount').value;
                currentcount++;
                if (currentcount > 3)
                    {
                        show("removeAnswer", 500);
                    }
                currentcount = document.getElementById('answercount').value=currentcount;
                var node = document.createElement("input");
                node.setAttribute("class", "answers");
                node.setAttribute("type", "text");
                node.setAttribute("name", "answer[]");
                node.setAttribute("required", "true");
                //Label for the Answer TextBox
                var label = document.createElement("label");
                label.innerHTML = "Answer " + currentcount;
                label.setAttribute("for","Answer " + currentcount + " ");
                label.setAttribute("class", "answerlabels");
                //Empty Line
                var el = document.createElement("br");
                el.setAttribute("class","empty");
                //Radio Button to determine if this is the correct answer
                var Correct = document.createElement("input");
                Correct.setAttribute("class", "correctradio");
                Correct.setAttribute("type", "radio");
                Correct.setAttribute("id", currentcount);
                Correct.setAttribute("name", "correctanswer[]");
                Correct.setAttribute("value", "True");
                Correct.required = true;
                Correct.setAttribute("onclick", "setTrue(this.id)");
                //Label for the Radio Button mentioned above
                var CorrectL = document.createElement("label");
                CorrectL.innerHTML = " Is this the correct answer?";
                CorrectL.setAttribute("for","Correct");
                CorrectL.setAttribute("class", "ranswerlabels");

                document.getElementById("answersdiv").appendChild(label);
                document.getElementById("answersdiv").appendChild(node);
                document.getElementById("answersdiv").appendChild(CorrectL);
                document.getElementById("answersdiv").appendChild(Correct);
                document.getElementById("answersdiv").appendChild(el);
            }
        else if(document.getElementById('multiplechoiceMA').checked)
            {
                currentcount = document.getElementById('answercount').value;
                currentcount++;
                if (currentcount > 3)
                    {
                        show("removeAnswer", 500);
                    }
                currentcount = document.getElementById('answercount').value=currentcount;
                var node = document.createElement("input");
                node.setAttribute("class", "answers");
                node.setAttribute("type", "text");
                node.setAttribute("name", "answer[]");
                node.setAttribute("required", "true");
                //Label for the Answer TextBox
                var label = document.createElement("label");
                label.innerHTML = "Answer " + currentcount;
                label.setAttribute("for","Answer" + currentcount+" ");
                label.setAttribute("class", "answerlabels");
                //Empty Line
                var el = document.createElement("br");
                el.setAttribute("class","empty");
                //Radio Button to determine if this is the correct answer
                var Correct = document.createElement("input");
                Correct.setAttribute("class", "correctcheck");
                Correct.setAttribute("type", "checkbox");
                Correct.setAttribute("name", `correctcheck${currentcount}`);
                Correct.setAttribute("value", "True");
                Correct.setAttribute("onclick", "checkrequirement()");
                //Correct.setAttribute("onclick", "setTrue(this.id)");
                //Label for the Check Boxes mentioned above
                var CorrectL = document.createElement("label");
                CorrectL.innerHTML = " Is this a correct answer?";
                CorrectL.setAttribute("for","Correct");
                CorrectL.setAttribute("class", "ranswerlabels");

                document.getElementById("answersdiv").appendChild(label);
                document.getElementById("answersdiv").appendChild(node);
                document.getElementById("answersdiv").appendChild(CorrectL);
                document.getElementById("answersdiv").appendChild(Correct);
                document.getElementById("answersdiv").appendChild(el);
            }

    }

    function removeAnswer()
        {
            if(document.getElementById('multiplechoiceSA').checked)
                {
                    currentcount = document.getElementById('answercount').value;
                    currentcount--;
                    currentcount = document.getElementById('answercount').value = currentcount;
                    if (currentcount < 4)
                        {
                            hide("removeAnswer", 1);
                        }

                    label = Array.from(document.querySelectorAll('.answerlabels')).pop();

                    node = Array.from(document.querySelectorAll('.answers')).pop();

                    CorrectL = Array.from(document.querySelectorAll('.ranswerlabels')).pop();

                    Correct = Array.from(document.querySelectorAll('.correctradio')).pop();

                    el = Array.from(document.querySelectorAll('.empty')).pop();

                    CorrectL.remove();
                    Correct.remove();
                    label.remove();
                    node.remove();
                    el.remove();
                }
            else if(document.getElementById('multiplechoiceMA').checked)
                {
                    currentcount = document.getElementById('answercount').value;
                    currentcount--;
                    currentcount = document.getElementById('answercount').value = currentcount;

                    if (currentcount < 4)
                        {
                            hide("removeAnswer", 1);
                        }

                    label = Array.from(document.querySelectorAll('.answerlabels')).pop();

                    node = Array.from(document.querySelectorAll('.answers')).pop();

                    CorrectL = Array.from(document.querySelectorAll('.ranswerlabels')).pop();

                    Correct = Array.from(document.querySelectorAll('.correctcheck')).pop();

                    el = Array.from(document.querySelectorAll('.empty')).pop();

                    CorrectL.remove();
                    Correct.remove();
                    label.remove();
                    node.remove();
                    el.remove();
                }
        }