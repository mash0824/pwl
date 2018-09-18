<?php 
require(dirname(dirname(__FILE__))."/includes.php");

$mymembers = getClanMembers($con, $_SESSION['my_clan']['clan_id']);
$s = array();
$s['data'] = $mymembers;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($s);
exit;
?>
