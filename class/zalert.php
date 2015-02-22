<?PHP


include(dirname(__FILE__).'/../PhpZabbixApi_Library/ZabbixApiAbstract.class.php');
include(dirname(__FILE__).'/../PhpZabbixApi_Library/ZabbixApi.class.php');



class zalert_zabbix  extends ZabbixApi {


	private $_url='http://localhost/zabbix/api_jsonrpc.php';
	private $_login='martinezpa2_adm';
	private $_pass='zabbix';


	public function groups_by_name2() 
	{

			$this->__construct($this->_url, $this->_login,$this->_pass);
			$hostgroups = $this->hostgroupGet(array(
           	 'output' => array('name'),
           	 //'search' => array('name' => $group)

       		 ));


			$groups = array();
        	foreach($hostgroups as $group) {
            	$groups[] = $group->name;
            }
            //json_encode($groups);
			return $groups;

	}

	public function groups_by_name() 
	{

			$this->__construct($this->_url, $this->_login,$this->_pass);
			$hostgroups = $this->hostgroupGet(array(
           	 'output' => array('name','groupid'),
           	 //'search' => array('name' => $group)

       		 ));


			return $hostgroups;

	}






	public function primary_groups_by_name() 
	{

			$this->__construct($this->_url, $this->_login,$this->_pass);
			$hostgroups = $this->hostgroupGet(array(
           	 'output' => array('name'),
           	 //'search' => array('name' => $group)

       		 ));


			$groups = array();
        	foreach($hostgroups as $group) {
        		if ( preg_match('/_/', $group->name) ){
                	unset($groups[array_search($group, $groups)]);
                	continue;
            	}

            	// $groups[] = $group->groupid;
            	$groups[] = $group->name;
            }

			return $groups;

	}

	public function subgroups_by_name($group) 
	{

			$this->__construct($this->_url, $this->_login,$this->_pass);
			$hostgroups = $this->hostgroupGet(array(
           	 'output' => array('name'),
           	 'search' => array('name' => $group)

       		 ));


			$groups = array();
        	foreach($hostgroups as $group) {
            	// $groups[] = $group->groupid;
            	$groups[] = $group->name;
            }

            //var_dump($groups);

			return $groups;

	}



	public function groups_by_id($group) 
	{

			$this->__construct($this->_url, $this->_login,$this->_pass);
			$hostgroups = $this->hostgroupGet(array(
           	 'output' => array('groupid'),
           	 'search' => array('name' => $group)

       		 ));


			$groups = array();
        	foreach($hostgroups as $group)
            	 $groups[] = $group->groupid;


			return $groups;

	}



	public function triggers_by_groups($groupids,$regex) 
	{

			$this->__construct($this->_url, $this->_login,$this->_pass);
			


		$triggers = $this->triggerGet(array(
            'output' => 'extend',
            'groupids' => $groupids,
            'selectHosts' => array('host'),
            'selectGroups' => array('name'),
            'maintenance' => 0,
            'expandDescription' => 1,
            // 'expandExpression' => 1,
            //'lastChangeSince' => time() - (3600*24),
            'sortfield' => array('lastchange', 'description'),
            'sortorder' => 'DESC',
            'min_severity' => 2,
            //'countOutput' => 1,
            //'templateids' => 100100000010118,
            'only_true' => 1
        ));

		// var_dump($triggers);



            echo '<div class="alert alert-info">';


        	foreach($triggers as $trigger){
        	if ( ! preg_match('/'.$regex.'/', $trigger->description) ){
                unset($triggers[array_search($trigger, $triggers)]);
                continue;
            }

            	print "<br>";

        		if ($trigger->priority == 1)
                    echo '<div class="btn btn-xs btn-primary" style="width:800px">';
                elseif ($trigger->priority == 2 OR $trigger->priority == 3)
                    echo '<div class="btn btn-xs btn-warning" style="width:800px">';
                elseif ($trigger->priority >= 4)
                    echo '<div class="btn btn-xs btn-danger" style="width:800px">';
                else
                    echo '<div class="btn btn-xs btn-default" style="width:800px">';
        		 // var_dump($trigger);
        		foreach($trigger->hosts as $host) {
        				print $host->host." ";
        		}
        		
        		// 	var_dump($host);
        		// }
        		print $trigger->description;
        		print "</div>";
        	}
            	 //$groups[] = $group->groupid;

        	echo '</div>';
			//return $groups;

	}



	public function triggers_by_groups2($groupids,$min_severity,$regex,$regex2) 
	{

		$this->__construct($this->_url, $this->_login,$this->_pass);
			


		$triggers = $this->triggerGet(array(
            'output' => 'extend',
            'groupids' => $groupids,
            'selectHosts' => array('host'),
            'selectGroups' => array('name'),
            'maintenance' => 0,
            'expandDescription' => 1,
            // 'expandExpression' => 1,
            //'lastChangeSince' => time() - (3600*24),
            'sortfield' => array('lastchange', 'description'),
            'sortorder' => 'DESC',
            'min_severity' => $min_severity,
            //'countOutput' => 1,
            //'templateids' => 100100000010118,
            'only_true' => 1
        ));

		if (1==2){
			echo "<pre>";
			var_dump($triggers);
			echo "</pre>";
		}


		$groups = $this->hostgroupGet(array(
			'output' => array('name'),
			'groupids' => $groupids 
			));

		
		//var_dump($groups);

		$return = array();





            //heure : TAB GRP : HOST : TRIGGER : STATE : FLAG
        	foreach($triggers as $trigger){
	        	if ( ! preg_match('/'.$regex.'/', $trigger->description) ){
	                unset($triggers[array_search($trigger, $triggers)]);
	                continue;
	            }


	            if ($regex2 != "") {

		            if ( preg_match('/'.$regex2.'/', $trigger->description) ){
		                unset($triggers[array_search($trigger, $triggers)]);
		                continue;
		            }
	            }


	            foreach ($groups as $group) {
	            	// print "$trigger->groupid, $group->groupid";
 					if ($trigger->groupid == $group->groupid) {
 						// print "<br>".$group->name." ".$trigger->description."<br>";
 						//$return[$group->name];

 						foreach($trigger->hosts as $host) {
        		 			$return[$group->name][$host->host]['date']=$this->convert_date($trigger->lastchange);
        		 			$return[$group->name][$host->host]['description']=$trigger->description;
        		 			$return[$group->name][$host->host]['priority']=$trigger->priority;
        		 			$return[$group->name][$host->host]['triggerid']=$trigger->triggerid;
        		 			$return[$group->name][$host->host]['comments']=$trigger->comments;
        				}
						
 					}
	            }

        	}

        	return $return;
	}


