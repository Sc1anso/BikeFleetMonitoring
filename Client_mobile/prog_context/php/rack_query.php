<?php
  require 'db_conn.php';

  if (!isset($_GET['name'])){
     echo "errore: ";
   }
  $getrack = "SELECT id, name, bike_lst FROM mobike.racks WHERE name='".$_GET['name']."'";
  $result = pg_query($db_connection, $getrack);

  $dbres = array();
  $dbres = pg_fetch_all($result);

  echo json_encode($dbres);
?>
