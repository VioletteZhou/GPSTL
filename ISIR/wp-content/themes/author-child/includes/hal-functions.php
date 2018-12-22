<?php
/*
 * Add my new menu to the Admin Control Panel
 */


// Hook the 'admin_menu' action hook, run the function named 'mfp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'hal_Print_Text' );

 
// Add a new top level menu link to the ACP
function hal_Print_Text()
{
  add_menu_page(
        'Select your HAL document', // Title of the page
        'HAL', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
	'hal',
        'test_init' // The 'slug' - file to display when clicking the link
    );
}


function test_init(){

echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>";

echo "<script type=\"text/javascript\" src=\"../wp-content/plugins/hal/includes/hal.js\"></script>";


echo "<script>jQuery(document).ready(function(){
  jQuery(\"#myInput\").on(\"keyup\", function() {
    var value = jQuery(this).val().toLowerCase();
    jQuery(\"#myList li\").filter(function() {
      jQuery(this).toggle(jQuery(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>";


	echo "<div class=\"wrap\">
  <h1>Choisissez les documents HAL que vous voulez mettre en favoris</h1>
<div id=\"wait\"><p>Chargement en cours. Attendez svp...</p></div>
<div class=\"container\">
<input class=\"form-control\" id=\"myInput\" type=\"text\" placeholder=\"Search..\">

<a href=\"#\" id=\"all\" >All</a>

<a href=\"#\" id=\"sortbygroup\" >Sort by doctype</a>

<script>
	document.getElementById(\"all\").addEventListener(\"click\",function(){
        getDocuments(\"amel\", \"arkoub\"); return false;
    },false);
</script>


<script>
	document.getElementById(\"sortbygroup\").addEventListener(\"click\",function(){
        getDocumentsSortedByGroup(\"amel\", \"arkoub\"); return false;
    },false);
</script>

  <script type=\"text/javascript\">getDocuments(\"amel\", \"arkoub\");</script>

	<div id=\"docs\"></div></div>
</div>";




}
