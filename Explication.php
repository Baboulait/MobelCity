<!DOCTYPE html>
<html>
<!-- 	les metadonnees 	-->
  <head>
    <title> Mobelcity</title>
    <style> @import url('test.css'); </style>
    <meta charset="utf-8" />
    <!--API CSS -->
     <link rel="icon" type="image/png" href="logo.PNG" />
   </head>

  <body>

    <div class="wrapper">

      <header class="header">
        <h1>Mobelcity</h1>
        <p>     L'électromobilité est une question importante aujourd'hui, elle se pose pour de nombreuses raisons, des raisons économiques,
          environnementales, sociétales ... mais les réponses apportées ne sont pas toujours à la hauteur des envies et des attentes. Cette application,
          réalisée en par le Laboratoire AVENUES, en collaboration avec l'ADEME, propose d'aider ses utilisateurs à localiser des emplacements optimaux
          pour implanter des bornes de recharges pour véhicules électriques. Sont mises à disposition différentes couches shape (fichier de forme), qui
          localisent des points d'intérêts mais également des couches ayant subi des traitements statistiques, permettant d'apporter à l'utilisateur une
          aide statistique, mais également un regard de géographe.
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
        <div id="textes">
          <div id= "ligne0">
            <p class="presentation" id="presentation">
              <strong>Présentation</strong> :
              Cette application permet de localiser sur n'importe quelle commune du territoire français et en quelques clics les zones optimales
              d'intégration de bornes de recharge.
              L'utilisateur pourra ensuite procéder à des analyses plus fines sur les zones sélectionnées (analyses des typologies de rues par exemple).
              L'application doit donc être utilisée comme une première approche du territoire et non comme un outil de prise de décision immédiate.


            </p>
          </div>
          <div id="ligne1">
          <p class="explication" id="explication">
            <strong>Explications :</strong>

              <br /> Détail de la sélection de borne :
              <br/> Rapide : Nombre de lieux où l'on reste peu de temps plus important que ceux où l'on reste une longue durée. Et nombre de "lieu d'intérêt" supérieur à la moyenne.
              <br/> Semi-Rapide : Nombre de lieux où l'on reste une durée moyenne (entre 45min et 1h30) plus important.
              <br/> Lente : Nombre de lieux où l'on reste relativement longtemps plus important. Taux d'employés et de logements collectifs supérieur à la moyenne.

              Seront positionnées en priorité :
              - les bornes lentes dans les lieux où la durée de stationnement moyen est supérieure à 6 heures (habitation, zones  d'activités).
              - les bornes semi-rapides dans les lieux où la durée de stationnement moyenne est comprises entre 45 minutes et 1 heures 30 (cinéma, restaurants ...).
              - les bornes rapides dans les lieux où la durée de stationnement moyen est inférieure à 30 minutes.
          </p>
          <p class="explication" id="donnees">
            <strong>Données :</strong>
              <br /> France :  Les données utilisées sont intégralement disponibles en Open Data (Open Data Soft, OpenData.gouv, ....), elles sont
              donc sujettes à vérification, que ce soit pour de la mise à jour ou encore pour des questions d'exhaustivité. Cependant, cet outil se veut comme
               une première lecture du territoire, et non un diagnostic final.
                <br />  Statistiques (population, économie, employés) : Données INSEE (carroyage et base SIRENE).
                <br />  POI : Points Of Interest de OpenStreetMap.
                <br />  IRVES : Fichier consilidé des bornes de recharge pour véhicules électriques de data.gouv.
                <br /> Nous ne pouvons être tenus responsables si les bases de données comportent des erreurs.
          </p>

        </div>
        <div id="ligne2">
          <p class="explication" id="process">
            <strong>Process :</strong> Présentation de la méthodologie de la recherche d'emplacements optimaux.

            <img src="methodologie.PNG" id="photomethodo" >

          </p>
          <p class="explication" id="possi">
            <strong>Possibilités :</strong>
                <br />Filtres : Le filtre permet de sélectionner des critères / indicateurs qui seront pris en compte dans la recherche de localisation optimale. L'influence de ce
                filtre joue sur un tri en amont de la donnée, ce qui permet de sélectionner les espaces où l'indicateur choisi sera le plus élevé.
                <br />Sélections : La sélection du type de borne à implanter permet de faire varier les indicateurs disponibles, afin de proposer les
                pertinents pour la sélection de ce type de borne. Dans le cas ou "Toutes" est sélectionnée, tous les indicateurs sont proposés.
                <br />Affichages : L'Affichage des différents éléments permet de se repérer et d'avoir une vision directe des éléments. L'utilisateur à la
                possibilité d'afficher les POI qui sont présents dans sa zone, les carreaux de l'INSEE sur lesquels sont basés les analyses ainsi que les
                IRVES existantes.
                <br />Recherche : La recherche permet de localiser un lieu et d'y déplacer la carte.
                <br />Pondération : La pondération s'effectue en sélectionnant le menu "avancé" puis en choissant "indicateur personnalisé". Cette option
                 permet de créer son propre indicateur, en choisissant les critères pris en compte et en les pondérant.


          </p>
        </div>
        <div id="ligne3">
          <p class="explication" id="action">
            <strong>Actions :</strong>
              <br />Déplacements de la carte : À chaque déplacement de la carte, les analyses sont réactualisées.

          </p>
          <p class="explication" id="attention">
            <strong>Attention :</strong> il est préférable de ne pas faire les analyses sur des zones trops grandes, cela entraîne des ralentissements de
            l'application.
          </p>
        </div>

        </div>
      </div>


</body>
</html>
