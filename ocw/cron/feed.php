<?php 
require(dirname(dirname(__FILE__))."/includes.php");
$clan_lists = getOcwClanLists($con);
foreach ($clan_lists as $key => $clan) {
    $members = getClanMembersAPI($clan['clan_tag']);
    $mymembers = processMembers($members);
    foreach ($mymembers as $mkey => $val) {
        insClan($con, $clan['clan_id'], $val);
    }
}