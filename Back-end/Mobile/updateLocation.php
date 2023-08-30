<?php
  require 'db_conn.php';

  /*if (!isset($_POST['name'])){
     echo "errore: ";
   }*/
  //echo $_POST['lat'];
  //echo $_POST['lon'];
  //echo $_POST['point'];

  $select = "SELECT COUNT(*) FROM mobike.rent";
  $res_sel = pg_query($db_connection, $select);

  $update_path = "UPDATE mobike.bikes SET lat='".(double)$_POST['lat']."', lon='".(double)$_POST['lon']."',
        geog='POINT(".(double)$_POST['lon']." ".(double)$_POST['lat'].")', geom='POINT(".(double)$_POST['lon']." ".(double)$_POST['lat'].
        ")', onservice='true', reserved='true' WHERE id='".(int)$_POST['bike']."'";

  $result = pg_query($db_connection, $update_path);

  $res = array();
  $res = pg_fetch_all($res_sel);

  $path_str = "'PATH(".(double)$_POST['lon']." ".(double)$_POST['lat']."')'";

  /*$path_history = array();

  $select_path = "SELECT history FROM mobike.bikes WHERE id='1'";
  $res_sel_path = pg_query($db_connection, $select_path);
  while ($row = pg_fetch_row($res_sel_path)){
    array_push($path_history, $row);
  }*/

  //$response = pg_fetch_all($res_sel_path);
  //echo json_encode($response[0]);
  // Prepare a query for execution
  //$update_history_newr = pg_prepare($db_connection, "my_query", 'UPDATE mobike.bikes SET history=array_append(history, $path_str) WHERE id = $1');
  $update_history_newr = "UPDATE mobike.bikes SET history=array_append(history, PATH('".(double)$_POST['lon'].", ".(double)$_POST['lat']."')) WHERE id='".(int)$_POST['bike']."'";

  $sel_hist_to_updt = "SELECT history[array_upper(history, 1)] FROM mobike.bikes WHERE id='".(int)$_POST['bike']."'";
  $res_sel_hist_to_updt = pg_query($db_connection, $sel_hist_to_updt);
  $ziopera = "";
  //echo strval($ziopera[0]);
  while ($row = pg_fetch_row($res_sel_hist_to_updt)){
    $ziopera = strval($row[0]);
  }
  $old_last_path = str_replace("((", "(", str_replace("))", ")", $ziopera));
  $new_last_path = $old_last_path.",(".(double)$_POST['lon'].",".(double)$_POST['lat'].")";
  //echo $new_last_path;

  $update_history_append = "UPDATE mobike.bikes SET history[array_upper(history, 1)] = PATH('".$new_last_path."') WHERE id='".(int)$_POST['bike']."'";

  //echo $res[0]['count'];

  $count = $res[0]['count'];

  if ($_POST['newrent'] == "true") {
    $count = (int)$count;
    $count = $count + 1;
    $ins_rent = "INSERT INTO mobike.rent(id, bike, start_rack) VALUES('".(int)$count."', '".(int)$_POST['bike']."', '".(int)$_POST['srack']."')";
    $ins_res = pg_query($db_connection, $ins_rent);
    $ins_hist = pg_query($db_connection, $update_history_newr);
  } else {
    $upd_rent = "UPDATE mobike.rent SET path='".$_POST['path']."' WHERE id='".(int)$count."'";
    $upd_res = pg_query($db_connection, $upd_rent);
    //$ins_hist = pg_query($db_connection, $update_history_newr);
    $upd_hist = pg_query($db_connection, $update_history_append);

  }

  //CHECK IF WE ARE GOING INTO A GEOFENCE
  //$check_in_geo = "SELECT ST_Contains(ST_SetSRID(geom, 4326), ST_SetSRID(ST_Point('".(double)$_POST['lon']."', '".(double)$_POST['lat']."'), 4326)) FROM mobike.aree_vietate";
  $check_in_geo_vietate = "SELECT name FROM mobike.aree_vietate WHERE ST_Contains(ST_SetSRID(geom, 4326), ST_SetSRID(ST_Point('".(double)$_POST['lon']."', '".(double)$_POST['lat']."'), 4326))='true'";
  //$check_in_geo = "SELECT ST_Covers(ST_GeogFromText(geom), ST_GeogFromText(ST_Point('".(double)$_POST['lon']."', '".(double)$_POST['lat']."'))) FROM mobike.bike WHERE id='".$_POST['bike']."'";
  $vietate_res = pg_query($db_connection, $check_in_geo_vietate);
  $v_res = "";
  //$v_res = pg_fetch_all($vietate_res);
  while ($row = pg_fetch_row($vietate_res)) {
    $v_res = $row[0];
  }
  if ($v_res == "") {
    $v_res = "false";
  }
  //echo $v_res;

  $check_in_geo_poi = "SELECT name FROM mobike.poi WHERE ST_Contains(ST_SetSRID(geom, 4326), ST_SetSRID(ST_Point('".(double)$_POST['lon']."', '".(double)$_POST['lat']."'), 4326))='true'";
  //$check_in_geo = "SELECT ST_Covers(ST_GeogFromText(geom), ST_GeogFromText(ST_Point('".(double)$_POST['lon']."', '".(double)$_POST['lat']."'))) FROM mobike.bike WHERE id='".$_POST['bike']."'";
  $poi_res = pg_query($db_connection, $check_in_geo_poi);
  $p_res = "";
  //$p_res = pg_fetch_all($poi_res);
  while ($row = pg_fetch_row($poi_res)) {
    $p_res = $row[0];
  }
  if ($p_res == "") {
    $p_res = "false";
  }


  $myObj = new stdClass();

  if($v_res == "false" && $p_res == "false"){
    $myObj->inGeo = "false";
    $myObj->rentId = $count;
    $myObj->geoType = "null";
    $myObj->geoName = "null";
    echo json_encode($myObj);
  } elseif ($v_res != "false" && $p_res == "false") {
    $myObj->inGeo = "true";
    $myObj->rentId = $count;
    $myObj->geoType = "forb";
    $myObj->geoName = $v_res;
    echo json_encode($myObj);
  } elseif ($v_res == "false" && $p_res != "false"){
    $myObj->inGeo = "true";
    $myObj->geoType = "poi";
    $myObj->rentId = $count;
    $myObj->geoName = $p_res;
    echo json_encode($myObj);
  } elseif ($v_res != "false" && $p_res != "false") {
    $myObj->inGeo = "true";
    $myObj->rentId = $count;
    $myObj->geoType = "both";
    $myObj->geoName = $v_res."--".$p_res;
    echo json_encode($myObj);
  }
  /*$getrack = "SELECT id, name, bike_lst FROM mobike.rastrelliere WHERE name='".$_POST['name']."'";
  $result = pg_query($db_connection, $getrack);

  $dbres = array();
  $dbres = pg_fetch_all($result);

  echo json_encode($dbres);*/
?>
