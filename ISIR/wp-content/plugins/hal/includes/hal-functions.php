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

	$tablename = "isir_".get_current_blog_id()."_hal_team";
	$myrows = $wpdb->get_results( "SELECT nameTeam FROM $tablename" );
	if($myrows!=null){
		hal_team();
	}
	else {
		$tablename = "isir_".get_current_blog_id()."_hal_project";
	$myrows = $wpdb->get_results( "SELECT nameProject FROM $tablename" );
		if($myrows!=null){
			hal_project();

		}
		else
			hal_chercheur();


	}



}



function hal_team(){

	global $db_member;
	global $table_user;
	
	echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
	<link rel=\"stylesheet\" href=\"/ISIR/wp-content/plugins/hal/includes/style.css\">
	  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>";

	echo "<script type=\"text/javascript\" src=\"/ISIR/wp-content/plugins/hal/includes/hal.js\"></script>";

	echo "<h3>Choose the documents from HAL you want to show in the \"Favorite\" section and the documents you want to hide in the \"Publications\" section ! </h3><br>";
	global $wpdb;
	
	$tablename = "isir_".get_current_blog_id()."_hal_team";
	$myrows = $wpdb->get_results( "SELECT nameTeam FROM $tablename" );

	$nameTeam = $myrows[0]->nameTeam;

	

	$rows = $db_member->get_results("select * from $table_user");

	echo "<div id=\"liste_users\">";
	echo "<h4>List of the researchers of the team</h4>";
	echo "<ul >";
	foreach ($rows as $obj) :
		$equipes = explode("|", $obj->isirequipe);
		$belongs = false;
		foreach($equipes as $nom_equipe){
			if($nom_equipe == $nameTeam){
				$belongs = true;
				break;
			}

		}
		if($belongs){
			if($obj->blog_id >=0){
		   		$tablename_user = "isir_".$obj->blog_id."_hal_id";
				$user_rows = $wpdb->get_results( "SELECT * FROM $tablename_user" );
				if(count($user_rows)!=0 && strlen($user_rows[0]->idHal)!=0){
					$idHal = $user_rows[0]->idHal;
					echo "<li><a href=\"#\" onclick=\"getDocuments('$idHal', '$obj->username')\">".$obj->username."</a></li>";
					$username_idHal = $obj->username;

				}
				else{
					echo "<li>".$obj->username." didn't active its HAL plugin</li>";
				}

			}
		}
	endforeach;

	echo "</ul></div>";

	echo "<div id=\"hal_component\">";

	echo "<script type=\"text/javascript\">
		var i_search = 2;
		function myFunction() {
		  // Declare variables
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById(\"myInput\");
		  filter = input.value.toUpperCase();
		  table = document.getElementById(\"myTable\");
		  tr = table.getElementsByTagName(\"tr\");

		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 0; i < tr.length; i++) {
		    td = tr[i].getElementsByTagName(\"td\")[i_search];
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


		echo "<div class=\"wrap\">";

		echo "<h4 id=\"publicationHead\">Publications</h4><br><br>";

		echo "<div id=\"wait\"><p>Loading. Please wait...</p></div>
		<div class=\"container\">
		<input class=\"form-control\" id=\"myInput\" type=\"text\" onkeyup=\"myFunction()\" placeholder=\"Search documents...\">

		<a href=\"#\" id=\"all\" >Sort by date</a>

		<a href=\"#\" id=\"sortbygroup\" >Sort by doctype</a>

		<script>
			document.getElementById(\"all\").addEventListener(\"click\",function(){
			i_search = 2;
			getDocuments(curr_idHal); return false;
		    },false);
		</script>


		<script>
			document.getElementById(\"sortbygroup\").addEventListener(\"click\",function(){
			i_search = 3;
			getDocumentsSortedByGroup(curr_idHal); return false;
		    },false);
		</script>

		<div id=\"docs\"></div></div>
		  <script type=\"text/javascript\">getDocuments(\"$idHal\", \"$username_idHal\");</script>


		</div>";



	echo "</div>";


}


function hal_project(){

	global $db_member;
	global $table_user;

	echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">

	<link rel=\"stylesheet\" href=\"/ISIR/wp-content/plugins/hal/includes/style.css\">
	  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>";

	echo "<script type=\"text/javascript\" src=\"/ISIR/wp-content/plugins/hal/includes/hal.js\"></script>";

	echo "<h3>Choose the documents from HAL you want to show in the \"Favorite\" section and the documents you want to show in the \"Publications\" section ! </h3><br>";

	global $wpdb;
	$tablename = "isir_".get_current_blog_id()."_hal_project";
	$myrows = $wpdb->get_results( "SELECT nameProject FROM $tablename" );

	$nameProject = $myrows[0]->nameProject;

	

	$rows = $db_member->get_results("select * from $table_user");

	$blogusers = get_users( 'blog_id='.get_current_blog_id() );

	

	echo "<div id=\"liste_users\">";
	echo "<h4>List of the researchers of the team</h4>";
	echo "<ul >";

	foreach($blogusers as $user){

		foreach ($rows as $obj) :

			if($user->user_login==$obj->username){
				if( $obj->blog_id >=0){
			   		$tablename_user = "isir_".$obj->blog_id."_hal_id";
					$user_rows = $wpdb->get_results( "SELECT * FROM $tablename_user" );
					if(count($user_rows)!=0 && strlen($user_rows[0]->idHal)!=0){
						$idHal = $user_rows[0]->idHal;
						echo "<li><a href=\"#\" onclick=\"getDocuments('$idHal', '$obj->username', true)\">".$obj->username."</a></li>";
						$username_idHal = $obj->username;

					}
					else{
						echo "<li>".$obj->username." didn't active its HAL plugin</li>";
					}

				}
				break;

			}

		endforeach;
	}


	echo "</ul></div>";

	echo "<div id=\"hal_component\">";

	echo "<script type=\"text/javascript\">
		var i_search = 2;

		function myFunction() {
		  // Declare variables
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById(\"myInput\");
		  filter = input.value.toUpperCase();

		  table = document.getElementById(\"myTable\");
		  tr = table.getElementsByTagName(\"tr\");

		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 0; i < tr.length; i++) {

		    td = tr[i].getElementsByTagName(\"td\")[i_search];
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

	$tablename = "isir_".get_current_blog_id()."_hal_show";
	$myrows = $wpdb->get_results( "SELECT id FROM $tablename" );


	foreach ( $myrows as $row )
	{
		echo "getSelectedShow(\"$row->id\");" ;
	}




	echo "</script>";


		echo "<div class=\"wrap\">";

		echo "<h4 id=\"publicationHead\">Publications</h4><br><br>";

		echo "<div id=\"wait\"><p>Loading. Please wait...</p></div>

		<div class=\"container\">
		<input class=\"form-control\" id=\"myInput\" type=\"text\" onkeyup=\"myFunction()\" placeholder=\"Search documents...\">

		<a href=\"#\" id=\"all\" >Sort by date</a>


		<a href=\"#\" id=\"sortbygroup\" >Sort by doctype</a>

		<script>
			document.getElementById(\"all\").addEventListener(\"click\",function(){

			i_search = 2;
			getDocuments(curr_idHal, undefined, true); return false;
		    },false);
		</script>



		<script>
			document.getElementById(\"sortbygroup\").addEventListener(\"click\",function(){
			i_search = 3;
			getDocumentsSortedByGroup(curr_idHal, undefined, true); return false;

		    },false);
		</script>

			<div id=\"docs\"></div></div>
		  <script type=\"text/javascript\">getDocuments(\"$idHal\", \"$username_idHal\", true);</script>

		</div>";



	echo "</div>";


}


function hal_chercheur(){

	global $wpdb;

	if(isset($_POST['SubmitButton'])){ //check if form was submitted

		$idHal = $_POST['idHal']; //get input text
		$tablename = "isir_".get_current_blog_id()."_hal_id";

		$wpdb->replace(
				$tablename,
 				array(
					'id' => 1,
					'idHal' => $idHal

				)
			);



	}


	echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
	<link rel=\"stylesheet\" href=\"/ISIR/wp-content/plugins/hal/includes/style.css\">
	  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>";

	echo "<script type=\"text/javascript\" src=\"/ISIR/wp-content/plugins/hal/includes/hal.js\"></script>";


	echo "<script type=\"text/javascript\">
		var i_search = 2;
		function myFunction() {
		  // Declare variables
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById(\"myInput\");
		  filter = input.value.toUpperCase();
		  table = document.getElementById(\"myTable\");
		  tr = table.getElementsByTagName(\"tr\");

		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 0; i < tr.length; i++) {
		    td = tr[i].getElementsByTagName(\"td\")[i_search];
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


	$tablename = "isir_".get_current_blog_id()."_hal_id";
	$myrows = $wpdb->get_results( "SELECT idHal FROM $tablename" );

	$hasHal = true;

	if(count($myrows)!=0 && strlen($myrows[0]->idHal)!=0){
		$idHal = $myrows[0]->idHal;
	}
	else
		$hasHal = false;


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
	 <h3>Choose the documents from HAL you want to show in the \"Favorite\" section and the documents you want to show in the \"Publications\" section ! </h3>
	  <h5>Enter your HAL id:</h5>
	 <form action=\"\" method=\"post\">

	  <input name=\"idHal\" type=\"text\" value=\"$idHal\">
	  <input  type=\"submit\" value=\"Submit\" name=\"SubmitButton\">
	</form> ";

	if($hasHal){
		echo "<br><br><div id=\"wait\"><p>Loading. Please wait...</p></div>
		<div class=\"container\">
		<input class=\"form-control\" id=\"myInput\" type=\"text\" onkeyup=\"myFunction()\" placeholder=\"Search documents...\">

		<a href=\"#\" id=\"all\" >Sort by date</a>

		<a href=\"#\" id=\"sortbygroup\" >Sort by doctype</a>

		<script>
			document.getElementById(\"all\").addEventListener(\"click\",function(){
			i_search = 2;
			getDocuments(\"$idHal\"); return false;
		    },false);
		</script>


		<script>
			document.getElementById(\"sortbygroup\").addEventListener(\"click\",function(){
			i_search = 3;
			getDocumentsSortedByGroup(\"$idHal\"); return false;
		    },false);
		</script>

			<div id=\"docs\"></div></div>

		  <script type=\"text/javascript\">getDocuments(\"$idHal\");</script>


		</div>";



	}



}
