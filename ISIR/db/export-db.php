<?php
	// Name of the file
	$isirdbFile = './data/db.sql';
	$memberdbFile = './data/member.sql';
	// MySQL host
	$mysql_host = 'localhost';
	// MySQL username
	$mysql_username = 'root';
	// MySQL password
	$mysql_password = 'root';
	// Database name
	$isirdb = 'ISIR';
	$memberdb = 'MEMBER';

	function exportdb($filePath,$mysql_host, $mysql_username, $mysql_password,$dbname)
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		echo "<h3>Backing up database to '<code>{$filePath}</code>'</h3>";
		exec("mysqldump --user={$mysql_username} --password={$mysql_password} --host={$mysql_host} {$dbname} --result-file={$filePath} 2>&1", $output);
		var_dump($output);
	}
	//exportdb($memberdbFile,$mysql_host, $mysql_username, $mysql_password,$memberdb);
?>