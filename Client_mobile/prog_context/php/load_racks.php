<?php
  require 'db_conn.php';

  $getrack = "SELECT name, ST_AsGeoJSON(geom) FROM mobike.racks";
  $result = pg_query($db_connection, $getrack);

  //$json_obj = '{"type": "FeatureCollection","features": [';

  //$end_json_obj = ']}';

  $container = new stdClass();
  $container->geos = array();
  $container->names = array();

  while ($row = pg_fetch_row($result)) {
    //$json_obj = $json_obj.'{"type": "Feature","geometry": '.$row[1].',"name": "'.$row[0].'"},';
    $container->geos[] = $row[1];
    $container->names[] = $row[0];
    /*for ($i=0; $i < strlen($row[1]); $i++) {
      echo $row[1][$i];
      if ($row[1][$i] == "\\") {
        echo $row[1][$i];
        $row[1][$i] = "";
      }"Nome": '.str_replace(" ", "", $row[0]).'"properties": {

      }
    }*/
    //echo json_encode($row[1], JSON_UNESCAPED_SLASHES);
  }
  echo json_encode($container);
  //$json_obj = rtrim($json_obj, ", ");
  //echo $json_obj.$end_json_obj;
  //$dbres = array();
  //$dbres = pg_fetch_all($result);

  //echo json_encode($dbres);
?>
