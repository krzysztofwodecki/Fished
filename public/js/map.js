mapboxgl.accessToken = 'pk.eyJ1Ijoia296bW96IiwiYSI6ImNreWg5bW96NDIwdWsyd284cmxiZTdwemcifQ.Z7tX9AbaLtRmBQ1L6hWwXw';

const centerPoland = [19.356389, 52.196667];
const path = window.location.pathname;
const method = window.location.search;

const form = document.querySelector("form");
const div = document.querySelector("div");

const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/light-v10',
    center: centerPoland,
    zoom: 5
});

if(path !== "/competition") {
    fetch("/getFisheries", {
        method: "GET"
    }).then(function (response) {
        return response.json();
    }).then(function(fisheries) {
        placeMarkers(fisheries);
    });

    function placeMarkers(places) {
        const fisheryInput =  form.querySelector('input[name="fishery"]');

        for (const feature of places) {
            const el = document.createElement('div');
            el.className = 'marker';

            const marker = new mapboxgl.Marker(el)
                .setLngLat([feature.longitude, feature.latitude])
                .setPopup(
                    new mapboxgl.Popup({ offset: 25 }) // add popups
                        .setHTML(
                            `<h3>${feature.name}</h3>
                         <p>${feature.address}</p>
                         <p>${feature.postal} ${feature.town}</p>`
                        )
                )
                .addTo(map);

            marker.getElement().addEventListener('click', () => {
                fisheryInput.value = feature.id_fisheries;
            });
        }
    }
}

if(path === "/competition") {
    const name = document.getElementById("name").innerHTML;
    const address = document.getElementById("address").innerHTML;
    const postal = document.getElementById("postal").innerHTML;
    const town = document.getElementById("town").innerHTML;
    const long = document.getElementById("longitude").innerHTML;
    const lat = document.getElementById("latitude").innerHTML;

    map.setCenter([long, lat]);
    map.setZoom(11);

    const el = document.createElement('div');
    el.className = 'marker';

    new mapboxgl.Marker(el)
        .setLngLat([long, lat])
        .setPopup(
            new mapboxgl.Popup({ offset: 25 }) // add popups
                .setHTML(
                    `<h3>${name}</h3>
                         <p>${address}</p>
                         <p>${postal} ${town}</p>`
                )
        )
        .addTo(map);
}

if(path !== "/competition" && method === "?action=addFishery") {
    const latitudeInput = form.querySelector('input[name="latitude"]');
    const longitudeInput = form.querySelector('input[name="longitude"]');


    const marker = new mapboxgl.Marker({ draggable: true})
        .setLngLat(centerPoland)
        .addTo(map);

    latitudeInput.value = centerPoland[1];
    longitudeInput.value = centerPoland[0];

    function onDragEnd() {
        const coordinates = JSON.parse(JSON.stringify(marker.getLngLat()));

        latitudeInput.value = coordinates.lat;
        longitudeInput.value = coordinates.lng;
    }

    marker.on('dragend', onDragEnd);
}