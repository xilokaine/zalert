<?php




include(dirname(__FILE__).'/../models/zalert.php');

// echo "voila : ".$_POST['id'];




$trigger = $api->triggers_details($_GET['id']);


// var_dump($trigger);
header('Content-type: application/json');
echo json_encode($trigger);








?>


