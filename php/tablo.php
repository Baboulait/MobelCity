<div id='tableau'>
  <h2 id="nom">Informations sur les mailles / carreaux </h2>
  <button  type="button">Export en CSV (inactif)</button>

  <table>
    <?php
    $link = pg_connect("host=db1.utc port=5432 dbname=wavemobelcity user=wavemobelcity password=zwwYEiD2");

    if (!$link) {
      echo('Erreur de connexion');
    }



    $requete = "SELECT libgeo,round(ind_c) as Population,nom_dept as departement,code as code_commune, nbnormale as POINormale, nbsemirapi as POISemirapide, nbrapide as POIRapide, nbborne as POITotal FROM centroidesetcotes_final limit 50";

       if ($result = pg_query($link, $requete)) {
                  // Traitement du résultat
                  while ($ligne = pg_fetch_assoc($result)) {
                      // $ligne est un tableau associatif
                      $borne[] = $ligne;
                  }

              } else {
                  echo "Erreur de requête de base de données.";
              }

              // si on a des résultats
              if (sizeof($borne) > 0) {
                  echo "<table>";
                  echo "<tr>";
                  foreach ($borne[0] as $cle => $valeur) {
                      echo "<th>$cle</th>";
                  }

                  echo "</tr>";
                  foreach ($borne as $ligne) {
                      echo "<tr>";
                      foreach ($ligne as $cle => $valeur) {
                          echo "<td style='border:solid 0px black;'>";
                          //echo '<input type="text" value__()='.$valeur.'>';
                          echo $valeur;
                          echo "</td>";
                      }
                      echo "</tr>";
                  }
                  echo "</table>";
              } else {
                  echo '<p>Problème</p>';
              }
              ?>

</div>
<a href="#" id="tablofermer">Fermer</a> <!-- Permet de fermer le tableau -->
