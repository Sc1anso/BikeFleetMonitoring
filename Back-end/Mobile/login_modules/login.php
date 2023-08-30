<?php
  require '../db_conn.php';

  $sel_user = "SELECT password FROM mobike.users WHERE username='".$_GET['user']."'";
  $res = pg_query($db_connection, $sel_user);

  $psw_res = "";

  //$insert_new_user = "INSERT INTO mobike.users (username, password) VALUES('".$_GET['user']."', '".$_GET['psw']."')";

  //echo count(pg_fetch_all($res));

  if (count(pg_fetch_all($res)) == 0) {
    //$ins_res = pg_query($db_connection, $insert_new_user);
    echo "false";
  } else {
    while ($row = pg_fetch_row($res)) {
      $psw_res = strval($row[0]);

    }
    //$psw_res = json_encode(pg_fetch_all($res));
    //echo $psw_res;
    if ($_GET['psw'] == $psw_res) {
      echo "true";
    } else {
      echo "wrong_psw";
    }
  }

?>
