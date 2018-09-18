<?php 
require(dirname(dirname(__FILE__))."/includes.php");
if(isset($_REQUEST['sid'])){
    foreach ($_REQUEST['sid'] as $k => $val) {
        removeRoster($val);
    }
}