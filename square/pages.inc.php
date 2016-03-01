<?php

Class Pages {

  static function page($request = 1) {

    $nav = Helpers::construct_nav();

    function get_archives($page_title = "Archives") {

      // Pull the results from post in blog order, limited to 6 (or "n") from the start value

      $DateNow = gmdate("Y-m-d H:i:s");

      return Database::return_array("SELECT * FROM `square_posts` WHERE `date` <= '$DateNow' AND `status` = 'publish' AND `type` = 'article' ORDER BY `date` DESC, `id` DESC", true);

    }

    if ($request == 1) {$name = "Home";} else {$name = "Archives";}

    $result = get_archives($name);

    $assigns = array(
    'site' => Square::$site,
    'page' => array(
      'title' => $name
    ),
    'nav' => $nav,
    'posts' => $result
    );

    Template::parse($assigns);

  }

  static function articles($request) {

    $nav = Helpers::construct_nav();

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
    'nav' => $nav,
    'post' => $result
    );

    Template::parse($assigns, 'article');

  }

  static function p($request) {

    $nav = Helpers::construct_nav();

    $p = Database::return_array("SELECT * FROM `square_posts` WHERE `type` = 'page' AND `title` LIKE '$request' LIMIT 1", false);

    $assigns = array(
    'site' => Square::$site,
    'nav' => $nav,
    'page' => $p
    );

    Template::parse($assigns, 'p');

  }

  static function admin($request) {
    
    new Admin($_GET);

  }

}

 ?>
