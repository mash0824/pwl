<?php 
require(dirname(dirname(__FILE__))."/includes.php");
if(isset($_REQUEST['id'])){
    foreach ($_REQUEST['id'] as $k => $val) {
        $m = getSelectedClanMembersTag($con, $val);
        addtoRoster($m);
    }
}