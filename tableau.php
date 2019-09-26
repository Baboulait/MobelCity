<script>
function selView(n, litag) {
  var svgview = "none";
  var codeview = "none";
  switch(n) {
    case 1:
      svgview = "inline";
      break;
    case 2:
      codeview = "inline";
      break;
      // add how many cases you need
    default:
      break;
  }

  document.getElementById("onglet1").style.display = svgview;
  document.getElementById("onglet2").style.display = codeview;
  var tabs = document.getElementById("tabs");
  var ca = Array.prototype.slice.call(tabs.querySelectorAll("li"));
  ca.map(function(elem) {
    elem.style.background="#F0F0F0";
    elem.style.borderBottom="1px solid gray"
  });

  litag.style.borderBottom = "1px solid white";
  litag.style.background = "white";
}

function selInit() {
  var tabs = document.getElementById("tabs");
  var litag = tabs.querySelector("li");   // first li
  litag.style.borderBottom = "1px solid white";
  litag.style.background = "white";
}

</script>


<!DOCTYPE html>
<html>
<!-- 	les metadonnees 	-->
  <head>
    <title> Mobelcity</title>
    <style> @import url('test.css'); </style>
    <meta charset="utf-8" />
    <!--API CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
    integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
    crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
     <!--Library -->
     <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
     integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
     crossorigin=""></script>

     <!-- hash et leaflet.js -->
     <script src="leaflet.js" type="text/javascript"></script>
     <script src="leaflet-hash.js" type="text/javascript"></script>

     <!-- Geocoder -->
     <script src="Control.OSMGeocoder.js"></script>
     <link rel="stylesheet" href="Control.OSMGeocoder.css" />

     <!-- jquery -->
     <script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
          <link rel="icon" type="image/png" href="logo.PNG" />
   </head>

  <body>

    <div class="wrapper">

      <header class="header">
        <h1>Mobelcity</h1>
        <p>     L'électromobilité est un question importante aujourd'hui, elle se pose pour de nombreuses raisons, des
               raisons économiques, environnementales, sociétales ... mais les réponses apportées ne sont pas toujours à
               la hauteur des envies et des attentes. Cette application, réalisée en par le Laboratoire AVENUES, en
               collaboration avec l'ADEME, propose d'aider ses utilisateur à localiser des emplacements optimaux pour
               implanter des bornes de recharges pour véhicules électriques. Sont mises à disposition différentes couches
               shape (fichier de forme), qui localisent des points d'intérêts mais également des couches ayant subit des
               traitements statistiques, permettant d'apporter à l'utilisateur une aide statistique, mais également un
               regard de géogrpahe.
         </p>
      </header>

      <div class = "menu" >
        <a href = "index.html" id='page1'> France</a>
        <a href = "CommentCaMarche.html" id='page4'> CommentÇaMarche ? </a>
        <a href = "Explication.php" id='page3'> Explications</a>
        <a href = "tableau.php" id='page2'> Tableaux de données (W.I.P.)</a>
        <a href = "index.html" id='page2'> Exemple sur Compiègne (W.I.P.)</a>
      </div>

      <div class="main">


      <div id ='cartetab'>

        <div id="cache">

          <p> <a action="" href="#tableau" id="tablofermer">Tableau</a> </p> <!-- Permet d'ouvrire le tableau -->

          <?php include('tablo.php'); ?>
        </div>

      </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>


</body>
</html>
