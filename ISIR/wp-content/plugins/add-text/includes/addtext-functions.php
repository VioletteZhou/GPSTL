<?php
/*
 * Add my new menu to the Admin Control Panel
 */


// Hook the 'admin_menu' action hook, run the function named 'mfp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'addtext_Print_Text' );

 
// Add a new top level menu link to the ACP
function addtext_Print_Text()
{
  add_menu_page(
        'My First Page', // Title of the page
        'My First Plugin', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
	'add-text',
        'test_init' // The 'slug' - file to display when clicking the link
    );
}


function test_init(){

	echo "<div class=\"wrap\">
  <h1>Salut!</h1>
  <p>Ceci est mon plugin</p>

<textarea rows=\"4\" cols=\"50\"></textarea> 
</div>";

}
