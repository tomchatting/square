<?php
	global $page, $num;
	$num = 6; /* The number of posts to be displayed per page - SHOULD BE MOVED TO SETTINGS */
	if (isset($input[1])) {$page = intval($input[1]);} else { $page = 1;}

	function get_archives($page = 1, $num = 6, $page_title = "Archives") {
		global $posts, $order, $result, $page_name;
		$start = (($page - 1) * $num); // Default to 0
	
		// Pull the results from post in blog order, limited to 6 (or "n") from the start value
		$DateNow = gmdate("Y-m-d H:i:s");
		$result = return_array("SELECT * FROM $posts WHERE `date-time` <= '$DateNow' AND `status` = 'publish' $order LIMIT $start, $num", false);
		$page_name = $page_title;
		echo build_page("archive");
	}
	
	if ($page == 1) {$name = "Home";} else {$name = "Archives";}
	get_archives($page,6,$name);
?>