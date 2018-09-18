<?php 
require(dirname(dirname(__FILE__))."/includes.php");

$mymembers = getClanMembers($con, $_SESSION['my_clan']['clan_id']);
$s = array();
$s['data'] = $mymembers;

echo json_encode($s, JSON_NUMERIC_CHECK);
exit;
?>
