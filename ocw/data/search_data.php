<?php 
require(dirname(dirname(__FILE__))."/includes.php");
unset($_SESSION['search_results']);
if(isset($_REQUEST['searches'])) {
    $search_tags = array();
    $players = array();
    
    $search = trim($_REQUEST['searches']);
    if(!empty($search)) {
        $searches = explode("\n", $search);
        if(!empty($searches)) {
            foreach ($searches as $key => $val) {
                if(strpos($val, ",") !== false) {
                    $tmpVal = explode(",", $val);
                    foreach ($tmpVal as $tk => $tval) {
                        $search_tags[] = trim($tval);
                    }
                }
                else {
                    $search_tags[] = trim($val);
                }
            }
        }
    }
    $limit = 10;
    if(!empty($search_tags)) {
        if(count($search_tags) > $limit) {
            for($i =0; $i <= $limit; $i++) {
                $tmpPlayer = getPlayerAPI($search_tags[$i]);
                $players[$search_tags[$i]] = processPlayer($tmpPlayer);
                $tmpPlayer = json_decode($tmpPlayer,true);
                $players[$search_tags[$i]]['name'] = $tmpPlayer['name'];
                $players[$search_tags[$i]]['player_tag'] = $tmpPlayer['tag'];
                $players[$search_tags[$i]]['townhall'] = $players[$search_tags[$i]]['townHallLevel'];
                $players[$search_tags[$i]]['aq'] = $players[$search_tags[$i]]['heroes_aq'];
                $players[$search_tags[$i]]['bk'] = $players[$search_tags[$i]]['heroes_bk'];
                $players[$search_tags[$i]]['gw'] = $players[$search_tags[$i]]['heroes_gw'];
                unset($players[$search_tags[$i]]['townHallLevel']);
                unset($players[$search_tags[$i]]['heroes_aq']);
                unset($players[$search_tags[$i]]['heroes_bk']);
                unset($players[$search_tags[$i]]['heroes_gw']);
            }
        }
        else {
            foreach ($search_tags as $key => $val) {
                $tmpPlayer = getPlayerAPI($val);
                $players[$val] = processPlayer($tmpPlayer);
                $tmpPlayer = json_decode($tmpPlayer,true);
                $players[$val]['name'] = $tmpPlayer['name'];
                $players[$val]['player_tag'] = $tmpPlayer['tag'];
                $players[$val]['townhall'] = $players[$val]['townHallLevel'];
                $players[$val]['aq'] = $players[$val]['heroes_aq'];
                $players[$val]['bk'] = $players[$val]['heroes_bk'];
                $players[$val]['gw'] = $players[$val]['heroes_gw'];
                unset($players[$val]['townHallLevel']);
                unset($players[$val]['heroes_aq']);
                unset($players[$val]['heroes_bk']);
                unset($players[$val]['heroes_gw']);
            }
        }
        
        $_SESSION['search_results'][$_SESSION['my_clan']['clan_id']] = $players;
    }
    
}