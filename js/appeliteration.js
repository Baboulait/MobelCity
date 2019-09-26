
//////////////////////////////////
// MISE EN PLACE DE LA POND2RATION //
//////////////////////////////////
document.querySelector("select").addEventListener("change", function (){
  if (this.value == "ponderator") {
    document.getElementById('pond').style.display = 'block'; ///Pour afficher la division :

    // disable les boutons
    var radios = document.getElementById('radio').getElementsByTagName('input');
    document.getElementById('Toutes').checked = true;
    for(var i=0;i<radios.length;i++) {
      radios[i].disabled = true;
    }

  } else {
    document.getElementById('pond').style.display = 'none';  //Pour masquer la division :

    // disable les boutons
    var radios = document.getElementById('radio').getElementsByTagName('input');
    for(var i=0;i<radios.length;i++) {
      radios[i].disabled = false;
    }

  }
}, false);


var liste1 = document.getElementById('liste1');
var liste2 = document.getElementById('liste2');
var liste3 = document.getElementById('liste3');
var liste4 = document.getElementById('liste4');
var liste5 = document.getElementById('liste5');
var listchoix = [liste1, liste2, liste3, liste4, liste5];

var pond1 = document.getElementById('pond1');
var pond2 = document.getElementById('pond2');
var pond3 = document.getElementById('pond3');
var pond4 = document.getElementById('pond4');
var pond5 = document.getElementById('pond5');
var listpond = [pond1, pond2, pond3, pond4, pond5];



//////////////////////////////////
// Blocage liste déroulante //
//////////////////////////////////
var idpond = document.getElementById('pond');

var indliste = [];
for (var i = 0; i < liste1.length; i++) {
  indliste.push(liste1[i].value);
}

idpond.addEventListener("change", function (){
/*
  for (var a = 0; a < listchoix.length; a++) {
    console.log(listchoix[a].value);
    if (listchoix[a].value) {
      for (var i = 0; i < document.getElementById('liste1').length; i++) {
        forEach
        if (indliste[a].value == indliste[i].value) {
          indliste[i].disabled = true;
        }
      }
    }
  }
*/
/*
for (var i = 0; i < listchoix.length; i++) {
  for (var a = 0; a < indliste.length; a++) {
    console.log(indliste[i]);
    if (listchoix[i][a]) {
      listchoix[i+1][a+1].disabled = true;
    }
  }
}
*/
}, false);

//////////////////////////////////



$('#envoiborne').on("click", rechercheCarreaux);
$('#envoiborne').on("click", demandirves2);
//////////////////
/// Appel les carreaux avec nombre choisi////////////
//////////////////

function rechercheCarreaux() {
  $('.loader').show(console.log("bonjour")); // <- Loading screen

  var nb_borne = null;
  var data;

  var nb_borne = $('#champ').val();
  var varnbborne = "nb_borne=${nb_borne}";


// Bouton radio
var typebb;
  if (document.getElementById('Toutes').checked) {
   typebb = document.getElementById('Toutes').value;
  }

  if (document.getElementById('Rapides').checked) {
   typebb = document.getElementById('Rapides').value;
  }

  if (document.getElementById('Semi Rapide').checked) {
   typebb = document.getElementById('Semi Rapide').value;
  }

  if (document.getElementById('Lente').checked) {
   typebb = document.getElementById('Lente').value;
  }

  var vartypebb = "typebb=${typebb}";

// Choix + choix perso
// => est ce que les as ne sont pas une mauvaise idée ici ??? je penses que si.
// Ex avec un as :       var crit5 = ", " + liste5.value + ' * ' + pond5.value + ' as ' + liste5.value;
  if (document.getElementById("ponderator").selected == true) {
    if (liste1.value) {
      var crit1 = liste1.value + ' * ' + pond1.value;
    } else {
      crit1 ="";
    };
    if (liste2.value) {
      var crit2 = " , " + liste2.value + ' * ' + pond2.value;
    } else {
      crit2 ="";
    };
    if (liste3.value) {
      var crit3 = " , " + liste3.value + ' * ' + pond3.value;
    } else {
      crit3 ="";
    };
    if (liste4.value) {
      var crit4 =  " , " + liste4.value + ' * ' + pond4.value;
    } else {
      crit4 ="";
    };
    if (liste5.value) {
      var crit5 = " , " + liste5.value + ' * ' + pond5.value;
    } else {
      crit5 ="";
    };
    var choixperso = crit1 + crit2 + crit3 + crit4 + crit5;
    console.log(choixperso);
  } else {
    var liste, choix;
    liste = document.getElementById("choix");
    choix = liste.options[liste.selectedIndex].value;
    console.log(choix);
  }

console.log(choixperso);

// Ajax pour le SQL avec choix perso
if (document.getElementById("ponderator").selected == true) {
  var data = 'bbox='+map.getBounds().toBBoxString();
  $.ajax({
    url: `ajaxiterationCarreaux.php?`+`varnbborne`+"&"+`choix=${choix}`+"&"+`choixperso=${choixperso}`,
    dataType :'json',
    data : data,
    error: function(xhr, textStatus, error){
    console.log(xhr.statusText);
    console.log(textStatus);
    console.log(error);
    },
    success: recupCarreaux2
  });
} else {

// Ajax pour le SQL
  var data = 'bbox='+map.getBounds().toBBoxString();
  $.ajax({
    url: `ajaxiterationCarreaux.php?`+`varnbborne`+"&"+`choix=${choix}`,
    dataType :'json',
    data : data,
    error: function(xhr, textStatus, error){
    console.log(xhr.statusText);
    console.log(textStatus);
    console.log(error);
    },
    success: recupCarreaux2
  });
}

};

