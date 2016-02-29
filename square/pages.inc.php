<?php

Class Pages {

  static function page($request = 1) {

    function get_archives($page = 1, $num = 6, $page_title = "Archives") {

      $start = (($page - 1) * $num); // Default to 0

      // Pull the results from post in blog order, limited to 6 (or "n") from the start value

      $DateNow = gmdate("Y-m-d H:i:s");

      return Database::return_array("SELECT * FROM `square_posts` WHERE `date` <= '$DateNow' AND `status` = 'publish' ORDER BY `date` DESC, `id` DESC LIMIT $start, $num", true);

    }

    if ($request == 1) {$name = "Home";} else {$name = "Archives";}
    $result = get_archives($request,6,$name);

    $assigns = array(
    'site' => Square::$site,
    'page' => array(
      'title' => $name
    ),
    'posts' => $result
    );

    Template::parse($assigns);

  }

  static function articles($request) {

    function get_article($title) {

      try {
        return Database::return_array("SELECT * FROM `square_posts` WHERE `url` LIKE '$title' LIMIT 1", false);
      }
      catch(PDOException $e)
      {
        return $e->getMessage();
      }

    }

    $result = get_article($request);
    
    $assigns = array(
    'site' => Square::$site,
    'page' => array(
      'title' => $result['title']
    ),
    'post' => $result
    );

    Template::parse($assigns, 'article');

  }

}

 ?>
