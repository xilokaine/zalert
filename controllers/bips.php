<?php


include(dirname(__FILE__).'/../views/bandeau.html');
?>


<script type="text/javascript">
	

jQuery(document).ready(function($) {
	

	$("#test").click(function(event) {
		noty({text: 'noty - a jquery notification library!',
		type: "error",

		});
	});




});



</script>



<button id="test">TEST</button>

















</body>

</html>