	public function triggers_details($id) 
	{

		$this->__construct($this->_url, $this->_login,$this->_pass);
			


		$trigger = $this->triggerGet(array(
            'output' => 'extend',
            'triggerids' => $id
        ));

		return $trigger;

	}



	public function events_detail($id) 
	{

		$this->__construct($this->_url, $this->_login,$this->_pass);
			


		$events = $this->eventGet(array(
            'output' => 'extend',
            'triggerids' => $id
        ));

		return $events;

	}



    public function json_triggers_by_groups($groupids,$value,$min_severity,$regex,$regex2) 
    {
            // echo gettype($groupids);

        $this->__construct($this->_url, $this->_login,$this->_pass);
            
        
            $groupids = explode(',', $groupids);
        // var_dump(array($groupids));

            $spec = array (
                 'output' => 'extend',
            'groupids' => $groupids,
            // 'group' => $groupids,
            'selectHosts' => array('host'),
            'selectGroups' => array('name'),
            'maintenance' => 0,
            'expandDescription' => 1,
            // 'expandExpression' => 1,
            //'lastChangeSince' => time() - (3600*24), 
            'sortfield' => array('lastchange', 'description'),
            'sortorder' => 'DESC',
            'min_severity' => $min_severity
            //'countOutput' => 1,
            //'templateids' => 100100000010118,

                );

            if ($value == 1 )
                $spec["only_true"] = 1;

            // var_dump($spec);

        $triggers = $this->triggerGet($spec);

        if (1==2){
            echo "<pre>";
            var_dump($triggers);
            echo "</pre>";
        }


        $groups = $this->hostgroupGet(array(
            'output' => array('name'),
            'groupids' => $groupids 
            ));

        
        //var_dump($groups);

        $return = array();





            //heure : TAB GRP : HOST : TRIGGER : STATE : FLAG

            foreach($triggers as $trigger){
                if ( ! preg_match('/'.$regex.'/', $trigger->description) ){
                    unset($triggers[array_search($trigger, $triggers)]);
                    continue;
                }

                // echo "regex =>".$regex."<br>";

                if ($regex2 != "") {

                    if ( preg_match('/'.$regex2.'/', $trigger->description) ){
                        unset($triggers[array_search($trigger, $triggers)]);
                        continue;
                    }
                }


                // print array_search($trigger, $triggers)."<br>";

                $triggers[array_search($trigger, $triggers)]->date = $this->convert_date($triggers[array_search($trigger, $triggers)]->lastchange);
                // foreach ($groups as $group) 
                //     if ($trigger->groupid == $group->groupid) 
                //         $triggers[0]["groupname"] = $group->name;
                foreach ($trigger->groups as $group){
                    if ($group->groupid == $trigger->groupid)
                   // $triggers[array_search($trigger, $triggers)]->groupeName = $trigger->groups[0]->name;
                   $triggers[array_search($trigger, $triggers)]->groupeName = $group->name;
           }
                    // print $group->name."<br>";
                    //$triggers = $group->name; 



        }

            return $triggers;
            // echo "<pre>";
            // var_dump($triggers);
            // echo "</pre>";
    }




	public function convert_date($date)
	{

		$epoch = $date;
		$dt = new DateTime("@$epoch"); // convert UNIX timestamp to PHP DateTime
		return $dt->format('Y-m-d H:i:s');


	}

}



class zalert_sql {


    private $_host = "192.168.0.16";
    private $_port = "3306";
    private $_bd = "zabbix";
    private $_user = "root";
    private $_passwd = "zabbix";



    public function getTest(){

    try{

    $connexion = new PDO('mysql:host='.$this->_host.';port='.$this->_port.';dbname='.$this->_bd, $this->_user, $this->_passwd);
    $resultats = $connexion->query("select * from triggers LIMIT 10");
    
    $resultats->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le résultat soit récupérable sous forme d'objet
    while( $ligne = $resultats->fetch() ) // on récupère la liste des membres
    {
        echo $ligne->description.'<br />'; // on affiche les membres
    }
    $resultats->closeCursor(); // on ferme le curseur des résultats


    }catch(Exception $e){
        echo "Erreur : ".$e->getMessage()."<br />";
        echo "Code : ".$e->getCode()."<br />";


    }



    }






}


class zalert_filter extends zalert_sql {










}

class filter{

    private $_name;
    private $_property;
    private $_host;
    private $_trigger;
    private $_groups;



    public function hydrate(array $data) 
    {
        $this->_name = $data['name'];
        $this->_property = $data["property"];
        $this->_host = $data["host"];
        $this->_trigger = $data["trigger"];
        $this->_groups = $data["groups"];

    }





}




?>