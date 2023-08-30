<?php
  require 'db_conn.php';

  /*if (!isset($_GET['name'])){
     echo "errore: ";
   }*/

  //echo $_GET['rack']."\n";
  $getbike = "SELECT unlock_token FROM mobike.bikes WHERE id='".$_GET['name']."'";
  $result = pg_query($db_connection, $getbike);

  $dbres = array();
  $dbres = pg_fetch_all($result);

  $unlock_tok = "";

  while ($row = pg_fetch_row($result)) {
    $unlock_tok = $row[0];
  }

  echo $unlock_tok;
?>
