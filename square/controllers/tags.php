<?php
	function print_tags_page($tag = '') {
		global $posts, $order, $tag_name, $numInArray, $blogPost;
		if(empty($tag)) {
			header("Location: " . URL);
		} else {
			$tag = urldecode($tag);
			$result = return_array("SELECT * FROM $posts WHERE status = 'publish' AND tags LIKE '%$tag%' $order", false);
			$numInArray = 0;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$blogPost[]=$row;
				$numInArray ++;
			}
			$page_name = '#'.strtoupper($tag);
			$tag_name = $tag;
			mysql_free_result($result);
			$file = build_page("tags");
			echo $file;
		}
	}
	
	print_tags_page($input[1]);
?>