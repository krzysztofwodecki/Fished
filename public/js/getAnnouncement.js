const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const announcementTitle = urlParams.get('announcementTitle');
const announcementDate = urlParams.get('announcementDate');

const image = document.getElementById('image');
const content = document.getElementById('content');
const attachment = document.getElementById('attachment');
const label = document.getElementById('label');

fetch("/getAnnouncementDetails?announcementTitle=" + announcementTitle +
    "&announcementDate=" + announcementDate, {
    method: "GET"
}).then(function (response) {
    return response.json();
}).then(function(announcementDetails) {
    addDetails(announcementDetails);
});

function addDetails(details) {
    image.src = '/public/uploads/' + details['photo'];
    content.innerText = details['details'];
    attachment.href = '/public/uploads/' + details['att'];
    attachment.innerText = details['att'];
    label.classList.add("visible");
    label.classList.remove("hidden");

}