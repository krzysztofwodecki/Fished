const nav = document.querySelector("nav");

const menu = nav.querySelector('div[class="dropdown_menu"]');
const judgeVisible = document.getElementById('creator_visible');

fetch("/checkIfCanCreate", {
    method: "GET"
}).then(function (response) {
    return response.json();
}).then(function (canCreate) {
    judgeVisible.style.display = canCreate ? 'block' : 'none';
});

$(document.body).click(function(e) {
    const $button = $('.add-join-competition');
    const $dropdown_menu = $('.dropdown_menu');

    if(e.target.class !== 'add-join-competition' && !$.contains($button[0], e.target)
        && e.target.class !== 'dropdown_menu' && !$.contains($dropdown_menu[0], e.target))
        menu.style.display = "none";
    else menu.style.display = "flex";
});