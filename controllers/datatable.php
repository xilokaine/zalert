<?php

include(dirname(__FILE__).'/../class/zalert.php');

// error_reporting(E_ALL);
 // ini_set("display_errors",	 0); 


$api = new zalert_zabbix;
// triggers_by_groups2($_POST['team'],$_POST['min_severity'],$_POST['regex'],$_POST['regex2']);
// $triggers = $api->json_triggers_by_groups(100100000000015,0,'','');
// echo $_GET['groupid'];
$triggers = $api->json_triggers_by_groups($_GET['groupid'],$_GET['value'],0,'','');


header('Content-type: application/json');
echo json_encode($triggers);





?>





