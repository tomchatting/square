<?php
	/* 
		WARNING: Here be dragons
		This file is a test of what the original theme.php SHOULD have been.
		Basically every XML Square tag is now based upon a function which is called when needed and simply
			echoes an output. When the file is "parsed" it will then be nothing but HTML and text, ready to be
			echoed to the user, no EV(A/I)Ls needed!
	*/
	
	function parse_page($file_contents) {
		global $result, $item, $page_name, $page, $content;
		$res = $result;
		$DateNow = date("Y-m-d");
	
		$file = parse_theme_template($file_contents);
		
		$find = array(
			"<square:return_posts>".value_in('square:return_posts', $file)."</square:return_posts>",
			"<square:foreach_post>".value_in('square:foreach_post', $file)."</square:foreach_post>",
			"<square:prev_page />",
			"<square:next_page />",
			"<square:page_name />",
			"<square:page_content />",
			"<square:if_zero_results>".value_in('square:if_zero_results', $file)."</square:if_zero_results>",
			"<square:foreach_result>".value_in('square:foreach_result', $file)."</square:foreach_result>"
		);
		$replace = array(
			$result = return_posts(value_in('square:return_posts', $file)),
			foreach_post(value_in('square:foreach_post', $file), $res),
			prev_page($page),
			next_page($page),
			$page_name,
			$content,
			zero_results(value_in('square:if_zero_results', $file)),
			foreach_result(value_in('square:foreach_result', $file))
		);
		$file = preg_replace("/<square:get_post>([0-9]+)<\/square:get_post>/", "'; \$result = return_array(\"SELECT * FROM \$posts WHERE `date` <= '$DateNow' AND `status` = 'publish' \$order LIMIT $1,1 \", false); echo'", $file);
		$file = str_replace($find, $replace, $file);
		if ($item) {$file = build_post($item, $file);}

		return $file;
	}
	
	function zero_results($file) {
		global $numInArray;
		if ($numInArray == 0) {
			return $file;
		}
	}
	
	function foreach_result($file) {
		global $numInArray, $blogPost;
		if ($numInArray != 0) {
			foreach ($blogPost as $item) {
				$block .= build_post($item, $file);
			}
		}
		return $block;
	}
	
	function return_posts($num) {
		return return_array("SELECT * FROM $posts WHERE `date` <= '$DateNow' AND `status` = 'publish' $order LIMIT $num", false);
	}
	
	function foreach_post($repeating, $res) {
		while($item = $res->fetch(PDO::FETCH_ASSOC)) {
			$id = $item['id'];
			$block .= build_post($item, $repeating);
		}
		
		return $block;
	}
	
	function build_post($item, $block) {
		global $page, $row, $search, $numInArray;
		$find = array(
			'article_title',
			'article_tags',
			'article_date',
			'article_date_short',
			'article_wordcount',
			'article_permalink',
			'article_content',
			'article_blurb',
			'article_pagination',
			'article_next',
			'article_prev'
		);


		$i = 0;
		foreach ($find as $found) {
			$find[$i] = '<square:'.$found.' />';
			$i++;
		}
		
		$replace = array(
			$item['title'],
			print_tags($item['tags']),
			make_date($item['date-time'],$date_format),
			make_date($item['date-time'],"d/m/Y"),
			wordCount($item['content']),
			get_short_url($item['id']),
			$item['content'],
			$item['blurb'],
			'',
			next_post($item['id']),
			last_post($item['id'])
		);
		if ($_COOKIE[COOKIE_NAME] == COOKIE_VALUE) {$block = str_replace("<square:article_edit_link />", "<a href=\"".URL.SOFT_NAME."/?cmd=edit&id=".$item['id']."\">Edit</a>", $block);} else {$block = str_replace("<square:article_edit_link />", "", $block);}
		return str_replace($find, $replace, $block);
	}
	
	function prev_page($page = 1) {
		if (($page-1) > 0) { 
			return '<a href="'.archives_url($page-1).'" title="Newer">Newer</a>';
		}
	}
	
	function next_page($page) {
		global $num, $posts, $order;
		$start = ($page * $num);
		
		if ($res = return_array("SELECT * FROM $posts WHERE `status`='publish' $order LIMIT $start, $num", false)) {
			if ($row = $res->fetch(PDO::FETCH_ASSOC)) { 
				return '<a href="'.archives_url($page+1).'" title="Older">Older</a>'; 
			}
		}
	}
	
	function print_tags($tags) {
		$splitTags = explode(", ", $tags);
		foreach ($splitTags as $tag){ 
			$output .= tags_url($tag);
		}
		return $output; 
	}
	
	function next_post($ids) {
		global $posts;
		$next_post = return_array("SELECT `title`, `url`, `status` FROM $posts WHERE `id`='$ids' LIMIT 1", false);
		if ($token = $next_post->fetch(PDO::FETCH_ASSOC)) {
			if ($token['status'] == 'publish') {
				if (empty($token['title'])) {
					$token['title'] = 'Untitled Post';
				}
				return '<a class="left" href="'.get_friendly_url($token['url']).'" title="'.htmlspecialchars($token['title']).'">&lt; '.myTruncate($token['title'],40).'</a>';
			} 
		} else {
			return '<a class="left" href="#">This is the most recent post</a>';
		}
	}
	
	function last_post($ids) {
		global $posts, $order;
		if ($prev_post = return_array("SELECT `title`, `url`, `status` FROM $posts WHERE `id`='$ids'", false)) {
			if ($token = $prev_post->fetch(PDO::FETCH_ASSOC)) {
				if ($token['status'] == 'publish') {
					if($token['id'] <> $id) {
						if (empty($token['title'])) {
							$item['title'] = 'Untitled Post';
						}
					}
					return '<a class="right" href="'.get_friendly_url($token['url']).'" title="'.htmlspecialchars($token['title']).'">'.myTruncate($token['title'],40).' &gt;</a>';	
				}
			} else {
				return '<a class="right" href="#">This is the oldest post</a>';
			}
		}
	}
	
	function parse_theme_template($file) {
		global $plug_list, $head_list, $page_name, $tag_name, $numInArray, $search;

		$find = array(
			'url',
			'theme_dir',
			'site_name',
			'import_theme_css',
			'site_tagline',
			'page_name',
			'site_meta',
			'user_name',
			'blog_nav',
			'about_url',
			'archives_url',
			'footer',
			'version',
			'site_footer',
			'num_results',
			'tag_search',
			'search_term'
		);

		$i = 0;
		foreach ($find as $found) {
			$find[$i] = '<square:'.$found.' />';
			$i++;
		}

		$replace = array(
			URL,
			THEME_DIR,
			SITE_NAME,
			'<link rel="stylesheet" href="'.URL.'square/themes/'.$theme.'/'.'style.css" type="text/css" />',
			TAGLINE,
			$page_name,
			'<link rel="alternate" type="application/rss+xml" title="'.SITE_NAME.'" href="'.URL.'feed/" />'.PHP_EOL.'	<link rel="alternate" type="application/atom+xml" title="'.SITE_NAME.'" href="'.URL.'feed/?atom" />'.$head_list,
			ucfirst(USERNAME),
			blog_nav(),
			about_url(),
			archives_url(1),
			user_footer().$plug_list,
			VERSION,
			'<a href="http://github.com/tomchatting/SquareCMS/">:-)</a> '.HARD_NAME.' '.VERSION,
			$numInArray,
			'#'.strtoupper($tag_name),
			$search
		);

		return str_replace($find, $replace, $file);
	}
	
	function value_in($element_name, $xml, $content_only = true) {
		if ($xml == false) {
			return false;
		}
		$found = preg_match('#<'.$element_name.'(?:\s+[^>]+)?>(.*?)'.
				'</'.$element_name.'>#s', $xml, $matches);
		if ($found != false) {
			if ($content_only) {
				return $matches[1];  //ignore the enclosing tags
			} else {
				return $matches[0];  //return the full pattern match
			}
		}
		// No match found: return false.
		return false;
	}
	
	function user_footer() {
		global $pages;
		if ($query = return_array("SELECT * FROM $pages WHERE `url`='footer' and `type`='stub' LIMIT 1", false)) {
			if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
				return $result['content'];
			}
		}
	}
	
	function blog_nav() {
		global $pages;
		$nav = 	'<ul class="nav">';
		$nav = $nav.PHP_EOL.'<li title="Home"><a href="'.URL.'">Home</a></li>';
		$nav = $nav.PHP_EOL.'<li title="Archives"><a href="'.archives_url(1).'">Archives</a></li>';
		if ($_COOKIE[COOKIE_NAME] == COOKIE_VALUE) {
			$nav = $nav.PHP_EOL.'<li title="Admin"><a href="'.URL.SOFT_NAME.'">Admin</a></li>';
		}
		$query = return_array("SELECT * FROM $pages WHERE `type` <> 'stub' ORDER BY `name` ASC", false);
		while($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$nav = $nav.PHP_EOL.'<li title="'.$row['name'].'"><a href="'.page_url($row['url']).'">'.$row['name'].'</a></li>';
		}
		$nav = $nav.PHP_EOL.'</ul>';
		return $nav;
	}
	
	// truncate.php
	function myTruncate($string, $limit, $break=" ", $pad="...") {
		// return with no change if string is shorter than $limit
		if(strlen($string) <= $limit) return $string;
	
		$string = substr($string, 0, $limit);
		if(false !== ($breakpoint = strrpos($string, $break))) {
		$string = substr($string, 0, $breakpoint);
		}
	
	return $string . $pad;
	}
	
	// restoreTags
	function restoreTags($html) {
		#put all opened tags into an array
		preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
		$openedtags = $result[1];
		$openedtags = array_diff($openedtags, array("img", "hr", "br"));
		$openedtags = array_values($openedtags);
	
		#put all closed tags into an array
		preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
		$closedtags = $result[1];
		$len_opened = count ( $openedtags );
		# all tags are closed
		if( count ( $closedtags ) == $len_opened ) {
			return $html;
		}
		$openedtags = array_reverse ( $openedtags );
		# close tags
		for( $i = 0; $i < $len_opened; $i++ ) {
			if (!in_array($openedtags[$i], $closedtags)) {
				$html .= "</" . $openedtags[$i] . ">";
			} else {
				unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
			}
		}
		return $html;
	}
	
	function wordCount($html) {
		$wc = strip_tags($html);
		$pattern = "#[^(\w|\d|\'|\"|\.|\!|\?|;|,|\\|\/|\-|:|\&|@)]+#";
		$wc = trim(preg_replace($pattern, " ", $wc));
		$wc = trim(preg_replace("#\s*[(\'|\"|\.|\!|\?|;|,|\\|\/|\-|:|\&|@)]\s*#", " ", $wc));
		$wc = preg_replace("/\s\s+/", " ", $wc);
		$wc = explode(" ", $wc);
		$wc = array_filter($wc);
		return count($wc);
	}
	
	function make_date($date,$format) {
		global $date_format;
		global $uct_offset;
		if (!isset($format)) { $format = $date_format; }
		$date = explode(' ', $date);
		$dateArray = explode('-', $date[0]);
		$timeArray=explode(':', $date[1]);
		$date = mktime($timeArray[0], $timeArray[1], $timeArray[2], $dateArray[1], $dateArray[2], $dateArray[0]);
		return date($format, $date + $uct_offset);
	}
	
	function parse_tag($tag) {
		$tag = str_replace("<square:","",$tag);
		$tag = str_replace(" />","",$tag);
	}