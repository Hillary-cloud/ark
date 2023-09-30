
var prevScrollpos = window.pageYOffset;

$(window).scroll(function () {
var currentScrollPos = window.pageYOffset;
if (prevScrollpos > currentScrollPos) {
// User is scrolling up, show the bottom navbar
$("#bottom-navbar").slideDown();
} else {
// User is scrolling down, hide the bottom navbar
$("#bottom-navbar").slideUp();
}
prevScrollpos = currentScrollPos;
});
