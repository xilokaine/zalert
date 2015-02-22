    <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zalert!</title>

    <!-- Bootstrap -->
    <link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-3.1.1-dist/css/bootstrap.theme.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>

        <!-- Fixed navbar -->

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>

          </button>
          <a class="navbar-brand" href="#">Zalert!</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>

            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>

                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container theme-showcase" role="main">
    
    <br><br><br><br>


<?php

// load ZabbixApi
require 'PhpZabbixApi_Library/ZabbixApiAbstract.class.php';
require 'PhpZabbixApi_Library/ZabbixApi.class.php';


generate_table ('prd-linux-solaris-mco_sensible', '/LINUX.ALL|SOLARIS.ALL|MIN/');
generate_table ('prd-linux-solaris-mco', '/LINUX.ALL|SOLARIS.ALL|MIN/');
generate_table ('prd-linux-solaris-mco_grid', '/LINUX.ALL|SOLARIS.ALL|MIN/');
generate_table ('prd-linux-solaris-mco_standard', '/LINUX.ALL|SOLARIS.ALL|MIN/');
generate_table ('prd-linux-solaris-mco_nosup', '/LINUX.ALL|SOLARIS.ALL|MIN/');


// generate_table ('prd-metrologie-instru', '/MIN/');
// generate_table ('prd-metrologie-instru_bem-prd', '/MIN/');
// generate_table ('prd-metrologie-instru_zabbix-prd', '/MIN/');

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
                
                // echo "<br>";
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
                // printf("[%s] ", $dt->format('Y-m-d H:i:s'));
            
                foreach ($trigger->hosts as $host) {
                    printf("<strong> %s </strong>", $host->host);
                
                }
                    

                
                 // printf("Trigger : %s<br>", $trigger->description);
                 
                 
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


?> 





</div>



  </body>
</html>