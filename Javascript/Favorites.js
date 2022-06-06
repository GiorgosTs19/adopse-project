function viewFavoriteQuizes()
{
    hide("favQuizes", 500);
    //hide("viewquestion", 500);
    hide("myFavQuestions",500);
    show("myFavQuizes",500);
    appendRecentQuizes("myFavQuizes",-1);
}

$(function ()
    {
        $("#myFavQuizes").on("click","[id^='unFavThisQuiz']",function(e)
            {
                viewFavoriteQuizes();
            });
    });