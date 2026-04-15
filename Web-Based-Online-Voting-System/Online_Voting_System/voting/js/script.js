
// for menu show
function showMenu()
{
    document.getElementById("menu").style.width="260px";
    document.getElementById("show").style.display="none";
    document.getElementById("hide").style.display="inline-flex";
    document.getElementById("main").style.marginLeft="260px";
}

// for menu hide
function hideMenu()
{
    document.getElementById("menu").style.width="0px";
    document.getElementById("show").style.display="inline-flex";
    document.getElementById("hide").style.display="none";
    document.getElementById("main").style.marginLeft="0px";
}

// for profile panel show
function showProfile()
{
    document.getElementById("profile-panel").style.height="280px";
}

// for profile panel hide
function hidePanel()
{
    document.getElementById("profile-panel").style.height="0px";
}

// Page load animation — add fade-in class to main content
document.addEventListener('DOMContentLoaded', function() {
    var main = document.getElementById('main');
    if (main) {
        main.classList.add('animate-fade-in-up');
    }
    // Close profile panel when clicking outside
    document.addEventListener('click', function(e) {
        var panel = document.getElementById('profile-panel');
        var profile = document.querySelector('.profile');
        if (panel && profile && !panel.contains(e.target) && !profile.contains(e.target)) {
            panel.style.height = '0px';
        }
    });
});
