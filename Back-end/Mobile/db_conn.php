<?php

	$username = "postgres";
	$password = "0110994";
	$db       = "postgres";

	$db_connection = pg_connect("host=localhost dbname=".$db." user=".$username." password=".$password);

  //echo $db_connection;


?>
