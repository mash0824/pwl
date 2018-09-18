<?php 
require(dirname(__FILE__)."/_config.php");
require(dirname(__FILE__)."/_func.php");
require(dirname(__FILE__)."/_f_curl_v1.6.php");
$con = new mysqli(db_host, db_user, db_password,db_name);
if (!$con->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $con->error);
    exit();
} else {
    printf("Current character set: %s\n", $con->character_set_name());
}

