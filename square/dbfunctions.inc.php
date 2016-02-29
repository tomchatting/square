<?php

Class Database {

  /*
		Function Name: database_connect()
		Author: Thomas Chatting
		Version: 1.0
		Description: Connect to the database using PDO
	*/
	static function database_connect($dbHost, $dbName, $dbUsername, $dbPassword)
	{
	    try
	    {
	        return new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUsername, $dbPassword);
	    }
	    catch(PDOException $PDOexception)
	    {
	        exit("<p>An error ocurred: Can't connect to database. </p><p>More preciesly: ". $PDOexception->getMessage(). "</p>");
	    }
	}

  /*
    Function Name: return_array()
    Author: Thomas Chatting
    Version: 2.0
    Description: Allows you to call MySQL queries in procedural code, without using a lot of repeating blocks
    Returns:
      boolean: false // if failed
      array: $return
  */
  static function return_array($query, $array=false) {

    $db = Database::database_connect(Config::$db_settings['host'], Config::$db_settings['database'], Config::$db_settings['username'], Config::$db_settings['password']);

    if ($array) {
      $stmnt = $db->query($query);
			if($stmnt) {
				while($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
					$posts[] = $row;
				}
      	return $posts;
			} else {
				return false;
			}
    } else {
			$stmnt = $db->prepare($query);
			$stmnt->execute();
			$row = $stmnt->fetch();
			if($stmnt->rowCount() == 0) { throw new Exception('404'); }
      return $row;
    }

  }

	static function sql_command($query) {
		$db = Database::database_connect(Config::$db_settings['host'], Config::$db_settings['database'], Config::$db_settings['username'], Config::$db_settings['password']);
		return $db->query($query);
	}


}

 ?>
