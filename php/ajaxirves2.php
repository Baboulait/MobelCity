<?php
$link = pg_connect("host=db1.utc port=5432 dbname=wavemobelcity user=wavemobelcity password=zwwYEiD2");

if (!$link) {
  echo('Erreur de connexion');
}



if (isset($_GET['bbox'])) {
    $bbox=$_GET['bbox'];
} else {
    // invalid request
    $ajxres=array();
    $ajxres['resp']=4;
    $ajxres['dberror']=0;
    $ajxres['msg']='missing bounding box';
    sendajax($ajxres);
}




// split the bbox into it's parts
list($left,$bottom,$right,$top)=explode(",",$bbox);

$req = "SELECT * FROM irvesconsolidees  WHERE xlongitude >= $left AND xlongitude <= $right AND ylatitude >= $bottom AND ylatitude <= $top";

$propri=[];

if ($result = pg_query($link, $req)) {
  while ($ligne = pg_fetch_assoc($result)) {
    $amenageur = $ligne["n_amenageu"];
    $operateur = $ligne["n_operateu"];
    $enseigne = $ligne["n_enseigne"];
    $id_station = $ligne["id_station"];
    $nom_station = $ligne["n_station"];
    $adresse = $ligne["ad_station"];
    $code_insee = $ligne["code_insee"];
    $nb_prise = $ligne["nbre_pdc"];

    $lng = $ligne["xlongitude"];
    $lat = $ligne["ylatitude"];

    $id_prise = $ligne["id_pdc"];
    $puissance = $ligne["puiss_max"];
    $type_prise = $ligne["type_prise"];
    $cout = $ligne["acces_rech"];
    $access = $ligne["accessibil"];
    $obs = $ligne["observatio"];
    $maj = $ligne["date_maj"];
    $id = $ligne["id"];

    $properties = ["id" => $id, "amenageur"=> $amenageur, "operateur" => $operateur, "enseigne" => $enseigne, "id_station" => $id_station, "nom" => $nom_station, "adresse" => $adresse, "code_insee" => $code_insee, "nb_prise" => $nb_prise, "id_prise" => $id_prise, "puissance" => $puissance, "type_prise" => $type_prise, "cout" => $cout, "access" => $access, 'geometry'=> array( 'type' => 'Point', 'coordinates' => array( $lng, $lat))];

    array_push($propri, $properties);

  }
} else {
  echo "Erreur de requete de base de données";
}

  echo json_encode($propri, JSON_NUMERIC_CHECK);



?>
