<?php
require_once('config.php');

function exportdb($dbname,$filepath,$filename)
{
  $dbbackup = new db_backup(DB_HOST,DB_USER,DB_PASSWORD,$dbname);
  $dbbackup->backup();

  if($dbbackup->save($filepath,$filename))
  {
    return "<p>Exported database ($dbname) successfully !<p>";
  }
  else
  {
    return "<p>Error to export database ($dbname) .<p>";
  }
  $dbbackup->closeMysqli();
}
?>
