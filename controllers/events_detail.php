<?php




include(dirname(__FILE__).'/../models/zalert.php');

// echo "voila : ".$_POST['id'];




$events = $api->events_detail($_GET['id']);


// var_dump($trigger);
header('Content-type: application/json');
echo json_encode($events);








?>


