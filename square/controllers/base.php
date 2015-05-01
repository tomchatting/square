<?php
	error_reporting(E_ALL^E_NOTICE);

	define('DOMAIN', 	preg_replace('#^www\.#', '', $_SERVER['SERVER_NAME']));					/* Gets domain.com */
	define('URL', 		str_replace('index.php', '', 'http://'.DOMAIN.$_SERVER['PHP_SELF']));	/* Turns domain.com into http://domain.com/dir/ */
	define('VERSION',	'2.0.0');																/* Defining the version */
	
	/*
		Function Name: database_connect()
		Author: Thomas Chatting
		Version: 1.0
		Description: Connect to the database using PDO
	*/
	function database_connect($dbHost, $dbName, $dbUsername, $dbPassword)
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
	function return_array($query, $array=true) {
		global $dbsettings;
		
		$db = database_connect($dbsettings['host'], $dbsettings['database'], $dbsettings['username'], $dbsettings['password']);
		
		if ($array) {
			$stmnt = $db->query($query);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} else {
			return $db->query($query);
		}
		return false;
	}
	
	/*
		Function Name: authenticated()
		Author: Thomas Chatting
		Version: 1.0
		Description: Simple check for authentication
	*/
	function authenticated() {
		if ($_COOKIE[COOKIE_NAME] == COOKIE_VALUE) {
			return true;
		}
		return false;
	}
	
	/*
		Function Name: get_url_input()
		Author: Thomas Chatting
		Version: 1.0
		Description: Returns anything in the URL after the 'destination' as an array of instructions
	*/
	function get_url_input() {
		// Parse users input
		$uri = $_SERVER['REQUEST_URI'];
		$uri = preg_replace('#\.html#','',$uri); 	// Strip any .html from the URL
		$uri = preg_replace('#\.xhtml#','',$uri); 	// Strip any .xhtml from the URL
		$uri = preg_replace('#\.php#','',$uri);		// Strip the .php from the URL (if there is one)
		$uri = preg_replace('#\?\/#','',$uri); 		// Strip the ? from the URL (handling weird configs in Apache)
		$temp = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
		$uri = str_replace($temp, '', $uri);
	
		if ($uri[0] == '/') {
			$uri = substr($uri, 1); // If the first character of input is "/" this might break our array
		}
		return explode('/',$uri); // Creates an array
	}
	
	/*
		Function Name: curPageURL()
		Author: http://www.webcheatsheet.com/PHP/get_current_page_url.php
		Version: 1.0
		Description: Sometimes, you might want to get the current page URL that is shown in the browser URL window.
	*/
	function curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	/*
		Function Name: return404()
		Author: Thomas Chatting
		Version: 1.0
		Description: Returns a basic 404 page
	*/
	function return404() {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); // Return a 404
		header("Content-Type: text/plain");
		print("404 Not Found\n");
		exit();
	}
	
	/*
		Function Name: build_page()
		Author: Thomas Chatting
		Version: 1.0
		Description: Generates an HTML page based on user input and the theme files
	*/
	function build_page($page) {
		$base = LOCAL_THEME_DIR.'index.page';
		$base = explode('<square:page_content />', parse_theme_template(file_get_contents($base)));
		$file = $base[0];
		if (file_exists(LOCAL_THEME_DIR.$page.'.page')) {$file .= parse_page(file_get_contents(LOCAL_THEME_DIR.$page.'.page'));} else {$file .= parse_page(file_get_contents(SOFT_NAME.'/themes/default/'.$page.'.page'));}
		$file .= $base[1];
		return $file;
	}
	
	/*
		Function Name: base58_decode() and base58_encode()
		Author: http://darklaunch.com/2009/08/07/base58-encode-and-decode-using-php-with-example-base58-encode-base58-decode
		Version: 1.0
		Description: Encodes and decodes base58 strings
	*/
	function base58_decode($num) {
		$alphabet = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
		$len = strlen($num);
		$decoded = 0;
		$multi = 1;

		for ($i = $len - 1; $i >= 0; $i--) {
			$decoded += $multi * strpos($alphabet, $num[$i]);
			$multi = $multi * strlen($alphabet);
		}

		return $decoded;
	}

	function base58_encode($num) {
		$alphabet = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
		$base_count = strlen($alphabet);
		$encoded = '';

		while ($num >= $base_count) {
			$div = $num / $base_count;
			$mod = ($num - ($base_count * intval($div)));
			$encoded = $alphabet[$mod] . $encoded;
			$num = intval($div);
		}

		if ($num) {
			$encoded = $alphabet[$num] . $encoded;
		}

		return $encoded;
	}
	
?>