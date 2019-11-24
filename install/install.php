<?php

include_once 'library/System/Database.php';

echo '<title>Install SMT</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="Description" lang="en" content="ADD SITE DESCRIPTION" />
  <meta name="author" content="ADD AUTHOR INFORMATION" />
  <meta name="robots" content="index, follow" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="apple-touch-icon" href="../assets/images/apple-touch-icon.png" />
  <link rel="shortcut icon" href="../favicon.ico" />
	
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css" />
  <link rel="stylesheet" href="../assets/dist/css/skins/skin-blue.css" />
  <link rel="stylesheet" href="../assets/dist/css/smt.css" />';


if (isset($_POST['aktion']) && $_POST['aktion'] == 'install') {

  $file = project_path . '/assets/config/' . project_base . '.ini';
  $current = "";
  $current .= "project = SMT\n";
  $current .= "getPath = " . $_POST['getPath'] . "\n";
  $current .= "iAnzahl = " . $_POST['iAnzahl'] . "\n";
  $current .= "language = " . $_POST['language'] . "\n";
  $current .= "country = " . $_POST['language'] . "\n";
  $current .= "logfiles = " . $_POST['logfiles'] . "\n";
  $current .= "loader = Handler,Texte\n\n";
  $current .= "[SMT-ADMIN]\n";
  $current .= "db_host = " . $_POST['db_host'] . "\n";
  $current .= "db_user = " . $_POST['db_user'] . "\n";
  $current .= "db_pass = " . $_POST['db_pass'] . "\n";
  $current .= "db_base = " . $_POST['db_name'] . "\n";
  $current .= "db_port = 3306\n";
  $current .= "db_charset=utf8\n\n";
  $current .= "[SMT-MONITOR]\n";
  $current .= "db_host = " . $_POST['db_host'] . "\n";
  $current .= "db_user = " . $_POST['db_user'] . "\n";
  $current .= "db_pass = " . $_POST['db_pass'] . "\n";
  $current .= "db_base = " . $_POST['db_name'] . "\n";
  $current .= "db_port = 3306\n";
  $current .= "db_charset=utf8\n\n";
  $current .= "[SMT-USER]\n";
  $current .= "db_host = " . $_POST['db_host'] . "\n";
  $current .= "db_user = " . $_POST['db_user'] . "\n";
  $current .= "db_pass = " . $_POST['db_pass'] . "\n";
  $current .= "db_base = " . $_POST['db_name'] . "\n";
  $current .= "db_port = 3306\n";
  $current .= "db_charset=utf8\n";
  file_put_contents($file, $current);

  $db = new Database('SMT-ADMIN');
  $db->importSQL(project_path . '/install/server_admin_structure.sql');
  $db->importSQL(project_path . '/install/server_admin_data.sql');

  echo '<center><h4>Installation successful !!!<br /><br />';
  echo '<a href="' . $_POST['getPath'] . '">click here to continue</a></h4></center>';
} else {

  echo '<div class="content">
          <h4>Installation von SMT 2.1</h4>
          <form name="install" method="post" action="/index.php">
          <input type="hidden" name="aktion" value="install" />
          <input type="hidden" name="iAnzahl" value="20" />
          <input type="hidden" name="logfiles" value="/assets/logfile/" />
          The following files are created during installation:<br /><br />
          - <b>/assets/config/' . $_SERVER['HTTP_HOST'] . '.ini</b>
            
          <br /><br />
          Set global configuration such as path and the standard language, Database configuration for<br />
          the database. The database must already be created, the User must have access to the database.<br />
          
          <br /><br />
          After the customization please click on the following button, the databases 
          <br />are then set up and the default user with the username is set up.<br /><br />
          <b>Username: admin<br />
          Password: admin</b> <br /><br />

          Dont \' forget to change this data after the first login! 

          <br /><br /><br />

          <b>The path to the application:</b><input style="width:500px;" type="text" name="getPath" class="form-control" value="http://' . $_SERVER['HTTP_HOST'] . '" /><br />
          <b>Select the default Language</b> (German only at the moment)
          <select style="width:500px;" name="language" size="1" class="form-control">
          <option value="de">German</option>
          </select><br /><br /><br />

          <b>Hostname of the Mysql server:</b><input style="width:500px;" type="text" name="db_host" class="form-control" value="localhost" /><br />
          <b>Database name (must exist):</b><input style="width:500px;" type="text" name="db_name" class="form-control" value="server_admin" /><br />
          <b>Username for Mysql connection:</b><input style="width:500px;" type="text" name="db_user" class="form-control" value="root" /><br />
          <b>Password of the Mysql user:</b><input style="width:500px;" type="password" name="db_pass" class="form-control" value="" /><br />
      
          <br /><input type="submit" value="Start the installation" class="btn btn-success">
          </form>';

  echo '</div>';
}

?>
