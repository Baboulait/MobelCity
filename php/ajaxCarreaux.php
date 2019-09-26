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


$req = "SELECT * from centroidesetcotes_finale where unx >= $left and troisx <= $right and uny <= $top and troisy >= $bottom ORDER BY nbborne DESC ";

$propri=[];

if ($result = pg_query($link, $req)) {
  while ($ligne = pg_fetch_assoc($result)) {
    $id = $ligne["id"];
    $type = $ligne["typeborne"];
    $libgeo = $ligne["libgeo"];
    $pop = $ligne["ind_c"];
    $nbnormale = $ligne["nbnormale"];
    $nbsemirapi = $ligne["nbsemirapi"];
    $rapide = $ligne["nbrapide"];
    $nbborne = $ligne["nbborne"];

    $centrex = $ligne["point_x"];
    $centrey = $ligne["point_y"];
    $unx = $ligne["unx"];
    $uny = $ligne["uny"];
    $deuxx = $ligne["deuxx"];
    $deuxy = $ligne["deuxy"];
    $troisx = $ligne["troisx"];
    $troisy = $ligne["troisy"];
    $quatrex = $ligne["quatrex"];
    $quatrey = $ligne["quatrey"];

    //$properties = ["id" => $id, "nbborne" => $nbborne];
    $properties = ['geometry'=>array( 'type' => 'Polygon', 'coordinates' => array([$uny, $unx],[$deuxy,$deuxx],[$troisy,$troisx],[$quatrey,$quatrex])), "id" => $id,"pop"=> $pop, "libgeo" => $libgeo,"borneNormale" => $nbnormale, "borneSemiRapide" => $nbsemirapi, "borneRapide" => $rapide, "centrex" => $centrex, "centrey" => $centrey, "nbborne" => $nbborne];
//$properties = ["field" => $field, "nom" => $nom, "groupe" => $groupe, "score" => $score,"code" => $code, "fclass" => $fclass, "fclass_rec" =>$fclass_rec,  "typeborne" => $typeborne, "tempsmoy" => $tempsmoy, 'geometry'=>array( 'type' => 'Point', 'coordinates' => array( $x1, $y1))];
    //$properties = [ "libgeo" => $libgeo, "nbborne" => $nbborne, 'geometry'=>array( 'type' => 'Polygone', 'coordinates' =>  $geom)];

    array_push($propri, $properties);

  }
} else{
  echo "Erreur de requete de base de données";
}

  echo json_encode($propri, JSON_NUMERIC_CHECK);


?>
