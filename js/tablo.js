
//$('#envoitablo').on("click", appeltablo);

//////////////////
/// Appel les carreaux avec nombre choisi////////////
//////////////////

function appeltablo() {

  var data;

  var data = 'bbox='+map.getBounds().toBBoxString();
  $.ajax({
    url: `tablo.php`,
    dataType :'json',
    data : data,
    error: function(xhr, textStatus, error){
    console.log(xhr.statusText);
    console.log(textStatus);
    console.log(error);
    },
    success: recupCarreaux2
  });

};
