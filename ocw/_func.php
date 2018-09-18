<?php 
function getOcwClanLists($db, $id=""){
    $return = array();
    $sql = "SELECT * FROM clans";
    if($id != "") {
        $sql .= " WHERE clan_id = '$id'";
    }
    $sql .= " ORDER BY clan_name ASC";
    $res = $db->query($sql);
    if($id != "") {
        $row = $res->fetch_assoc();
        $return = $row;
    }
    else {
            while($row = $res->fetch_assoc()){
            $return[] = $row;
        }
    }
    return $return;
}

function getTeamLists($db, $id=""){
    $return = array();
     
    $sql = "SELECT * FROM teams";
    if($id != "") {
        $sql .= " WHERE team_id = '$id'";
    }
    $res = $db->query($sql);
    if($id != "") {
        $row = $res->fetch_assoc();
        $return = $row;
    }
    else {
        while($row = $res->fetch_assoc()){
            $return[] = $row;
        }
    }
    return $return;
}

function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } else if (is_string ($mixed)) {
        return utf8_encode($mixed);
    }
    return $mixed;
}

function getClanMembers($db, $id=""){
    $return = array();
    $sql = "SELECT * FROM clan_members";
    $sql .= " WHERE clan_id = '$id' AND townhall > '8' ";
    $sql .= " ORDER BY townhall DESC";
    $res = $db->query($sql);
    while($row = $res->fetch_assoc()){
        $return[] = $row;
    }
    return $return;
}

function getSelectedClanMembersTag($db, $id=""){
    $return = array();
    $sql = "SELECT * FROM clan_members";
    $sql .= " WHERE player_tag = '$id'";
    $res = $db->query($sql);
    $row = $res->fetch_assoc();
    $return = $row;
    return $return;
}

function addtoRoster($data){
    $myroster = (!isset($_SESSION['roster'][$_SESSION['my_clan']['clan_id']]) ? array() : $_SESSION['roster'][$_SESSION['my_clan']['clan_id']]);
    $myroster[$data['player_tag']]['name'] = $data['name'];
    $myroster[$data['player_tag']]['player_tag'] = $data['player_tag'];
    $myroster[$data['player_tag']]['townhall'] = $data['townhall'];
    $myroster[$data['player_tag']]['aq'] = $data['aq'];
    $myroster[$data['player_tag']]['bk'] = $data['bk'];
    $myroster[$data['player_tag']]['gw'] = $data['gw'];
    $_SESSION['roster'][$_SESSION['my_clan']['clan_id']] = $myroster;
}

function removeRoster($data) {
    $myroster = (!isset($_SESSION['roster'][$_SESSION['my_clan']['clan_id']]) ? array() : $_SESSION['roster'][$_SESSION['my_clan']['clan_id']]);
    unset($myroster[$data]);
    $_SESSION['roster'][$_SESSION['my_clan']['clan_id']] = $myroster;
}

function getRoster(){
    $s = array();
    $myroster = (!isset($_SESSION['roster'][$_SESSION['my_clan']['clan_id']]) ? array() : $_SESSION['roster'][$_SESSION['my_clan']['clan_id']]);
    if(empty($myroster)) {
        $s['data'] = array();
    }
    else {
        $s['data'] = $myroster;
        sort($s['data']);
    }
    
    return $s;
}

function getSearchData(){
    $s = array();
    $myroster = (!isset($_SESSION['search_results'][$_SESSION['my_clan']['clan_id']]) ? array() : $_SESSION['search_results'][$_SESSION['my_clan']['clan_id']]);
    if(empty($myroster)) {
        $s['data'] = array();
    }
    else {
        $s['data'] = $myroster;
        sort($s['data']);
    }
    
    return $s;
}

function getClanMembersAPI($clan_tag){
    $enc_tag = urlencode($clan_tag);
    $url = "https://api.clashofclans.com/v1/clans/$enc_tag/members";
    $apikey = API_TOKEN;
    $httpheader = array('authorization: Bearer '.$apikey, 'Accept: application/json');
    $pingresult = PushLead(
        "" //requestData
        , $url //url
        , "" //POST
        , 60 //connect timeout
        , $httpheader //http header
        );
    
    return $pingresult;
}

function processMembers($members){
    $members = json_decode($members,true);
    $mymember = array();
    $i=0;
    foreach($members['items'] as $key => $val){
        $mymember[$i]['tag'] = $val['tag'];
        $mymember[$i]['name'] = $val['name'];
        $player = getPlayerAPI($val['tag']);
        $players = processPlayer($player);
        $mymember[$i]['townHallLevel'] = $players['townHallLevel'];
        $mymember[$i]['heroes_aq'] = $players['heroes_aq'];
        $mymember[$i]['heroes_bk'] = $players['heroes_bk'];
        $mymember[$i]['heroes_gw'] = $players['heroes_gw'];
        $mymember[$i]['clan_tag'] = $players['clan_tag'];
        $mymember[$i]['clan_name'] = $players['clan_name'];
        $i++;
    }
    return $mymember;
}

function processPlayer($player){
    $myplayer = array();
    $player = json_decode($player,true);
    $myplayer['townHallLevel'] = $player['townHallLevel'];
    $myplayer['clan_tag'] = $player['clan']['tag'];
    $myplayer['clan_name'] = $player['clan']['name'];
    $heroes = processHeroes($player['heroes']);
    foreach ($heroes as $key => $val) {
        $myplayer[$key] = $val;
    }
    return $myplayer;
}

function processHeroes($heroes){
    $myheroes = array("heroes_aq"=>"","heroes_bk"=>"","heroes_gw"=>"");
    foreach ($heroes as $key => $val) {
        if($val['village'] == "home") {
            switch ($val['name']) {
                case "Barbarian King":
                    $myheroes['heroes_bk'] = $val['level'];
                    break;
                case "Archer Queen":
                    $myheroes['heroes_aq'] = $val['level'];
                    break;
                case "Grand Warden":
                    $myheroes['heroes_gw'] = $val['level'];
                    break;
            }
        }
    }
    return $myheroes;
}

function getPlayerAPI($player_tag){
    $enc_tag = urlencode($player_tag);
    $url = "https://api.clashofclans.com/v1/players/$enc_tag";
    $apikey = API_TOKEN;
    $httpheader = array('authorization: Bearer '.$apikey, 'Accept: application/json');
    $pingresult = PushLead(
        "" //requestData
        , $url //url
        , "" //POST
        , 60 //connect timeout
        , $httpheader //http header
        );
    return $pingresult;
}

function insClan($con, $clan_id, $data){
    $sql = "INSERT IGNORE INTO clan_members (id, clan_id, name, player_tag, townhall, aq, bk, gw) 
        VALUES (
        '',
        '".$con->real_escape_string($clan_id)."',
        '".$con->real_escape_string($data['name'])."',
        '".$con->real_escape_string($data['tag'])."',
        '".$con->real_escape_string($data['townHallLevel'])."',
        '".$con->real_escape_string($data['heroes_aq'])."',
        '".$con->real_escape_string($data['heroes_bk'])."',
        '".$con->real_escape_string($data['heroes_gw'])."'
        )";
    $con->query($sql);
}
