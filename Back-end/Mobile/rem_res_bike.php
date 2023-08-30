<?php
  require 'db_conn.php';

  /*if (!isset($_GET['name'])){
     echo "errore: ";
   }*/

  //echo $_GET['rack']."\n";
  //$getbike = "SELECT onservice FROM mobike.bikes WHERE id='".$_GET['name']."'";
  //$result = pg_query($db_connection, $getbike);

  $update_rack_bikes = "SELECT bike_lst FROM mobike.racks WHERE id='".$_GET['rack']."'";
  $result_rack_update = pg_query($db_connection, $update_rack_bikes);

  //$dbres = array();
  //$dbres = pg_fetch_all($result);
  //$check_on_service = "";
  $old_bike_lst = "";
  $new_bike_lst = "";

  /*while ($row = pg_fetch_row($result)){
    for ($i = 0; $i < count($row); $i++) {
      //echo count($dbres);
      $check_on_service = $check_on_service.$row[$i];
    }
  }*/

  while ($row = pg_fetch_row($result_rack_update)){
    for ($i = 0; $i < count($row); $i++) {
      //echo $row[0];
      $old_bike_lst = explode(", ", $row[0]);
      //$check_on_service = $check_on_service.$row[$i];
    }
  }
  for ($i = 0; $i < count($old_bike_lst); $i++) {
    $old_bike_lst[$i] = str_replace("[", "", $old_bike_lst[$i]);
    $old_bike_lst[$i] = str_replace("]", "", $old_bike_lst[$i]);
    //$old_bike_lst[$i] = str_replace("res", "", $old_bike_lst[$i]);
    if ($old_bike_lst[$i] != $_GET['name']."res") {
      $new_bike_lst = $new_bike_lst.$old_bike_lst[$i];
      if ($i != count($old_bike_lst) - 1) {
        $new_bike_lst = $new_bike_lst.", ";
      }
    }
  }
  $new_bike_lst = "[".$new_bike_lst."]";
  //echo $new_bike_lst;
  $update_rack_bikes = "UPDATE mobike.racks SET bike_lst='".$new_bike_lst."' WHERE id='".$_GET['rack']."'";
  $result_rack_update = pg_query($db_connection, $update_rack_bikes);

?>
