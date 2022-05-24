$(function()
    {
        appendRecentQuizes("recentquizes",0);

        $("#modal-content").on("submit","#QuizUF",function(e)
            {
                var dataString = $(this).serialize();
                // alert(dataString); return false;
                var modal = document.getElementById("myModal");
                $.ajax(
            {
                        type: "POST",
                        url: "../PHP/GET/UpdateQuizConfig.php",
                        data: dataString,
                        success: function()
                            {
                                document.getElementById("modal-content").className="modal-content-success";
                                document.getElementById("modal-content").innerHTML="Configuration Update Successful.";
                                setTimeout(() => { modal.style.display = "none";}, 2500);
                                document.getElementById("content").style.filter = 'blur(0px)';
                                document.getElementById("contentbody").style.filter = 'blur(0px)';
                                appendRecentQuizes("recentquizes",0);
                            }
                    });

                e.preventDefault();
            });
        //Προσθήκη ερωτήσεων στο Edit Quiz Configuration modal
        $("#modal-content").on("submit","form[id^='addquestion']",function(e)
        {
            var dataString = $(this).serialize();
            // alert(dataString); return false;
            var modal = document.getElementById("myModal");
            $.ajax(
                {
                    type: "POST",
                    url: "../PHP/DatabaseQueries/addQuestionToQuiz.php",
                    data: dataString,
                    success: function()
                    {
                        appendUserQuestions("editQuestionsNotUsed", document.getElementById("getQuizID").value);
                        appendUserUsedQuestions("editQuestionsUsed", document.getElementById("getQuizID").value);
                    }
                });

            e.preventDefault();
        });
        //Αφαίρεση ερωτήσεων στο Edit Quiz Configuration modal
        $("#modal-content").on("submit","form[id^='remove']",function(e)
            {
                var dataString = $(this).serialize();
                // alert(dataString); return false;
                var modal = document.getElementById("myModal");
                $.ajax(
                    {
                        type: "POST",
                        url: "../PHP/DatabaseQueries/removeQuestionFromQuiz.php",
                        data: dataString,
                        success: function()
                        {
                            appendUserQuestions("editQuestionsNotUsed", document.getElementById("getQuizID").value);
                            appendUserUsedQuestions("editQuestionsUsed", document.getElementById("getQuizID").value);
                        }
                    });

                e.preventDefault();
            });

    });

