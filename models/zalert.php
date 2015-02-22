
<?php


include(dirname(__FILE__).'/../class/zabbix.php');



$api = new zalert_zabbix();


function get_triggers_by_groups($group, $regex) 
{
// load ZabbixApi
//require '../PhpZabbixApi_Library/ZabbixApiAbstract.class.php';
//require '../PhpZabbixApi_Library/ZabbixApi.class.php';
    try {

        // connect to Zabbix API
        $api = new ZabbixApi('http://localhost/zabbix/api_jsonrpc.php', 'martinezpa2_adm', 'zabbix');


        $hostgroups = $api->hostgroupGet(array(
            'output' => 'extend',
            //'filter' => array('name' => $group)
            'search' => array('name' => $group)
        ));


        //recherche des groupids
        $groups = array();
        foreach($hostgroups as $group)
         $groups[] = $group->groupid;         

        //var_dump($groups);


        $triggers = $api->triggerGet(array(
            'output' => 'extend',
            'groupids' => $groups,
            'selectHosts' => array('host'),
            'selectGroups' => array('name'),
            'maintenance' => 0,
            'expandDescription' => 1,
            // 'expandExpression' => 1,
            //'lastChangeSince' => time() - (3600*24),
            'sortfield' => array('lastchange', 'description'),
            'sortorder' => 'DESC',
            'min_severity' => 0,
            //'countOutput' => 1,
            //'templateids' => 100100000010118,
            'only_true' => 1
        ));

        // echo "<pre>";
        // var_dump($triggers);
        // echo "</pre>";
        //$cpt=0;
        

        echo "before :".count($triggers);



        //$tab_regex = explode ('|', $regex);




        //On reduit le tableau 
        $overview = array();
        foreach ($triggers as $trigger) {
            //delete trigger of table if its not match with regex

            if ( ! preg_match('/'.$regex.'/', $trigger->description) ){
                unset($triggers[array_search($trigger, $triggers)]);
                continue;
            }
                           
            
            //$trigger->regex = $regex;

             $epoch = $trigger->lastchange;
             $dt = new DateTime("@$epoch"); // convert UNIX timestamp to PHP DateTime
                // echo $dt->format('Y-m-d H:i:s');

            foreach ($trigger->hosts as $host) {
                //printf("<strong> %s </strong>", $host->host);

            }

            //on verifie pour chaque groupe.
            //CHARGE INMPORTANTE.

            
            foreach ($trigger->groups as $trigger_group) {  
                foreach ($groups as $group) {
                       if ($group == $trigger_group->groupid) {

                        if (array_key_exists($trigger_group->name.$trigger->priority , $overview)) {
                              $overview[$trigger_group->name.$trigger->priority] = $overview[$trigger_group->name.$trigger->priority]+1;  
                          }else{
                                $overview[$trigger_group->name.$trigger->priority] = 1;
                             
                        }

                            
                       } 

                }
            }


            printf("Trigger : %s<br>", $trigger->description);
            print "<br>";

        }

        echo "<pre>";
        var_dump($overview);
        echo "</pre>";

        echo count($triggers);
        // echo "after :".count($triggers);
        // echo "<pre>";
        // var_dump($triggers);
        // echo "</pre>";
    } catch(Exception $e) {

         echo $e->getMessage();

    }

}



