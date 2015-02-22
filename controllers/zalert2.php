<?php


include(dirname(__FILE__).'/../models/zalert.php');



$tab = $api->triggers_by_groups2($_POST['team'],$_POST['min_severity'],$_POST['regex'],$_POST['regex2']);

// print "<pre>";
// var_dump($tab);
// print "</pre>";


?>


<!-- <div id="dialog-message" style="font-size: 10px;" title="Download complete"> -->
<div id="dialog-message" title="Download complete">
<!-- <p>
<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>

</p> -->
</div>

<div id="detail"></div>

<!-- style="font-size: 80%;"
height="50%" width="80%"  -->

<!-- <button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
 -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>


<!-- <table id="example" class="display" cellspacing="0" width="100%" style="font-size:10px;"> -->
<table id="example" class="display" cellspacing="0" width="100%">


 <thead>
            <tr>
                <th>Action</th>
                <th>Group</th>
                <th>Server</th>
                <th>lastChange</th>
                <th>TriggerName</th>
                <th>Priority</th>
                
            </tr>
 </thead>
        <tfoot>
            <tr>
                <th>Action</th>
                <th>Group</th>
                <th>Server</th>
                <th>lastChange</th>
                <th>TriggerName</th>
                <th>Priority</th>
                
            </tr>
        </tfoot>
 <tbody>

<?php

$cpt=0;
foreach ($tab as $group => $hosts) {
	// echo '<div class="bg-info">';
	

	// print '<h4>'.$group.' '.count($hosts).'</h4>';
	foreach ($hosts as $host => $value) {
			
// <tr>
//   <td class="active">...</td>
//   <td class="success">...</td>
//   <td class="warning">...</td>
//   <td class="danger">...</td>
//   <td class="info">...</td>
// </tr>


if ($value['priority'] == 0)
	$cl = 'default';
elseif ($value['priority'] == 1)
	$cl = 'info';
elseif ($value['priority'] == 2 or $value['priority'] == 3 OR $value['priority'] == 4) 
	$cl = 'warning';
elseif ($value['priority'] >= 5)
	$cl = 'danger';
else
	$cl = '';


     		echo '<tr>';
      print '<td><button type="button" id="toto" class="btn btn-primary btn-xs">Acknowledge</button></td>';
			print '<td>'.$group.'</td>';
			print '<td>'.$host.'</td>';
			print '<td>'.$value['date'].'</td>';
			
 // <span class="label label-'.$cl.'>Default</span>
   			print '<td><button type="button" class="btn btn-primary btn-xs test2" value='.$value['triggerid'].'>show events</button>';
        print ' <button type="button" class="btn btn-'.$cl.' btn-xs test" value='.$value['triggerid'].'>'.$value['description'].'</button></td>';


			
			
			print '<td>'.$value['priority'].'</td>';
			echo '</tr>';
	}

}


?>

 </tbody>
</table>




<script>

jQuery(document).ready(function($){
 $('#example').dataTable({

    "bFilter" : false,
    // "bInfo" : false,
 	// "bJQueryUI": true,
 	      // "bProcessing" : true,
  //         "bDestroy" : true,
  //         "bAutoWidth" : true,
  //         "sScrollY" : "500",
  //         "sScrollX" : "100%",
  //         "bScrollCollapse" : true,
  //         "bSort" : true,
  //         "sPaginationType" : "full_numbers",
  //         "iDisplayLength" : 25,
  //         "bLengthChange" : false,
  //      	  "sPaginationType": "full_numbers",

  //       "paging":         true,
  //       "info":     false
     }



 	);

 	 jQuery(".test").click(function(er){
      // $('#myModal').modal()
      console.log($(this).val());

      jQuery.getJSON('controllers/trigger_details.php', 
      	{id: $(this).val()}, 
      	function(data) {
        	// console.log(data);
        	// console.log(data.expression);
        	// $('#detail').hide();
         //        jQuery('#detail').html('')
         //            $('#detail').append('TriggerID: '+data[0].triggerid+'<br/>')
         //            $('#detail').append('TriggerExpression: '+data[0].expression+'<br/>');
         //            $('#detail').append('TriggerExpression: '+data[0]+'<br/>');                    
         //        $('#detail').fadeIn();



         	// $('#detail').hide();
         	$('#dialog-message').html('')
         	$.each(data[0], function(index, val) {
         		$('#dialog-message').append(index+':'+val+' '+'<br/>')
         	});
         	 $( "#dialog-message" ).dialog({
				modal: true,
				buttons: {
					Ok: function() {
						$( this ).dialog( "close" );
					}
				}
			});


			// $('#detail').hide();
   //       	$('#detail').html('')
         	
   //       	$.each(data[0], function(index, val) {
   //       		$('#detail').append(index+':'+val+' '+'<br/>')
   //       	});


			// $('#detail').fadeIn();


      	});
      
    });


	 jQuery(".test2").click(function(er){
      // $('#myModal').modal()
      // console.log($(this).val());

      jQuery.getJSON('controllers/events_detail.php', 
      	{id: $(this).val()}, 
      	function(data) {
        	// console.log(data);
        

        	tab = '<table id="detail_ev"><thead><tr><th>eventid</th>';
        	tab += '<th>source</th>';
			tab += '<th>object</th>';
			tab += '<th>objectid</th>';
			tab += '<th>clock</th>';
			tab += '<th>value</th>';
			tab += '<th>ack</th>';
			tab += '<th>ns</th></tr></thead>';



      

   			$.each(data, function(i){
   				tab += '<tr>';
   				$.each(data[i], function(index, val) {
   							tab += '<td>'+val+'</td>';
         		});
				tab += '</tr>';
   			});


      		tab += '<tfoot><tr><th>eventid</th>';
        	tab += '<th>source</th>';
			tab += '<th>object</th>';
			tab += '<th>objectid</th>';
			tab += '<th>clock</th>';
			tab += '<th>value</th>';
			tab += '<th>ack</th>';
			tab += '<th>ns</th></tr></tfoot>';



         	$('#dialog-message').html('');
         	$('#dialog-message').append(tab);

         	$('#detail_ev').dataTable();



   	// 		$( "#dialog-message" ).dialog({
				// modal: true,
				// buttons: {
				// 	Ok: function() {
				// 		$( this ).dialog( "close" );
				// 	}
				// }
         	// $.each(data, function(index, val) {
         	// 	console.log("index: "+index+" val: "+val);
         	// });
    	 $( "#dialog-message" ).dialog({
				modal: true,
				buttons: {
					Ok: function() {
						$( this ).dialog( "close" );
					}
				}
			});




      	});
      
    });




});

</script>

