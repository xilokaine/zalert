<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zalert!</title>



    <!-- jQuery -->
    <link href="jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-3.1.1-dist/css/bootstrap-theme.min.css" rel="stylesheet">


    <!-- lou multi select  -->
    <link href="chosen_v1.1.0/chosen.css" rel="stylesheet">
 
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="jquery-ui-1.10.4.custom/js/jquery-1.10.2.js"></script>
  <script src="jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
 
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>


    <!-- test -->
    
    <script src="chosen_v1.1.0/chosen.jquery.js"></script>


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

</div>




 <!-- DEBUT -->

 

<script>


function ajaxFunction(){
  var ajaxRequest;  // The variable that makes Ajax possible!
  
  try{
    // Opera 8.0+, Firefox, Safari
    ajaxRequest = new XMLHttpRequest();
  } catch (e){
    // Internet Explorer Browsers
    try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try{
        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e){
        // Something went wrong
        alert("Your browser broke!");
        return false;
      }
    }
  }

  // Create a function that will receive data sent from the server
  ajaxRequest.onreadystatechange = function(){
    if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById('ajaxDiv');
      ajaxDisplay.innerHTML = ajaxRequest.responseText;
    }
  }
  // Now get the value from user and pass it to
  // server script.
  var age = document.getElementById('age').value;
  var regex = document.getElementById('regex').value;
  var team = document.getElementById('team').value;
  
  alert(team[1]);
  // var myselect = document.getElementById('myselect').value;
  
  var queryString = "?age=" + age;
  queryString += "&regex=" + regex ;
  queryString += "&team=" + team ;
  // queryString += "&myselect=" + myselect ;
  console.log(team);
  ajaxRequest.open("GET", "controllers/zalert.php" + queryString, true);
  ajaxRequest.send(null); 
}
//-->
</script>



<hr>

groupe <input type='text' id='age' value='prd-metrologie-instru'/> <br />
REGEX <input type='text' id='regex' value='MIN' /> <br />





<em>Into This</em>
<select data-placeholder="Choose a group..." class="chosen-select" multiple style="width:350px;" tabindex="4" id="team">
<?php
foreach ($hostgroups as $group)
  echo '<option value="'.$group.'">'.$group.'</option>'."\n";
?>
</select>

<script>

$(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
</script>


<input type='button' onclick='ajaxFunction();' value='fouego' />


<div id="ajaxDiv">
  



</div>




  </body>
</html>