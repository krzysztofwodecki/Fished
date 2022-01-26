const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const photo = urlParams.get('photo');

const score = document.getElementById('grade');
const argumentation_title = document.getElementById('argHeader');
const argumentation = document.getElementById('argumentation');

fetch("/getScoreDetails?photo=" + photo, {
    method: "GET"
}).then(function (response) {
    return response.json();
}).then(function(scoreDetails) {
    addDetails(scoreDetails);
});

function addDetails(details) {
    score.innerText = details['score'] !== null ? details['score'] : "-----";
    argumentation.innerText = details['argumentation'];

    if(details['argumentation'] !== null) {
        argumentation_title.classList.add("visible");
        argumentation.classList.add("visible");

        argumentation_title.classList.remove("hidden");
        argumentation.classList.remove("hidden");
    }
}