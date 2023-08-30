<?php
  require 'db_conn.php';

  //echo $_POST['point'];

  $check_query = "SELECT id, name, ST_Distance(geog, ST_GeogFromText('".$_POST['point']."')) FROM mobike.racks WHERE ST_Distance(geog, ST_GeogFromText('".$_POST['point']."')) <= '20'";
  $check_res = pg_query($db_connection, $check_query);

  $res = array();
  $res = pg_fetch_all($check_res);

  $myObj = new stdClass();

  if (count($res) == 0) {
    $myObj->id = "null";
    $myObj->name = "null";
    $myObj->st_distance = "null";
  } else {
    while ($row = pg_fetch_row($check_res)){
      $myObj->id = $row[0];
      $myObj->name = $row[1];
      $myObj->st_distance = $row[2];
    }
  }

  echo json_encode($myObj);

  /*while ($row = pg_fetch_row($check_res)) {
    echo $row[0];
  }*/
?>
