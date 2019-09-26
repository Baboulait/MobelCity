
//////////////////
// Appel le paneaux de commande ////////////
//////////////////
function askForCommando() {
	var data='bbox='+ map.getBounds().toBBoxString();
	$.ajax({
		url: 'testpaulapres.php',
		dataType: 'json',
		data: data,
    error: function(xhr, textStatus, error){
        console.log(xhr.statusText);
        console.log(textStatus);
        console.log(error);
    },
		success: affichePoints
	});

}

//////////////////
// Affiche les carreaux avec le panneau //////////
//////////////////
function affichePoints (points){
    for (var i = 0; i < points.length; i++) {
      points[i]["type"] = "Feature";
		  points[i]["properties"] = points[i]["fields"];
      tableau[i] = points[i];
    }

    var cats = [];
    for (var i = 0; i < tableau.length; i++) {
      var cat = getCat(cats, tableau[i].groupe);
      if (cat === undefined) {
        cat = {
          "interestPoints" : createInterestPoints(),
          "id" : "cat" + i,
          "groupe" : tableau[i].groupe
        }
        cats.push(cat);
      }
      cat["interestPoints"].addData(tableau[i]);
    }


  var command = L.control({position: 'topright'});
  command.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'command');
    for (var i = 0; i < cats.length; i++) {
      div.innerHTML += '<form><input id="' + cats[i]["id"] + '" type="checkbox"/>' + cats[i]["groupe"] + '</form>';
    }
    return div;
  };

  //Ca marche c'est pas mmal
  if (commande) {
  commande.removeFrom(map);
  }
  commande = command.addTo(map);

  for (var i = 0; i < cats.length; i++) {
    var categorie = document.getElementById(cats[i]["id"]);
    categorie.addEventListener("click",handleCommand, false);
  }

  function handleCommand() {
    var selectedCat;
    for (var i = 0; i < cats.length; i++) {
      if (cats[i]["id"] === this.id) {
        selectedCat = cats[i];
        break;
      }
    }
    if (this.checked) {
      selectedCat["interestPoints"].addTo(map);
    } else {
      map.removeLayer(selectedCat["interestPoints"]);
    }

    map.on('moveend', function(){
				askForCommando();
        if (selectedCat["interestPoints"]) {
        map.removeLayer(selectedCat["interestPoints"]);
        }
    });
  } // Fin handleCommand

  function getCat(cats, cat) {
    for (var i = 0; i < cats.length; i++) {
      if (cats[i]["groupe"] === cat) {
        return cats[i];
      }
    }
    return ;
  }

  function createInterestPoints () {

    return new L.geoJson([], {
			pointToLayer: function(feature, latlng) {
				var smallIcon = L.icon({
                iconUrl: getIcon(feature.groupe),
                //shadowUrl: 'icon-shadow.png',
                iconSize:     [33, 44], // taille de l'icone
                //shadowSize:   [50, 64], // taille de l'ombre
                iconAnchor:   [16, 44], // point de l'icone qui correspondra à la position du marker
                //shadowAnchor: [32, 64],  // idem pour l'ombre
                popupAnchor:  [-3, -76] // point depuis lequel la popup doit s'ouvrir relativement à l'iconAnchor
            });
            return L.marker(latlng, {icon: smallIcon});

			},
      onEachFeature: function (feature, layer) {
        var html = '';
        if (feature.nom) {
          html += '<b>' + feature.nom + '</b></br>';
        }
        if (feature.groupe) {
          html += '<b>' + feature.groupe + '</b></br>';
        }
        if (feature.fclass) {
          html += '<b>' + feature.fclass + '</b></br>';
        }
        if (feature.typeborne) {
          html += '<b>' + feature.typeborne + '</b></br>';
        }
        if (feature.tempsmoy) {
          html += '<b>' + feature.tempsmoy + '</b></br>';
        }
        layer.bindPopup(html);
      }
    });
  }

  }

//////////////////
///
