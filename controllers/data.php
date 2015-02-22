<?php
include(dirname(__FILE__).'/../class/zalert.php');


$api = new zalert_zabbix();

$hostgroups = $api->groups_by_name();

include(dirname(__FILE__).'/../views/datatable.php');




?>