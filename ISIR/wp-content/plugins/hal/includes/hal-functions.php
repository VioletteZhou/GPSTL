<?php
if(!isset($_POST['action'])){
  if($_POST['action']=="call_this"){
      echo "test";
  }
}
?>
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
echo "<script type=\"text/javascript\" src=\"../wp-content/plugins/hal/includes/hal.js\"></script>";
echo "<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-latest.js\"></script>";
	echo "<div class=\"wrap\">
  <h1>Choisissez les documents HAL que vous voulez afficher</h1>
<div id=\"wait\"><p>Chargement en cours. Attendez svp...</p></div>
  <script type=\"text/javascript\">getDocuments(\"amel\", \"arkoub\");</script>

	<div id=\"docs\"></div>
  <button onclick=\"submit()\">submit</button>
</div>";




}
