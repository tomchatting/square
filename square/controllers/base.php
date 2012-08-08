<?php
	error_reporting(E_ALL^E_NOTICE);

	define('DOMAIN', 	preg_replace('#^www\.#', '', $_SERVER['SERVER_NAME']));					/* Gets domain.com */
	define('URL', 		str_replace('index.php', '', 'http://'.DOMAIN.$_SERVER['PHP_SELF']));	/* Turns domain.com into http://domain.com/dir/ */
	define('VERSION',	'1.2.1');		/* Defining the version */

	/*
		Function Name: return_array()
		Author: Thomas Chatting
		Version: 1.0
		Description: Allows you to call MySQL queries in procedural code, without using a lot of repeating blocks
		Returns:
			boolean: false // if failed
			array: $return
	*/
	function return_array($query, $array=true) {
		global $dbsettings;
		
		$connection = mysql_pconnect($dbsettings["host"], $dbsettings["username"], $dbsettings["password"]) or die (mysql_error());
		mysql_select_db($dbsettings["database"]);
		
		if ($array) {
			if ($return = mysql_fetch_array(mysql_query($query), MYSQL_ASSOC)) {
				mysql_close($connection);
				return $return;
			}
		} else {
			if ($return = mysql_query($query, $connection)) {
				mysql_close($connection);
				return $return;
			}
		}
		mysql_close($connection);
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
	
	/*
		Function Name: print_comments()
		Author: Thomas Chatting
		Version: 1.0
		Description: Moved from comments.php
	*/
	function print_comments() {
		if (COMMENTING_ENABLED == true) {
			if (COMMENT_SYSTEM == 'Intense Debate') {
				echo '<script>var idcomments_acct = \''.COMMENT_UNIQUE_ID.'\'; var idcomments_post_id; var idcomments_post_url;</script><span id="IDCommentsPostTitle" style="display:none"></span><script type=\'text/javascript\' src=\'http://www.intensedebate.com/js/genericCommentWrapperV2.js\'></script>';
			}
			if (COMMENT_SYSTEM == 'Disqus') {
				echo '<div id="disqus_thread"></div><script type="text/javascript">(function() {var dsq = document.createElement(\'script\'); dsq.type = \'text/javascript\'; dsq.async = true;dsq.src = \'http://'.COMMENT_UNIQUE_ID.'.disqus.com/embed.js\';(document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(dsq);})();</script><noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript='.COMMENT_UNIQUE_ID.'">comments powered by Disqus.</a></noscript><a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>';
				echo '<script type="text/javascript">//<![CDATA[(function() {var links = document.getElementsByTagName(\'a\');var query = \'?\';for(var i = 0; i < links.length; i++) {if(links[i].href.indexOf(\'#disqus_thread\') >= 0) {query += \'url\' + i + \'=\' + encodeURIComponent(links[i].href) + \'&\';}}document.write(\'<script charset="utf-8" type="text/javascript" src="http://disqus.com/forums/'.COMMENT_UNIQUE_ID.'/get_num_replies.js\' + query + \'"></\' + \'script>\');})();//]]></script>';
			}
		}	
	}
?>