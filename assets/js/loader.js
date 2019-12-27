$('.ui.checkbox')
    .checkbox()
    .first().checkbox({
    onChecked: function () {
        document.querySelector(".ui.disabled.button").className = "ui submit button";
    },
    onUnchecked: function () {
        document.querySelector(".ui.button").className = "ui disabled submit button";
    }
});
$('.ui.dropdown')
    .dropdown()
;
$('.menu .item')
    .tab()
;

if (getCookie("id") === undefined || getCookie("token") === undefined) {
    document.getElementsByClassName("nav-escape").item(0).style.display = "none";
    document.getElementsByClassName("nav-enter").item(0).style.display = "block";
} else {
    document.getElementsByClassName("nav-escape").item(0).style.display = "block";
    document.getElementsByClassName("nav-enter").item(0).style.display = "none";
    document.getElementById("login").innerText = getCookie("login");
}