//////////////////
/// Affiche le nombre de carreaux voulu/////////////////
//////////////////
  function recupCarreaux2(data) {

  //console.log(data);
  var borne = document.getElementById('champ');
  var borne = Number(borne.value);
  var polygones = [];
  var cotes = [];
  var turfpolygones = [];
  var coords = [];
  var coordo = [];
  var circle = [];
  var selectedcaro = [];
  var listeSelected = [];
  var mauvaisCarreaux = [];
  var careauxpasintersecte = [];
  var listerecup = [];
  var careauxpasintersecte = [];
  var cerclecareauxpasintersecte = [];
  var turfPolyArray = [];

  // IL FAUDRA REMPLACER NBBORNE PAR UN SCORE ET EN METTANT EN DEUXIEME
  //PARAMETRE (AU CAS OU) NBBORNE. Pour l'instant c'est trié en nombre
  //de borne tot mais c'est pas super pck bcp ont le meme nombre de borne tot

  var tri = data;
  console.log(tri);

  // on fait des polygones
  for (var i = 0; i < tri.length; i++) {
    tri[i].geometry.coordinates[4] = tri[i].geometry.coordinates[0];
    coordo = tri[i]["geometry"]["coordinates"];
    turfpolygones[i] = turf.helpers.polygon([coordo]);
    turfpolygones[i]["properties"]["id"] = tri[i]["id"];
    turfpolygones[i]["properties"]["nbborne"] = tri[i]["nbborne"];
    turfpolygones[i]["properties"]["ind_c"] = tri[i]["ind_c"];
    turfpolygones[i]["properties"]["typeborne"] = tri[i]["typeborne"];
    turfpolygones[i]["properties"]["libgeo"] = tri[i]["libgeo"];
    turfpolygones[i]["properties"]["nbnormale"] = tri[i]["nbnormale"];
    turfpolygones[i]["properties"]["nbsemirapi"] = tri[i]["nbsemirapi"];
    turfpolygones[i]["properties"]["nbrapide"] = tri[i]["nbrapide"];
    turfpolygones[i]["properties"]["nbemployer"] = tri[i]["nbemployer"];
    turfpolygones[i]["properties"]["nbempbig"] = tri[i]["nbempbig"];
    turfpolygones[i]["properties"]["nbempmoy"] = tri[i]["nbempmoy"];
    turfpolygones[i]["properties"]["scorebrapide"] = tri[i]["scorebrapide"];
    turfpolygones[i]["properties"]["scoreblente"] = tri[i]["scoreblente"];
    turfpolygones[i]["properties"]["scorebsemi"] = tri[i]["scorebsemi"];
    turfpolygones[i]["properties"]["scoreperso"] = tri[i]["scoreperso"];
  }

  var turfpolygoness = L.geoJson(turfpolygones,{color:'yellow'});
  turfpolygoness.addTo(map);



  // on refait des cercles, mais autour des irves existantes
  var circle2 = [];
  //console.log(bornesactuelles);
  for (var c = 0; c < bornesactuelles.length; c++) {
    var center2 = bornesactuelles[c].geometry.coordinates;
    var radius2 = 0.3;
    var option2= {steps : 33, units : 'kilometers'};
    circle2[c] = turf.circle(center2, radius2, option2);
    //console.log(circle2[c]);
    circle2[c]["properties"]["id"] = bornesactuelles[c]["id"];
  }



  var marker = L.geoJson(circle2,{color:'purple'});
  marker.addTo(map);


  //////////////////
  //  ICI IL FAUT REUSSIR A SUPPRIMER LES CARREAUX QUI SONT DéJA COMPRIT DANS DES BORNES existantes
  //console.log("turfpolygone avant : " + turfpolygones.length);
  //console.log("circle2 avant : " + circle2.length);
  // Si il n'y a pas intersection, on garde pour plus tard -> irves
  for (var i = 0; i < circle2.length; i++) {
    for (var j = 0; j < turfpolygones.length; j++) {
      // si il y a pas intersection
      if (turf.intersect(circle2[i], turfpolygones[j]) == undefined) {
        turfPolyArray.push(turfpolygones[j]);
        //console.log("ok ? ");
      }
    }
    turfpolygones = turfPolyArray;
    turfPolyArray = [];
  }
  var carre = turfpolygones;
  //console.log("carre : " + JSON.stringify(carre));
  //console.log("carre.length : " + carre.length);
  //console.log("turfpolygones : " + JSON.stringify(carre));
  //console.log("turfpolygones.length : "+ carre.length);

  //////////////////



  var markerz = L.geoJson(carre,{color:'orange'});
  markerz.addTo(map);
  //console.log("turfpolygone après : " + carre.length);
  //console.log("circle2 après : " + circle2.length);




  // On fait des cerlces turf
  for (var c = 0; c < carre.length; c++) {
    var center = turf.centroid(carre[c]);
    var radius = 0.3;
    var options = {steps: 33, units: 'kilometers'};
    circle[c] = turf.circle(center, radius, options);
    circle[c]["properties"]["id"] = carre[c]["properties"]["id"];
    circle[c]["properties"]["nbborne"] = carre[c]["properties"]["nbborne"];
    circle[c]["properties"]["ind_c"] = carre[c]["properties"]["ind_c"];
    circle[c]["properties"]["typeborne"] = carre[c]["properties"]["typeborne"];
    circle[c]["properties"]["libgeo"] = carre[c]["properties"]["libgeo"];
    circle[c]["properties"]["nbnormale"] = carre[c]["properties"]["nbnormale"];
    circle[c]["properties"]["nbsemirapi"] = carre[c]["properties"]["nbsemirapi"];
    circle[c]["properties"]["nbrapide"] = carre[c]["properties"]["nbrapide"];
    circle[c]["properties"]["nbemployer"] = carre[c]["properties"]["nbemployer"];
    circle[c]["properties"]["nbempbig"] = carre[c]["properties"]["nbempbig"];
    circle[c]["properties"]["nbempmoy"] = carre[c]["properties"]["nbempmoy"];
    circle[c]["properties"]["scorebrapide"] = carre[c]["properties"]["scorebrapide"];
    circle[c]["properties"]["scoreblente"] = carre[c]["properties"]["scoreblente"];
    circle[c]["properties"]["scoreperso"] = carre[c]["properties"]["scoreperso"];
  }

  //console.log("circle : " + JSON.stringify(circle));
  //console.log("circle.length : " + circle.length);
  //console.log("turfpolygones : " + JSON.stringify(carre));
  //console.log("turfpolygones.length : "+ carre.length);





  //Début de la boucle, on tourne sur le choix de l'utilisateur
    for (var d = 0; d < borne; d++) {
      //console.log("bonjour");

      // Deuxième boucle, on tourne sur le nombre de carreaux
      var careauxpasintersecte = [];
      var cerclecareauxpasintersecte = [];
        for (var e = 0; e < carre.length; e++) {

        // Si il n'y a pas intersection, on garde pour plus tard -> polygones
          if (turf.intersect(circle[d], carre[e]) == undefined) { // si il y a pas une intersection
          careauxpasintersecte.push(carre[e]);
          cerclecareauxpasintersecte.push(circle[e]);
          //console.log("YESS");

        //Si il y a intersection, on garde pas, sauf si c'est le même id, au quel cas on l'affiche
        } else {

          // Si le carreaux et le cercle ont le même ID, alors on l'affiche
          if (carre[e]["properties"]["id"] == circle[d]["properties"]["id"]) {
            selectedcaro.push(carre[e]); // array.push
            //console.log("selectedCarreaux : " + JSON.stringify(selectedcaro));
            //console.log("selectedCarreaux.length : " + selectedcaro.length);
          }
        }
      }
    circle = cerclecareauxpasintersecte;
    carre = careauxpasintersecte;
  }

  var carreauxchoisi = L.geoJson(selectedcaro, {color : 'blue'});
  carreauxchoisi.addTo(map);
  console.log(selectedcaro);

  //turfpolygones.forEach(function(turfpolygones) {
  //  L.geoJson(turfpolygones, {color: 'red'}).addTo(map);
  //  });





  /////////////
  // Permet d'enlever et remettre au drag and drop
  map.on('moveend', function(){
  if (carreauxchoisi) {
  map.removeLayer(carreauxchoisi);
  }
  });
  ////////////



  console.log("fini");

  loader();
};

function loader (){
  $('.loader').hide();  //<--- hide again
};