function get_triggers_by_groups_backup($group, $regex) 
{
// load ZabbixApi
require 'PhpZabbixApi_Library/ZabbixApiAbstract.class.php';
require 'PhpZabbixApi_Library/ZabbixApi.class.php';
    try {

        // connect to Zabbix API
        $api = new ZabbixApi('http://localhost/zabbix/api_jsonrpc.php', 'martinezpa2_adm', 'zabbix');


        $hostgroups = $api->hostgroupGet(array(
            'output' => 'extend',
            //'filter' => array('name' => $group)
            'search' => array('name' => $group)
        ));


        //recherche des groupids
        $groups = array();
        foreach($hostgroups as $group)
         $groups[] = $group->groupid;         

        //var_dump($groups);


        $triggers = $api->triggerGet(array(
            'output' => 'extend',
            'groupids' => $groups,
            'selectHosts' => array('host'),
            'selectGroups' => array('name'),
            'maintenance' => 0,
            'expandDescription' => 1,
            // 'expandExpression' => 1,
            //'lastChangeSince' => time() - (3600*24),
            'sortfield' => array('lastchange', 'description'),
            'sortorder' => 'DESC',
            'min_severity' => 0,
            //'countOutput' => 1,
            //'templateids' => 100100000010118,
            'only_true' => 1
        ));

        // echo "<pre>";
        // var_dump($triggers);
        // echo "</pre>";
        //$cpt=0;
        

        echo "before :".count($triggers);



        //$tab_regex = explode ('|', $regex);




        //On reduit le tableau 
        $overview = array();
        foreach ($triggers as $trigger) {
            //delete trigger of table if its not match with regex

            if ( ! preg_match('/'.$regex.'/', $trigger->description) ){
                unset($triggers[array_search($trigger, $triggers)]);
                continue;
            }
                           
            
            //$trigger->regex = $regex;

             $epoch = $trigger->lastchange;
             $dt = new DateTime("@$epoch"); // convert UNIX timestamp to PHP DateTime
                // echo $dt->format('Y-m-d H:i:s');

            foreach ($trigger->hosts as $host) {
                //printf("<strong> %s </strong>", $host->host);

            }

            //on verifie pour chaque groupe.
            //CHARGE INMPORTANTE.

            
            foreach ($trigger->groups as $trigger_group) {  
                foreach ($groups as $group) {
                       if ($group == $trigger_group->groupid) {

                        if (array_key_exists($trigger_group->name.$trigger->priority , $overview)) {
                              $overview[$trigger_group->name.$trigger->priority] = $overview[$trigger_group->name.$trigger->priority]+1;  
                          }else{
                                $overview[$trigger_group->name.$trigger->priority] = 1;
                             
                        }

                            
                       } 

                }
            }


            printf("Trigger : %s<br>", $trigger->description);
            print "<br>";

        }

        echo "<pre>";
        var_dump($overview);
        echo "</pre>";

        echo count($triggers);
        // echo "after :".count($triggers);
        // echo "<pre>";
        // var_dump($triggers);
        // echo "</pre>";
    } catch(Exception $e) {

         echo $e->getMessage();

    }

}

