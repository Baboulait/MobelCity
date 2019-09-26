//////////////////
/// Appel les IRVES au check ////////////
//////////////////
function demandirves() {
  var data = 'bbox='+map.getBounds().toBBoxString();
  console.log(data);
  $.ajax({
    url: "ajaxirves.php",
    dataType: "json",
    data : data,
    error: function(xhr, textStatus, error){
        console.log(xhr.statusText);
        console.log(textStatus);
        console.log(error);
    },
    success: recupBorne
  });
}

//////////////////
/// Affiche les IRVES au check ////////////////
//////////////////
function recupBorne(data){
  var checkBorne = document.getElementById('irves');
  checkBorne.addEventListener("click", function () {
    data.forEach(function(data) {
      var irves = L.marker(data.geometry.coordinates)
      if (checkBorne.checked) {
        irves.addTo(map);
      } else {
        map.removeLayer(irves);
      }

// Permet d'enlever et remettre au drag and drop
          map.on('moveend', function(){
              if (irves) {
              map.removeLayer(irves);
              }
              document.getElementById("irves").checked = false;
          });

    });
  })
}
