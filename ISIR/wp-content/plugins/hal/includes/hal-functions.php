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
        'hal_init' // The 'slug' - file to display when clicking the link
    );
}


function hal_init(){

global $wpdb;

echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
<link rel=\"stylesheet\" href=\"../wp-content/plugins/hal/includes/style.css\">
  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>";

echo "<script type=\"text/javascript\" src=\"../wp-content/plugins/hal/includes/hal.js\"></script>";


echo "<script type=\"text/javascript\">
	function myFunction() {
	  // Declare variables
	  var input, filter, table, tr, td, i, txtValue;
	  input = document.getElementById(\"myInput\");
	  filter = input.value.toUpperCase();
	  table = document.getElementById(\"myTable\");
	  tr = table.getElementsByTagName(\"tr\");

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName(\"td\")[2];
	    if (td) {
	      txtValue = td.textContent || td.innerText;
	      if (txtValue.toUpperCase().indexOf(filter) > -1) {
		tr[i].style.display = \"\";
	      } else {
		tr[i].style.display = \"none\";
	      }
	    }
	  }
	}
	</script>";

$tablename = "isir_".get_current_blog_id()."_hal";
$myrows = $wpdb->get_results( "SELECT id FROM $tablename" );

echo "<script type=\"text/javascript\">";

foreach ( $myrows as $row ) 
{
	echo "getSelected(\"$row->id\");" ;
}

$tablename = "isir_".get_current_blog_id()."_hal_hide";
$myrows = $wpdb->get_results( "SELECT id FROM $tablename" );


foreach ( $myrows as $row ) 
{
	echo "getSelectedHide(\"$row->id\");" ;
}


echo "</script>";


	echo "<div class=\"wrap\">
  <h1>Choisissez les documents HAL que vous voulez mettre en favoris</h1>
<div id=\"wait\"><p>Chargement en cours. Attendez svp...</p></div>
<div class=\"container\">
<input class=\"form-control\" id=\"myInput\" type=\"text\" onkeyup=\"myFunction()\" placeholder=\"Search..\">

<a href=\"#\" id=\"all\" >Sort by date</a>

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
