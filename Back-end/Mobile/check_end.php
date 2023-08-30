<?php
  require 'db_conn.php';

  //echo $_POST['point'];

  $upd_rent = "UPDATE mobike.rent SET end_rack='".$_POST['erack']."' WHERE id='".(int)$_POST['rentn']."' AND bike='".$_POST['bike']."'";
  $upd_res = pg_query($db_connection, $upd_rent);

  //$res = array();
  //$res = pg_fetch_all($check_res);

  $update_rack_bikes = "SELECT bike_lst FROM mobike.racks WHERE id='".$_POST['erack']."'";
  $result_rack_update = pg_query($db_connection, $update_rack_bikes);

  $dbres_rack = array();
  $dbres_rack = pg_fetch_all($result_rack_update);
  $bike_lst = "";
  $new_bike_lst = "";

  while ($row = pg_fetch_row($result_rack_update)) {
    $bike_lst = explode(", ", $row[0]);

  }
  for ($i = 0; $i < count($bike_lst); $i++) {
    $bike_lst[$i] = str_replace("[", "", $bike_lst[$i]);
    $bike_lst[$i] = str_replace("]", "", $bike_lst[$i]);
    $new_bike_lst = $new_bike_lst.$bike_lst[$i];

    if ($i != count($bike_lst) - 1) {
      $new_bike_lst = $new_bike_lst.", ";
    }
  }

  $new_bike_lst = "[".rtrim($new_bike_lst, ", ").", ".$_POST['bike']."]";

  $update_rack_bikes = "UPDATE mobike.racks SET bike_lst='".$new_bike_lst."' WHERE id='".$_POST['erack']."'";
  $result_rack_update = pg_query($db_connection, $update_rack_bikes);

  $update_onserv = "UPDATE mobike.bikes SET onservice='false', reserved='false', rack='".$_POST['erack']."' WHERE id='".(int)$_POST['bike']."'";

  $result = pg_query($db_connection, $update_onserv);

  //echo json_encode($res);

  /*while ($row = pg_fetch_row($check_res)) {
    echo $row[0];
  }*/
?>
