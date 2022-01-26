mapboxgl.accessToken = 'pk.eyJ1Ijoia296bW96IiwiYSI6ImNreWg5bW96NDIwdWsyd284cmxiZTdwemcifQ.Z7tX9AbaLtRmBQ1L6hWwXw';

const centerPoland = [19.356389, 52.196667];

const form = document.querySelector("form");
const div = document.querySelector("div");

const name = document.getElementById("name").innerHTML;
const address = document.getElementById("address").innerHTML;
const postal = document.getElementById("postal").innerHTML;
const town = document.getElementById("town").innerHTML;
const long = document.getElementById("longitude").innerHTML;
const lat = document.getElementById("latitude").innerHTML;

const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/light-v10',
    center: centerPoland,
    zoom: 5
});

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