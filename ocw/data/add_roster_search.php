<?php 
require(dirname(dirname(__FILE__))."/includes.php");
if(isset($_REQUEST['id'])){
    $myroster = (!isset($_SESSION['search_results'][$_SESSION['my_clan']['clan_id']]) ? array() : $_SESSION['search_results'][$_SESSION['my_clan']['clan_id']]);
    foreach ($_REQUEST['id'] as $k => $val) {
       $data = $myroster[$val];
       if(!empty($data)) {
           unset($data['clan_tag']);
           unset($data['clan_name']);
           addtoRoster($data);
       }
    }
}