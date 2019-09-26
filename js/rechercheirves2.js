
//////////////////
/// Appel les IRVES ////////////
//////////////////
function demandirves2() {
  var data = 'bbox='+map.getBounds().toBBoxString();
  console.log(data);
  $.ajax({
    url: "ajaxirves2.php",
    dataType: "json",
    data : data,
    error: function(xhr, textStatus, error){
        console.log(xhr.statusText);
        console.log(textStatus);
        console.log(error);
    },
    success: recupBorne2
  });
}

//////////////////
/// Créer les irves ////////////////
//////////////////
function recupBorne2(data){
  for (var i = 0; i < data.length; i++) {
    bornesactuelles[i] = data[i];
  }
}
