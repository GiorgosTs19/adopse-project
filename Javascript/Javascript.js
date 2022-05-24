
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
    document.getElementById("contentbody").style.filter = 'blur(8px)';


}


/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("contentbody").style.filter = 'blur(0px)';
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

