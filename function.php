<?php

include "mysqlClass.inc.php";

// 1: user inserted into DB
// 2: user exists in DB
function user_exist_check ($username, $password) {
	$query = "SELECT * from account where username='$username'";
	$result = mysql_query($query);
	if (!$result) {
		die("user_exist_check() error: Failed to query the database: <br />". mysql_error());
	}
	else {
		$row = mysql_fetch_assoc($result);
		if ($row == 0) {
			$query = "INSERT into account values ('NULL','$username', '$password')";
			$insert = mysql_query($query);
			if ($insert)
				return 1;
			else
				die("Failed to insert into the database: <br>" . mysql_error());
		}
		else {
			return 2;
		}
	}
}

function user_pass_check ($username, $password) {
	$query = "SELECT * from account where username='$username'";
	$result = mysql_query($query);

	if (!$result) {
		die("user_pass_check() error: Failed to query the database: <br />" . mysql_error());
	}
	else {
		$row = mysql_fetch_row($result);
		if (strcmp($row[2], $password))
			return 2; // wrong password
		else
			return 0; // successful
	}
}

function upload_error ($result) {
	// Error descriptions found here: http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result) {
		case 0:
			return "UPLOAD_ERR_OK";
		case 1:
            return "UPLOAD_ERR_INI_SIZE";
        case 2:
            return "UPLOAD_ERR_FORM_SIZE";
        case 3:
            return "UPLOAD_ERR_PARTIAL";
        case 4:
            return "UPLOAD_ERR_NO_FILE";
        case 5:
            return "UPLOAD_ERR_NO_TMP_DIR";
        case 6:
            return  "UPLOAD_ERR_CANT_WRITE";
        case 7:
            return  "UPLOAD_ERR_EXTENSION";
	}
}

function get_client_ip() {
	// Check from shared internet
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $$_SERVER['HTTP_CLIENT_IP'];
	// Check from proxy
	else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    	$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else
    	$ipaddress = $_SERVER['REMOTE_ADDR'];
    return $ipaddress;
}

function updateMediaTime ($MediaID)
{
	$query = "UPDATE media set lastaccesstime=CURRENT_TIMESTAMP WHERE MediaID='$MediaID'";
	$result = mysql_query($query);
	if (!$result) {
		die("updateMediaTime() error: Failed to query the database: <br>" . mysql_error());
	}
}

// Add row to subscription table
function create_sub($subscriber, $subscribed) {

}

?>
