
//////////////////
/// Appel les carreaux au check ////////////
//////////////////
function demandCarreaux() {
  var data = 'bbox='+map.getBounds().toBBoxString();
  $.ajax({
    url: "ajaxCarreaux.php",
    dataType: "json",
    data : data,
    error: function(xhr, textStatus, error){
        console.log(xhr.statusText);
        console.log(textStatus);
        console.log(error);
    },
    success: recupCarreaux
  });
}

// Imposiblede mettre un style avec L.polygon. Mais L.geoJson ne fonctionne pas (pas de message d'erreur mais ca n'apparait pas).
function getColor(d) {
    return d > 1000 ? '#800026' :
           d > 500  ? '#BD0026' :
           d > 200  ? '#E31A1C' :
           d > 100  ? '#FC4E2A' :
           d > 50   ? '#FD8D3C' :
           d > 20   ? '#FEB24C' :
           d > 10   ? '#FED976' :
                      '#FFEDA0';
}

function style(feature) {
    return {
        fillColor: getColor(feature.properties.pop),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    };
}

//////////////////
/// Affiche les carreaux au check /////////////////
//////////////////
function recupCarreaux(data) {
    var polygon = [];
    var checkCarreaux = document.getElementById('carreaux');
    checkCarreaux.addEventListener("click", function () {

      data.forEach(function(data) {
        var polygon = L.polygon(data.geometry.coordinates, {Style: style})

        if (checkCarreaux.checked) {
        //polygon.removeLayer();
        polygon.addTo(map);
        } else {
          map.removeLayer(polygon);
        }

// Permet d'enlever et remettre au drag and drop
          map.on('moveend', function(){
              if (polygon) {
              map.removeLayer(polygon);
              }
              document.getElementById("carreaux").checked = false;
          });

      });
    })
  }
