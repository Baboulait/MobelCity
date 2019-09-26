
<?php
  $link = pg_connect("host=db1.utc port=5432 dbname=wavemobelcity user=wavemobelcity password=zwwYEiD2");

  if (!$link) {
    echo('Erreur de connexion');
  }

?>
