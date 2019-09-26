<?php

$link = pg_connect("host=db1.utc port=5432 dbname=wavemobelcity user=wavemobelcity password=zwwYEiD2");

if (!$link) {
  echo('Erreur de connexion');
}

// Variables
//$variables = "id, typeborne, libgeo, ind_c, nbborne, nbnormale, nbsemirapi, nbrapide, point_x, point_y, unx, uny, deuxy, deuxx, troisx, troisy, quatrex, quatrey, idinspire, ind, men, men_pav, men_5nd, men_prp, ind_snv, men_cll, men_mas, log_soc, i_11_17, i_18_24, i_25_39, i_40_54, i_55_64, scorepo, scr4054, scrmncl, scrppct, scrndsn, scorett";
$variables = " id , idinspire, typeborne, libgeo, nbnormale, nbsemirapi, nbrapide, ind_c, nbborne, ind, men, men_pav, men_5nd, men_prp, ind_snv, men_cll, men_mas, log_soc, i_11_17, i_18_24, i_25_39, i_40_54, i_55_64, popact, scorepo ,scr4054, scrmncl, scrppct, scrndsn, scorett, nbemployer, nbempbig,  nbempmoy, scorebrapide, scoreblente, scorebsemi, point_x ,point_y, unx, uny, deuxx, deuxy,troisx,troisy,quatrex,quatrey, scoreperso";


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

if (isset($_GET['nb_borne'])) {
	$borne=(int)$_GET['nb_borne'];
}

// SI on a un choix
if (isset($_GET['choix'])) {
	$choix=$_GET['choix'];
  $choix = " ORDER BY $choix DESC ";
}

// SI ce choix est choix perso
// Pondération
$choixcol = [];
if (isset($_GET['choixperso'])) {
  // Ex de choixperso : ind_c * 3, popact * 2, men_cll * 7
	$choixperso=$_GET['choixperso'];
  $choixpersoreplace = str_replace(",", " + ", $choixperso); // Je remplace les split "," par des + pour faire le calcule

/* A Remettre
  $choixpersosplt = str_split(',', $choixperso);
  $variablessplt = str_split(',', $variables);
  foreach ($variablessplt as $value1) {
    foreach ($choixpersosplt as $value2) {
      $indicateur = strtok($value2, '*');
      if ($value1 == $indicateur) {
        array_push($choixcol, $value2);
        $value1 = $value2; // Ici c'est pour les $variables ait les calcule (du type ind_c * 4)
      }
    }
  }
*/
  $choix = " ORDER BY scoreperso DESC ";

// SI pas choixperso
}

if (empty($_GET['choix'])) {
  $choix = " ORDER BY ind_c DESC ";
}



//////////// INFO //////////////
// $indicateur = ind_c * 4 split pour avoir ind_c
// $value1 = $variables split
// $value2 = $choixperso split
// $choixcol = les colonnes modifiées
/////////////////////////



// ICI rajouter les info des employers pour pouvoir afiner la sélection du type de borne voulu
if (isset($_GET['typebb'])) {
	$typebb=$_GET['typebb'];
  if ($typebb == "Toutes") {
    $irves = " ";
  }
  if ($typebb == "Rapides") {
    $irves = " nbrapide > nbnormale AND nbrapide > nbsemirapi AND nbborne > (50/100)*AVG(nbborne) AND ";
  }
  if ($typebb == "Semi Rapide") {
    $irves = " nbsemirapi > nbnormale AND nbsemirapi > nbsemirapi AND ";
  }
  if ($typebb == "Lente") {
    $irves = "  nbnormale > nbrapide AND nbnormale > nbsemirapi AND nbemployer > (50/100)*AVG(nbemployer) or men_cll > (50/100)*AVG(men_cll) AND ";
  }

}
// Bornes Rapide
  // WHERE nbPOI Rapide > nbPOI Lent et nbPOI Rapide > nbPOI Semi-Rapide
  // Petits commerces
// Bornes Semi - Rapides
  // WHERE nbPOI Semi-Rapide > nbPOI Lent et nbPOI Semi-Rapide > nbPOI Rapide
  // Commerces
// Bornes Lentes
  // WHERE nbPOI Lent > nbPOI Rapide et nbPOI Lent > nbPOI Semi-Rapide
  // Employers
  // bornes lentes
  // habitations
  // Entreprises

