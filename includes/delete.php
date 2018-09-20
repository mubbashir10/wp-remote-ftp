<?php

	//getting data
	$ftp_server 	 	=  $_POST['ftpserver'];
	$ftp_username 	 	=  $_POST['ftpuser'];
	$ftp_password 	 	=  $_POST['ftppassword'];
	$dir	 			=  $_POST['user'];
	$file 	 			=  $_POST['ism'];
	
	//opening ftp connection
	$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
	$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);
	
	//deleting file
	ftp_delete($ftp_conn, $dir."/".$file);

	//closing ftp connection
	ftp_close($ftp_conn);

?>