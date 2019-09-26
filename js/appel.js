
var map = new L.Map('carte',{
  center : new L.LatLng( 49.412632, 2.817316 ),
  zoom : 14   /*  ,     // histoire de dire
  maxZoom : 18, //zoom petit
  minZoom : 9 // zoom grand   */
}).setView([ 49.412632, 2.817316 ]); // avec ce L on a accès a toute la bibli lealet.

var lyrOsm = L.tileLayer('http://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '© <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'//  , maxNativeZoom: 12, maxZoom: 15
}).addTo(map);

// Geocoder
var osmGeocoder = new L.Control.OSMGeocoder({placeholder: 'Recherchez un lieu ...'});
map.addControl(osmGeocoder);

L.control.scale(true, false).addTo(map);

// Variables globales
var pointMarker = L.marker(null);
var checkScore = document.getElementById("score");
var tableau = [];
var commande;
var irves;
var variables;
var bornesactuelles = [];



// Au lancement
demandCarreaux();
demandirves();
askForCommando();


// Autre
//map.on('moveend', demandCarreaux);
map.on('moveend', demandirves);
//map.on('moveend', askForCommando);
//map.on('moveend', rechercheCarreaux);
