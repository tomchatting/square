<?php
	$input = get_url_input();

	require(SOFT_NAME.'/controllers/theme.php');


	if ($input[0] == "") {$input[0] = 'page'; $input[1] = 1;}

	if ($input[0] == "s" || $input[0] == "articles") {require(SOFT_NAME.'/controllers/post.php'); exit();}
	
	if ($input[0] == "feed") {require(SOFT_NAME.'/controllers/feed.php'); exit();}

	if ($_GET["cmd"] == "search") {require(SOFT_NAME.'/controllers/search.php'); exit();}

	if (file_exists(SOFT_NAME.'/controllers/'.$input[0].'.php')) {
		require(SOFT_NAME.'/controllers/'.$input[0].'.php');
	} else {
		return404();
	}
?>