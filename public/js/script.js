// Hamburger Menu in Responsive

let menu = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbarr');

menu.onclick = () => {
	menu.classList.toggle('bx-x');
	navbar.classList.toggle('open');
};

window.onscroll = () => {
	menu.classList.remove('bx-x');
	navbar.classList.remove('open');
};



// MODAL

$(document).ready(function() {
    if(localStorage.getItem('popState') != 'shown'){
        $("#once-popup").delay(1000).fadeIn();
        localStorage.setItem('popState','shown')
    }


    $('#popup-close').click(function(e) // You are clicking the close button
    {
    $('#once-popup').fadeOut(); // Now the pop up is hiden.
    });
    $('#once-popup').click(function(e) 
    {
    $('#once-popup').fadeOut(); 
    });
});


