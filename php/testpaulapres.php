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


$req = "SELECT * from mobelcitypoifullcsvtosql WHERE coordsx1 >= $left AND coordsx1 <= $right AND coordsx2 >= $bottom AND coordsx2 <= $top limit 1000";
//WHERE coordsx1 >= $left AND coordsx1 <= $right AND coordsx2 >= $bottom AND coordsx2 <= $top

$propri=[];

if ($result = pg_query($link, $req)) {
  while ($ligne = pg_fetch_assoc($result)) {
    $field = $ligne["field_1"];
    $code = $ligne["code"];
    $fclass = $ligne["fclass"];
    $nom = $ligne["name"];
    $groupe = $ligne["groupe"];
    $fclass_rec = $ligne["fclass_rec"];
    $typeborne = $ligne["typeborne"];
    $tempsmoy = $ligne["tempsmoy"];
    $score = $ligne["score"];
    $x1 = $ligne["coordsx1"];
    $y1 = $ligne["coordsx2"];

    $properties = ["field" => $field, "nom" => $nom, "groupe" => $groupe, "score" => $score,"code" => $code, "fclass" => $fclass, "fclass_rec" =>$fclass_rec,  "typeborne" => $typeborne, "tempsmoy" => $tempsmoy, 'geometry'=>array( 'type' => 'Point', 'coordinates' => array( $x1, $y1))];
    /*   */
    array_push($propri, $properties);

  }
} else{
  echo "Erreur de requete de base de données";
}

  echo json_encode($propri);

///////////////
/* Je penses que ça peut aider, mais pour l'instant ça ne fonctionne pas !
$link = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=localhost");

if (!$link) {
  echo('Erreur de connexion');
}


$req = "select * from mobelcitypoifullcsvtosql limit 10";


while($geo = $req->fetch())
{

	$formation[] = array(
						 'type' 		=> 'Feature',
						 'geometry'	=> array(
						 						'type' => 'Point',
												'coordinates' => array(
																		$geo['coordsx1'],
																		$geo['coordsx2'])),
						 'properties' => array(
                       'name' => $geo['name'],
                       'field' => $geo["field_1"],
                       'code' => $geo["code"],
                       'fclass' => $geo["fclass"],
                       'groupe' => $geo["groupe"],
                       'fclass_rec' => $geo["fclass_rec"],
                       'typeborne' => $geo["typeborne"],
                       'tempsmoy' => $geo["tempsmoy"],
                       'score' => $geo["score"]));

}

$geo =  json_encode($formation);
// echo json_encode($formation);
*/
?>
