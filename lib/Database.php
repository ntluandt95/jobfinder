
 <?php

 	$file = fopen("../../../connection.txt", "r");

 	$host = fgets($file);
 	$dbname = fgets($file);
 	$user = fgets($file);
 	$password = fgets($file);
 	fclose($file);
 	
 	$dbhost = pg_connect("host=".$host." dbname=".$dbname." user=".$user." password=".$password);

 	
 	$dbhost = pg_connect("host=".$host." dbname=".$dbname." user=".$user." password=".$password);

	
	if(!$dbhost)
		{
			die("Error: ".pg_last_error());
		}
 	

 	
 
 ?>