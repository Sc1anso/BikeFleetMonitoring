<?php
  require '../db_conn.php';

  $sel_user = "SELECT password FROM mobike.users WHERE username='".$_GET['user']."'";
  $res = pg_query($db_connection, $sel_user);

  $insert_new_user = "INSERT INTO mobike.users (username, password) VALUES('".$_GET['user']."', '".$_GET['psw']."')";

  //echo count(pg_fetch_all($res));

  if (count(pg_fetch_all($res)) == 0) {
    $ins_res = pg_query($db_connection, $insert_new_user);
    echo "true";
  } else {
    echo "false";
  }

?>
