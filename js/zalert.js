jQuery(document).ready(function($){


 $('#example').dataTable({
 	        "bJQueryUI": true,
 	      // "bProcessing" : true,
          // "bDestroy" : true,
          "bAutoWidth" : true,
          "sScrollY" : "500",
          "sScrollX" : "100%",
          "bScrollCollapse" : true,
          "bSort" : true,
          // "sPaginationType" : "full_numbers",
          // "iDisplayLength" : 25,
          "bLengthChange" : false,
 	// "sPaginationType": "full_numbers"
        // "scrollY":        "600px",
        // "scrollCollapse": true,
        "paging":         false,
        "info":     false
    }



 	);
    jQuery("#toto").click(function(er){
      console.log("salut");
    });

     jQuery("#toto").click(function(er){
      console.log("salut");
    });

  jQuery(".test").click(function(er){
      $('#myModal').modal()
    });


});
