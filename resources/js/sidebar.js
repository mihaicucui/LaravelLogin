window.jQuery = require('jquery');
window.$ = window.$ || jQuery;

$(function () {
    $("#menu-toggle").click(function (e) {
        console.log('entered');
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });


});
