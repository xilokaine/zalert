<?php
include(dirname(__FILE__).'/../views/bandeau.html');

?>


<script type="text/javascript">
	

$(document).ready(function($) {

	   // Setup - add a text input to each footer cell
    // $('#ZabbixTable tfoot th').each( function () {
    //     var title = $('#example thead th').eq( $(this).index() ).text();
    //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    // } );

	// $("#test").click(function(event) {
		var table = $('#ZabbixTable').dataTable( {
			  //   "scrollY":        500,
       		// "scrollCollapse": true,
       		  //"jQueryUI":       true,
       		'bSortCellsTop': true,
			'sDom': '<"top"l>rt<"bottom"ip><"clear">',
			// "stateSave": true,
			"ajax": "controllers/datatable.php?groupid="+$("#team").val()+"&value="+$("#value").val(),
    		'sAjaxDataProp': "",
    		"aoColumns": [

            	 { mData: "groupeName",
            	sTitle : "Group",
            	// sClass : "zalert",
            	sType : "string",
            	sWidth : "12%"
            	 },
             { mData: "hosts[, ].host",
             	sTitle : "Host",
             	sType : "string",
             	// sClass : "zalert",
             	sWidth : "8%"
         	},
         	 { mData: "description",
            	sTitle : "Trigger",
            	sWidth : "30%",
            	sType : "string"
            	// sClass : "zalert"
            	 },
              { mData: "comments",
              sTitle : "comments",
              sWidth : "30%",
              sType : "string"
              // sClass : "zalert"
               },

             { mData: "priority",
             sTitle : "Severity",
             sType : "numeric",
             // "asSorting": [ "desc" ],
             // sClass : "zalert",
             sWidth : "2%",
              "mRender": function ( data, type, full ) {
            		// console.dir(full);

            		// $("td").css("font-size","2");

            			// console.log($(this).parents('td').val());

	               			if (data == 0) {
               					return '<div class="label label-default">Not Classified</div>';

		               		} else if (data == 1) {
               					return '<div class="label label-primary">Information</div>';
               				}else if (data == 2) {
               					return '<div class="label label-warning">Warning</div>';
               					$(nTd).css('color', 'red');
               				}else if (data == 3) {
               					return '<div class="label label-warning">Average</div>';
               				}else if (data == 4) {
               					return '<div class="label label-warning">High</div>';
               				}else if (data == 5) {				
               					return '<div class="label label-danger">Disaster</div>';
               				}	

               			}
   				     
    			  
        	 },
          //    { mData: "groups[].name",
          //    sTitle : "group"
        	 // },
        	    { mData: "value",
             sTitle : "Problem",
             sType : "numeric",
             // sClass : "zalert",
             sWidth : "2%"
        	 },
       	    { mData: "status",
             sTitle : "Enabled",
             sType : "numeric",
             // sClass : "zalert",
             sWidth : "2%"
        	 },



             { mData: "date",
             sTitle : "Date",
             // sType : "date",
             // "asSorting": [ "desc" ],
             // sClass : "zalert",
             sWidth : "10%"
        	 }
        	 // ,
          //    { mData: "groups[].name",
          //    sTitle : "groups",
          //    sType : "string",
          //    sClass : "zalert"
        	 // }


        	 ],
  		
  			'sPaginationType': "full_numbers",
			// "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			// 'iDisplayLength':25,
			"asStripClasses": [ 'strip1', 'strip2', 'strip3' ]
			// "oLanguage": {
			// 	"sLengthMenu": "Afficher _MENU_ résultats par page",
			// 	'sProcessing': "Chargement...",
			// 	"sLoadingRecords": "Chargement...",
			// 	"sZeroRecords": "Aucun résultat.",
			// 	"sInfo": "Affichage _START_ de _END_ sur _TOTAL_ résultats",
			// 	"sInfoEmpty": "Affichage 0 de 0 sur 0 résultat",
			// 	"sInfoFiltered": "(filtré(s) depuis _MAX_ résultats)",
			// 	"sSearch": "Recherche",
			// 	'oPaginate': {
			// 		'sPrevious': "Précédente",
			// 		'sNext': "Suivante",
			// 		'sFirst': "Première",
			// 		'sLast': "Dernière"
			// 	}

			// }



		});
		// new $.fn.dataTable.FixedHeader( table );



			$('#Host').bind('keypress keyup', function(e) {
				if (e.keyCode != 13) return;
					table.fnFilter($(this).val(), 1, true);
			});



			$('#triggerName').bind('keypress keyup', function(e) {
				if (e.keyCode != 13) return;
					table.fnFilter($(this).val(), 2, true);
			});


			$('#team, #value').bind('change', function() {
				table.fnReloadAjax('controllers/datatable.php?groupid='+$('#team').val()+"&value="+$('#value').val());
			});



	    // Apply the filter
    // $("#ZabbixTable tfoot input").on( 'keyup change', function () {
    //     table
    //     	.column( $(this).parent().index()+':visible' )
    //         .search( this.value )
    //         .draw();

    // } );

	// console.log($('#example th').eq($(this).index()).text());



	// setInterval( function () {
	// 	table.reload();
	// }, 5000 );

 });


</script>



<!-- <div style="width: 1000px; height: 400px;font-size: 10px"> -->

<div class="tab_zalert">


<table id="ZabbixTable" class="display, stripe" cellspacing="0" width="100%">
<thead>
<tr><th>Group</th><th>Host</th><th>Trigger</th><th>comments</th><th>severity</th><th>Problem</th><th>Enabled</th><th>Date</th></tr>


</thead>
<tfoot>
<tr><th>Group</th><th>Host</th><th>Trigger</th><th>comments</th><th>severity</th><th>Problem</th><th>Enabled</th><th>Date</th></tr>

</tfoot>
<tbody>
</tbody>
</table>


</div>

</body>

</html>