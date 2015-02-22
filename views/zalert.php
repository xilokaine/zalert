<?php
include(dirname(__FILE__).'/../views/bandeau.html');
?>


  <div>
  <label>select groups</label>
  <select id="team" multiple style="width:350px" class="chosen-select" tabindex="18" >
  <option value=""></option>
  <?php
  foreach ($hostgroups as $group)
    echo '<option value="'.$group->groupid.'">'.$group->name.'</option>'."\n";
  ?>
  </select>
  </div>

<div class="bs-example">


<form class="form-inline" role="form">
<!-- <form class="form-inline" role="form" style="font-size:11px"> -->


 <div class="form-group">

  <label>Minimum trigger severity</label>
  <select id="min_severity"  class="form-control">
  <option value="0">Not Classified</option>
  <option value="1">Information</option>
  <option value="2">Warning</option>
  <option value="3">Average</option>
  <option value="4">High</option>
  <option value="5">Disaster</option>
  </select>
</div>

   
<div class="form-group">
  <label>Acknowledge status</label>
  <select id="ack" class="form-control"/>
  <option value="0">Any</option>
  <option value="1">Acknowledged</option>
  </select>
</div>


<div class="form-group">
<label>regex+</label>
<input type='text' name='regex' id='regex' value='' class="form-control"/> 
<label>regex-</label>
<input type='text' name='regex2' id='regex2' value='' class="form-control"//> <br />
</div>



<div class="form-group">
<input type='submit' id='bt2' value='fouego' />
<input type='submit' id='bt1' value='Debug' />
</div>

<div class="form-group">

</div>

<div class="form-group">
<button type="button" id="loading-example-btn" data-loading-text="Loading..." class="btn btn-default btn-xs">
  Loading state
</button>
</div>




</div>
</form>

<!-- <code>User shift click on a column (added the clicked column as a secondary, tertiary etc ordering column).</code> -->




<div id="retour"></div>


</div>

 <!-- DEBUT -->

 

<script>

//VERSION JSON

// jQuery(document).ready(function($){

    
// });

//VERSION HTML
jQuery(document).ready(function($){

  // jQuery(".chosen-select").chosen(); 

jQuery("#team").chosen({
  // "no_results_text" : "not match",
  // "search_contains" : true,
  // "placeholder_text_single" : "",
  // "placeholder_text_multiple" : "   ",
  // "inherit_select_classes" : true

}); 
    

    jQuery('#loading-example-btn').click(function(er){

      //reload
      //setTimeout("jQuery('#loading-example-btn').click();", 30000);


            var btn = $(this);
            btn.button('loading');

                  // On désactive le comportement par défaut du navigateur
        // (qui consiste à appeler la page action du formulaire)
        er.preventDefault();
  

         jQuery.ajax({
           url: 'controllers/zalert2.php',
           type: 'POST',
           dataType:'html',
           data: {
            regex: jQuery('#regex').val(),
            regex2: jQuery('#regex2').val(),
            team: jQuery('#team').val(),
            min_severity: jQuery('#min_severity').val()
         },
         })
         .done(function(data) {

           console.log("success");
           // console.log(data);
           $('#retour').html(data);


            // window.setTimeout('er', 6000);
            // console.log(data);

         })
         .fail(function() {
           console.log("error");
         })
         .always(function() {
          btn.button('reset')
           console.log("complete");

         });
         

    });

 


    jQuery('#bt1').click(function(e){
        // On désactive le comportement par défaut du navigateur
        // (qui consiste à appeler la page action du formulaire)
        e.preventDefault();
         

        //on travaille en amont

              // var tabgroup;
              // $(".chosen-select :selected").each(function() {
                  // iterate through array or object 
              //    tabgroup = tabgroup + $(this).val();
              //    jQuery('#team').value = tabgroup;
              // });
        // console.log(jQuery("#team").val());

        // On envoi la requête AJAX
        jQuery.getJSON(
            'controllers/zalert.php',

            {

              // age: jQuery('#age').val(),
              json:1,
            regex: jQuery('#regex').val(),
           team: jQuery('#team').val()

            },

            function(data){
              console.log(data);
                $('#retour').hide();
                jQuery('#retour').html('')
                    $('#retour').append('<b>Paramètre en majuscule</b> : '+data.age+'<br/>')
                    $('#retour').append('<b>coucou</b> : '+data.regex+'<br/>');
                    $('#retour').append('<b>vargroup</b> : '+data.team+'<br/>');

                    $('#retour').append('<b>Date</b> : '+data.date+'<br/>')
                    .append('<b>Version PHP</b> : '+data.phpversion+'<br/>');
                    
                $('#retour').fadeIn();

            }
        );
    });


});

//-->
</script>






  </body>
</html>