function generate_table($group, $regex) 
{
    try {

        // connect to Zabbix API
        $api = new ZabbixApi('http://localhost/zabbix/api_jsonrpc.php', 'martinezpa2_adm', 'zabbix');
        

        $hostgroups = $api->hostgroupGet(array(
            'output' => 'extend',
            'filter' => array('name' => $group)
        ));

        echo '<div class="alert alert-info">';
        $groups = array();
        foreach($hostgroups as $group){
            printf("<strong>[%s] </strong>", $group->name);
             //printf("id:%d name:%s\n", $graph->graphid, $graph->name);
             // var_dump($group);
             $groups[] = $group->groupid;
         
         }
             
            //var_dump($groups);
            
        $triggers = $api->triggerGet(array(
            'output' => 'extend',
            'groupids' => $groups,
            'selectHosts' => array('host'),
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

        //TRIGGERS VIEW
        
        //echo " count errors : ".count($triggers)."<br>";
        
        $cpt=0;
            foreach ($triggers as $trigger) {
    
                    
                 if ( ! preg_match($regex, $trigger->description) ){
                    continue;
                 }

                
                        
                $cpt++;
                
                echo "<br>";
                if ($trigger->priority == 1)
                    echo '<div class="btn btn-xs btn-primary">';
                elseif ($trigger->priority == 2 OR $trigger->priority == 3)
                    echo '<div class="btn btn-xs btn-warning">';
                elseif ($trigger->priority >= 4)
                    echo '<div class="btn btn-xs btn-danger">';
                else
                    echo '<div class="btn btn-xs btn-default">';
                
                
                
                
                
                printf("[%d]", $cpt);        
                printf("|Priority : %s ", $trigger->priority );
                printf("|status : %s ", $trigger->status);
            
                $epoch = $trigger->lastchange;
                $dt = new DateTime("@$epoch"); // convert UNIX timestamp to PHP DateTime
                printf("[%s] ", $dt->format('Y-m-d H:i:s'));
            
                foreach ($trigger->hosts as $host) {
                    printf("<strong> %s </strong>", $host->host);
                
                }
                    

                
                 printf("Trigger : %s<br>", $trigger->description);
                 
                 
                 echo "</div>";

            }
            echo "<br>Count errors after filter : ".$cpt;
            echo '</div>';
    } catch(Exception $e) {

        echo $e->getMessage();

    }
    return $cpt;
}



function generate_table2($groups, $regex) 
{
    try {

        // connect to Zabbix API
        $api = new ZabbixApi('http://localhost/zabbix/api_jsonrpc.php', 'martinezpa2_adm', 'zabbix');
        


            
        $triggers = $api->triggerGet(array(
            'output' => 'extend',
            'groupids' => $groups,
            'selectHosts' => array('host'),
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

        //TRIGGERS VIEW
        
        //echo " count errors : ".count($triggers)."<br>";
        
        $cpt=0;
            foreach ($triggers as $trigger) {
    
                    
                 if ( ! preg_match($regex, $trigger->description) ){
                    continue;
                 }

                
                        
                $cpt++;
                
                echo "<br>";
                if ($trigger->priority == 1)
                    echo '<div class="btn btn-xs btn-primary">';
                elseif ($trigger->priority == 2 OR $trigger->priority == 3)
                    echo '<div class="btn btn-xs btn-warning">';
                elseif ($trigger->priority >= 4)
                    echo '<div class="btn btn-xs btn-danger">';
                else
                    echo '<div class="btn btn-xs btn-default">';
                
                
                
                
                
                printf("[%d]", $cpt);        
                printf("|Priority : %s ", $trigger->priority );
                printf("|status : %s ", $trigger->status);
            
                $epoch = $trigger->lastchange;
                $dt = new DateTime("@$epoch"); // convert UNIX timestamp to PHP DateTime
                printf("[%s] ", $dt->format('Y-m-d H:i:s'));
            
                foreach ($trigger->hosts as $host) {
                    printf("<strong> %s </strong>", $host->host);
                
                }
                    

                
                 printf("Trigger : %s<br>", $trigger->description);
                 
                 
                 echo "</div>";

            }
            echo "<br>Count errors after filter : ".$cpt;
            echo '</div>';
    } catch(Exception $e) {

        echo $e->getMessage();

    }
    return $cpt;
}



function generate_table_backup($group, $regex) 
{
    try {

        // connect to Zabbix API
        $api = new ZabbixApi('http://localhost/zabbix/api_jsonrpc.php', 'martinezpa2_adm', 'zabbix');
        

        $hostgroups = $api->hostgroupGet(array(
            'output' => 'extend',
            'filter' => array('name' => $group)
        ));

        echo '<div class="alert alert-info">';
        $groups = array();
        foreach($hostgroups as $group){
            printf("<strong>[%s] </strong>", $group->name);
             //printf("id:%d name:%s\n", $graph->graphid, $graph->name);
             // var_dump($group);
             $groups[] = $group->groupid;
         
         }
             
            //var_dump($groups);
            
        $triggers = $api->triggerGet(array(
            'output' => 'extend',
            'groupids' => $groups,
            'selectHosts' => array('host'),
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

        //TRIGGERS VIEW
        
        //echo " count errors : ".count($triggers)."<br>";
        
        $cpt=0;
            foreach ($triggers as $trigger) {
    
                    
                 if ( ! preg_match($regex, $trigger->description) ){
                    continue;
                 }

                
                        
                $cpt++;
                
                echo "<br>";
                if ($trigger->priority == 1)
                    echo '<div class="btn btn-xs btn-primary">';
                elseif ($trigger->priority == 2 OR $trigger->priority == 3)
                    echo '<div class="btn btn-xs btn-warning">';
                elseif ($trigger->priority >= 4)
                    echo '<div class="btn btn-xs btn-danger">';
                else
                    echo '<div class="btn btn-xs btn-default">';
                
                
                
                
                
                // printf("[%d]", $cpt);        
                // printf("|Priority : %s ", $trigger->priority );
                // printf("|status : %s ", $trigger->status);
            
                $epoch = $trigger->lastchange;
                $dt = new DateTime("@$epoch"); // convert UNIX timestamp to PHP DateTime
                printf("[%s] ", $dt->format('Y-m-d H:i:s'));
            
                foreach ($trigger->hosts as $host) {
                    printf("<strong> %s </strong>", $host->host);
                
                }
                    

                
                 printf("Trigger : %s<br>", $trigger->description);
                 
                 
                 echo "</div>";

            }
            echo "<br>Count errors after filter : ".$cpt;
            echo '</div>';
    } catch(Exception $e) {

        echo $e->getMessage();

    }
    return $cpt;
}


function hostgroups_backup($group,$regex) 
{

    echo "recherche pour ".$group;
    try {

            // connect to Zabbix API
            $api = new ZabbixApi('http://localhost/zabbix/api_jsonrpc.php', 'martinezpa2_adm', 'zabbix');
            $hostgroups = $api->hostgroupGet(array(
            'output' => array($group),
            'search' => array('name' => $group)

        ));

        
        echo "<pre>";
        var_dump($hostgroups);
        echo "</pre>";
    
    } catch(Exception $e) {

        echo $e->getMessage();

    }


    get_triggers_by_groups($group, $regex);

}


function hostgroups($group) 
{
    try {
            // connect to Zabbix API
            $api = new natixis_zabbix();
            $hostgroups = $api->groups_by_name($group);
            var_dump($hostgroups);
            
    } catch(Exception $e) {

        echo $e->getMessage();

    }


   // get_triggers_by_groups($group, $regex);

}


function option_hostgroups($group) 
{
    try {
            // connect to Zabbix API
            $api = new natixis_zabbix();
            $hostgroups = $api->groups_by_name($group);
           
            
    } catch(Exception $e) {

        echo $e->getMessage();

    }


   // get_triggers_by_groups($group, $regex);

}
?> 

