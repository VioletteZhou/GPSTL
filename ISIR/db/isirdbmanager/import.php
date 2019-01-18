<?php

require_once('config.php');

function importdb($dbname,$filepath,$filename)
{
  $dbbackup = new db_backup(DB_HOST,DB_USER,DB_PASSWORD,$dbname);
  $dbbackup->backup();

  if($dbbackup->db_import($filepath.$filename))
  {
    //echo "Database Successfully Imported";
    return "<p>Imported database ($dbname) successfully** !<p>";
  }
  else
  {
    return "<p>Error to import database ($dbname) .**<p>";
  }
  $dbbackup->closeMysqli();
}

?>
