
/* Pagination with numbers
// Get the container element
var btnContainer = document.getElementById("pagination");

// Get all buttons with class="btn" inside the container
var btns = btnContainer.getElementsByClassName("btn");

// Loop through the buttons and add the active class to the current/clicked button
for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        if (current.length > 0) {
            current[0].className = current[0].className.replace(" active", "");
        }
        this.className += " active";
    });
}
*/

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.body.style.backgroundColor = "#5F5F5F";


}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.backgroundColor = "#B9B9B9";
}


function hide(id, milis) 
    {
        $(document.getElementById(id)).hide(milis);
    }
function show(id, milis) 
    {
        $(document.getElementById(id)).show(milis);
    }


function CreateExam(){
    const element = document.getElementById("buttons");
    element.remove();
}

var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
document.getElementsByTagName('head')[0].appendChild(script);


/*document.getElementById("content").innerHTML += "<div id=\"main\"><p>Select a general category for your exam.</p>" +
    "             <form onsubmit=\"CreateExam()\">\n" +
    "                <label for=\"subject\">Choose a subject:</label>\n" +
    "                <select name=\"subject\" id=\"subject\">\n" +
    "                    <option value=\"computerscience\">Computer - Science</option>\n" +
    "                    <option value=\"history\">History</option>\n" +
    "                    <option value=\"maths\">Maths</option>\n" +
    "                    <option value=\"geography\">Geography</option>\n" +
    "                </select>\n" +
    "                <br><br>\n" +
    "                <input type=\"submit\" value=\"Submit\">\n" +
    "            </form>" +
    "</div>";*/

//Questions Segment
