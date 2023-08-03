
var map = L.map('map', {
   doubleClickZoom: false
});

let userLocation = L.marker([0, 0]).addTo(map).bindPopup('Your exact location.')
   .openPopup();
   
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
   attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

map.locate({
   setView: true,
   timeout: 10000
});

map.on('locationfound', function (e) {
   console.log(123)
   map.setView([e.latlng.lat, e.latlng.lng], 14);
});

map.on('locationerror', function (e) {
   console.error(e.message);
});

map.on('dblclick', function (e) {
   setLocation(e)
})

function setLocation(event) {

   map.setView([event.latlng.lat, event.latlng.lng], map.getZoom());
   map.removeLayer(userLocation)
   userLocation = L.marker([event.latlng.lat, event.latlng.lng]).addTo(map).bindPopup('Your exact location.')
      .openPopup();
   $("#location").val(JSON.stringify({ latitude: event.latlng.lat, longitude: event.latlng.lng }));
}

