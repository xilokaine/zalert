<?PHP


//On inclut le modèle
include(dirname(__FILE__).'/../models/zalert.php');



if ( isset ($_GET['json'])) {

	//$hostgroups = $api->groups_by_name();

	$retour = array(
	    // 'age'    => strtoupper($_GET['age']),
	    'date'      => date('d/m/Y H:i:s'),
	    'phpversion' => phpversion(),
	    'team' => $_GET['team']
	    // 'regex'=> $_GET['regex']
	    //'groups' => $hostgroups
	);

	 
	// Envoi du retour (on renvoi le tableau $retour encodé en JSON)
	header('Content-type: application/json');
	echo json_encode($retour);


//NOW ON VA CHARGER LES TRIGGERS DES GROUPES.


	//$groups = hostgroups($_GET['age'], $_GET['regex']);

		// $subgroups = $api->subgroups_by_name($_GET['team']);
		// include(dirname(__FILE__).'/../views/zalert_subgroups.php');

}

if (!isset ($_GET['json'])) {
	$hostgroups = $api->groups_by_name();
	include(dirname(__FILE__).'/../views/zalert.php');
}


?>