$irves ="";

// split the bbox into it's parts
list($left,$bottom,$right,$top)=explode(",",$bbox);

if (isset($_GET['choixperso'])) {
  $req2 = "UPDATE centroidesetcotes_finale SET scoreperso = $choixpersoreplace";
  // Je remplace les variables par le choix perso donc je remplace ind_c par ind_c * 4 par exemple.
  pg_query($link, $req2);
}

$req = "SELECT *
        FROM centroidesetcotes_finale
        where $irves unx >= $left and troisx <= $right and uny <= $top and troisy >= $bottom
        $choix";
// add column where   scoreperso = 1/5* indc and 2/5 nbborne and 2/5 4054ans



$propri=[];

if (isset($_GET['choixperso'])) {
  if ($result = pg_query($link, $req)) {
    while ($ligne = pg_fetch_assoc($result)) {


      $id = $ligne["id"];
      $idinspire = $ligne["idinspire"];
      $type = $ligne["typeborne"];
      $libgeo = $ligne["libgeo"];
      $nbnormale = $ligne["nbnormale"];
      $nbsemirapi = $ligne["nbsemirapi"];
      $nbrapide = $ligne["nbrapide"];

      $ind_c = $ligne['ind_c'];
      $nbborne = $ligne["nbborne"];

      $ind = $ligne["ind"];
      $men = $ligne["men"];
      $men_pauv = $ligne["men_pav"];
      $men_5ind = $ligne["men_5nd"];
      $men_prop = $ligne["men_prp"];
      $ind_snv = $ligne["ind_snv"];
      $men_coll = $ligne["men_cll"];
      $men_mais = $ligne["men_mas"];
      $log_soc = $ligne["log_soc"];

      $ind1117 = $ligne["i_11_17"];
      $ind1824 = $ligne["i_18_24"];
      $ind2539 = $ligne["i_25_39"];
      $ind4054 = $ligne["i_40_54"];
      $ind5564 = $ligne["i_55_64"];
      $popactive = $ligne["popact"];

      $scorepo = $ligne["scorepo"];
      $scr4054 = $ligne["scr4054"];
      $scrmncl = $ligne["scrmncl"];
      $scrpopact = $ligne["scrppct"];
      $scrndsn = $ligne["scrndsn"];
      $scoretot = $ligne["scorett"];

      $nbemployer = $ligne["nbemployer"];
      $nbempbig = $ligne["nbempbig"];
      $nbempmoy = $ligne["nbempmoy"];

      $scorebrapide = $ligne["scorebrapide"];
      $scoreblente = $ligne["scoreblente"];
      $scorebsemi = $ligne["scorebsemi"];

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
      $scoreperso = $ligne["scoreperso"];

      $properties = ["id" => $id,
        "idinspire" => $idinspire,
        "ind_c"=> $ind_c,
        "libgeo" => $libgeo,
        "typeborne" => $type,
        "nbnormale" => $nbnormale,
        "nbsemirapi" => $nbsemirapi,
        "nbrapide" => $nbrapide,
        "centrex" => $centrex,
        "centrey" => $centrey,
        "nbborne" => $nbborne,

        "ind" => $ind,
        "men" => $men,
        "men_pauv" => $men_pauv,
        "men_5ind" => $men_5ind,
        "men_prop" => $men_prop,
        "ind_snv" => $ind_snv,
        "men_coll" => $men_coll,
        "men_mais" => $men_mais,
        "log_soc" => $log_soc,
        "ind_11_17" => $ind1117,
        "ind_18_24" => $ind1824,
        "ind_25_39" => $ind2539,
        "ind_40_54" => $ind4054,
        "ind_55_64" => $ind5564,
        "popactive" => $popactive,

        "scorepo" => $scorepo,
        "scr4054" => $scr4054,
        "scrmncl" => $scrmncl,
        "scrpopact" => $scrpopact,
        "scrndsn" => $scrndsn,
        "scoretot" => $scoretot,

        "nbemployer" => $nbemployer,
        "nbempbig" => $nbempbig,
        "nbempmoy" => $nbempmoy,

        "scorebrapide" => $scorebrapide,
        "scoreblente" => $scoreblente,
        "scorebsemi" => $scorebsemi,
        "scoreperso" => $scoreperso,

        'geometry'=>array( 'type' => 'Polygon', 'coordinates' => array([$unx, $uny],[$deuxx,$deuxy],[$troisx,$troisy],[$quatrex,$quatrey]))];

      array_push($propri, $properties);

    }
  } else{
    echo "Erreur de requete de base de données";
  }
} else {
  if ($result = pg_query($link, $req)) {
    while ($ligne = pg_fetch_assoc($result)) {


      $id = $ligne["id"];
      $idinspire = $ligne["idinspire"];
      $type = $ligne["typeborne"];
      $libgeo = $ligne["libgeo"];
      $nbnormale = $ligne["nbnormale"];
      $nbsemirapi = $ligne["nbsemirapi"];
      $nbrapide = $ligne["nbrapide"];

      $ind_c = $ligne['ind_c'];
      $nbborne = $ligne["nbborne"];

      $ind = $ligne["ind"];
      $men = $ligne["men"];
      $men_pauv = $ligne["men_pav"];
      $men_5ind = $ligne["men_5nd"];
      $men_prop = $ligne["men_prp"];
      $ind_snv = $ligne["ind_snv"];
      $men_coll = $ligne["men_cll"];
      $men_mais = $ligne["men_mas"];
      $log_soc = $ligne["log_soc"];

      $ind1117 = $ligne["i_11_17"];
      $ind1824 = $ligne["i_18_24"];
      $ind2539 = $ligne["i_25_39"];
      $ind4054 = $ligne["i_40_54"];
      $ind5564 = $ligne["i_55_64"];
      $popactive = $ligne["popact"];

      $scorepo = $ligne["scorepo"];
      $scr4054 = $ligne["scr4054"];
      $scrmncl = $ligne["scrmncl"];
      $scrpopact = $ligne["scrppct"];
      $scrndsn = $ligne["scrndsn"];
      $scoretot = $ligne["scorett"];

      $nbemployer = $ligne["nbemployer"];
      $nbempbig = $ligne["nbempbig"];
      $nbempmoy = $ligne["nbempmoy"];

      $scorebrapide = $ligne["scorebrapide"];
      $scoreblente = $ligne["scoreblente"];
      $scorebsemi = $ligne["scorebsemi"];

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


      $properties = ["id" => $id,
        "idinspire" => $idinspire,
        "ind_c"=> $ind_c,
        "libgeo" => $libgeo,
        "typeborne" => $type,
        "nbnormale" => $nbnormale,
        "nbsemirapi" => $nbsemirapi,
        "nbrapide" => $nbrapide,
        "centrex" => $centrex,
        "centrey" => $centrey,
        "nbborne" => $nbborne,

        "ind" => $ind,
        "men" => $men,
        "men_pauv" => $men_pauv,
        "men_5ind" => $men_5ind,
        "men_prop" => $men_prop,
        "ind_snv" => $ind_snv,
        "men_coll" => $men_coll,
        "men_mais" => $men_mais,
        "log_soc" => $log_soc,
        "ind_11_17" => $ind1117,
        "ind_18_24" => $ind1824,
        "ind_25_39" => $ind2539,
        "ind_40_54" => $ind4054,
        "ind_55_64" => $ind5564,
        "popactive" => $popactive,

        "scorepo" => $scorepo,
        "scr4054" => $scr4054,
        "scrmncl" => $scrmncl,
        "scrpopact" => $scrpopact,
        "scrndsn" => $scrndsn,
        "scoretot" => $scoretot,

        "nbemployer" => $nbemployer,
        "nbempbig" => $nbempbig,
        "nbempmoy" => $nbempmoy,

        "scorebrapide" => $scorebrapide,
        "scoreblente" => $scoreblente,
        "scorebsemi" => $scorebsemi,

        'geometry'=>array( 'type' => 'Polygon', 'coordinates' => array([$unx, $uny],[$deuxx,$deuxy],[$troisx,$troisy],[$quatrex,$quatrey]))];

      array_push($propri, $properties);

    }
  } else{
    echo "Erreur de requete de base de données";
  }
}


  echo json_encode($propri, JSON_NUMERIC_CHECK);

?>
