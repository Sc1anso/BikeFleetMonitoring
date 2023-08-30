<?php
  require 'db_conn.php';

  //echo $_POST['point'];

  $update_rack_bikes = "SELECT bike_lst FROM mobike.rastrelliere WHERE id='".$_POST['rack']."'";
  $result_rack_update = pg_query($db_connection, $update_rack_bikes);

  $dbres_rack = array();
  $dbres_rack = pg_fetch_all($result_rack_update);
  $bike_lst = "";
  $new_bike_lst = "";

  while ($row = pg_fetch_row($result_rack_update)) {
    $bike_lst = explode(", ", $row[0]);

  }
  //creo la nuova lista delle bici modificata per quella rastrelliera
  for ($i = 0; $i < count($bike_lst); $i++) {
    $bike_lst[$i] = str_replace("[", "", $bike_lst[$i]);
    $bike_lst[$i] = str_replace("]", "", $bike_lst[$i]);
    if ($bike_lst[$i] != $_POST['bike']."res") {
      $new_bike_lst = $new_bike_lst.$bike_lst[$i];
      /*if ($i != count($bike_lst) - 1) {
        $new_bike_lst = $new_bike_lst.", ";
      }*/
    } else {
      //$new_bike_lst = $new_bike_lst.$bike_lst[$i]."res";
    }
    if ($i != count($bike_lst) - 1) {
      $new_bike_lst = $new_bike_lst.", ";
    }
  }
  $new_bike_lst = "[".rtrim($new_bike_lst, ", ")."]";

  $update_rack_bikes = "UPDATE mobike.rastrelliere SET bike_lst='".$new_bike_lst."' WHERE id='".$_POST['rack']."'";
  $result_rack_update = pg_query($db_connection, $update_rack_bikes);

  //$res = array();
  //$res = pg_fetch_all($check_res);

  //echo json_encode($res);

  /*while ($row = pg_fetch_row($check_res)) {
    echo $row[0];
  }*/
?>
