<?php
	/*
		The first of the newly rewritten controllers for >0.4, print_page() takes the Unique ID of the 'wanted' page, performs some checks
		to make sure the admin wants you to see the page (as well as checking the page exists) and then uses the new build_page() function.
	*/
	function print_page($id) {
		global $pages, $content;
		$result = return_array("SELECT * FROM $pages WHERE id='$id' LIMIT 1", false);
		$row = $result->fetch(PDO::FETCH_ASSOC);
	
		if (empty($row)) {
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); // Return a 404
			header("Content-Type: text/plain");
			print("404 Not Found\n");
			exit();
		}
	
		if ($row['status'] != 'publish') {
			/* Here we can check for the admin cookie if the post is a draft
				if it's not set, we'll redirect to the login screen */
			if (!isset($_COOKIE[COOKIE_NAME]) || $_COOKIE[COOKIE_NAME] != COOKIE_VALUE) {
				header("Location: ".URL."square/");
				exit();
			}
		}
		if ($row['type'] == 'content'){
			$content = $row['content'];
			$file = build_page("page");
			echo $file;
		}
		if ($row['type'] == 'function'){
			eval($row['content']);
		}
	}
	
	if (empty($input[1])) {
		header("Location: ".URL);
		exit();
	} else {
		$wanted = $input[1];
		$query = return_array("SELECT id, name FROM $pages WHERE url like '%$wanted%' LIMIT 1", false);
		$p = $result->fetch(PDO::FETCH_ASSOC);
		$page_name = $p['name'];
		print_page($p['id']);
		exit();
	}
?>