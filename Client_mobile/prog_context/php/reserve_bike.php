<?php
  require 'db_conn.php';

  /*if (!isset($_GET['name'])){
     echo "errore: ";
   }*/

  //echo $_GET['rack']."\n";
  $getbike = "SELECT * FROM mobike.bikes WHERE id='".$_GET['name']."'";
  $result = pg_query($db_connection, $getbike);

  $update_rack_bikes = "SELECT bike_lst FROM mobike.racks WHERE id='".$_GET['rack']."'";
  $result_rack_update = pg_query($db_connection, $update_rack_bikes);

  $dbres = array();
  $dbres = pg_fetch_all($result);

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
    if ($bike_lst[$i] != $_GET['name']) {
      $new_bike_lst = $new_bike_lst.$bike_lst[$i];
      /*if ($i != count($bike_lst) - 1) {
        $new_bike_lst = $new_bike_lst.", ";
      }*/
    } else {
      $new_bike_lst = $new_bike_lst.$bike_lst[$i]."res";
    }
    if ($i != count($bike_lst) - 1) {
      $new_bike_lst = $new_bike_lst.", ";
    }
  }
  $new_bike_lst = "[".rtrim($new_bike_lst, ", ")."]";
  //echo $new_bike_lst;

  $db_res_date = "";
  $db_res_token = "";
  $new_dates = "";
  $new_tokens = "";
  $bool_to_update = true;
  //TOKEN GEN
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < 6; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  //echo $randomString;
  //echo $dbres;
  if (count($dbres) == 0) {
    //echo "bon!";
    $getbike = "INSERT INTO mobike.bikes(id, rack, res_date, unlock_token, reserved, onservice) VALUES('".$_GET['name']."', '".$_GET['rack']."', '".$_GET['date']."', '".$randomString."', 'true', 'false')";
    $result = pg_query($db_connection, $getbike);
    $update_rack_bikes = "UPDATE mobike.racks SET bike_lst='".$new_bike_lst."' WHERE id='".$_GET['rack']."'";
    $result_rack_update = pg_query($db_connection, $update_rack_bikes);
    //$dbres = array();
    //$dbres = pg_fetch_all($result);
    echo $randomString;
  } else {
    //RETRIEVING RESERVATION DATES
    while ($row = pg_fetch_row($result)) {
      //$dbres[] = $row;
      //echo "bike id: $row[0]   res date: $row[3]\n\n";
      $db_res_token = $row[4];
      $db_res_token = explode(", ", $db_res_token);
      $db_res_date = str_replace("(", "", $row[3]);
      $db_res_date = str_replace(")", "", $db_res_date);
      $db_res_date = explode(", ", $db_res_date);
      //echo count($db_res_date);
    }
    //CHECK IF RESERVATION IS FOR NEW DATE
    for ($i=0; $i < count($db_res_date); $i++) {
      if ($i == count($db_res_date) - 1) {
        $new_dates = $new_dates.$db_res_date[$i];
        $new_tokens = $new_tokens.$db_res_token[$i];
      } else {
        $new_dates = $new_dates.$db_res_date[$i].", ";
        $new_tokens = $new_tokens.$db_res_token[$i].", ";
      }
      if ($db_res_date[$i] == $_GET['date']) {
        $bool_to_update = false;
      }
    }
    //UPDATE RESERVATION QUERY
    if ($bool_to_update) {
      $new_dates = "'".$_GET['date']."'";
      $new_tokens = "'".$randomString."'";
      //echo $new_dates;
      $update_bike = "UPDATE mobike.bikes SET res_date=".$new_dates.", unlock_token=".$new_tokens.", onservice='false', reserved='true' WHERE id='".$_GET['name']."'";
      $result = pg_query($db_connection, $update_bike);
      $update_rack_bikes = "UPDATE mobike.racks SET bike_lst='".$new_bike_lst."' WHERE id='".$_GET['rack']."'";
      $result_rack_update = pg_query($db_connection, $update_rack_bikes);
      echo $randomString;
    } else {
      echo "bike already reserved for selected date: ".$_GET['date'];
    }
  }
?>
