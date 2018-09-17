<?php 
require(dirname(dirname(__FILE__))."/includes.php");
$s = getRoster();
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($s, JSON_NUMERIC_CHECK);
exit;
?>