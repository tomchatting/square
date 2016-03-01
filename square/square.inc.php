<?php

Class Square {

  static $version = '2.0.fb8fc91';

  static $site    = array(
    'title' => 'Blog',
    'version' => '2.0.fb8fc91'
  );

  function create_page($file_path) {

    $path = $file_path[0];
    $request = $file_path[1];

    if(method_exists('Pages', $path)) {
      Pages::$path($request);
    } else {
      Pages::p($path);
    }

  }

  function __construct($get) {

    # some database settings
    $db_posts 		= Config::$db_prefix.'posts';
    $db_trash 		= Config::$db_prefix.'posts_trash';
    $db_pages 		= Config::$db_prefix.'pages';
    $db_settings  = Config::$db_prefix.'settings';

    $result = Database::sql_command("SELECT * FROM $db_settings");
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $setting[$row['name']] = $row['value'];
    }

    $domain = preg_replace('#^www\.#', '', $_SERVER['SERVER_NAME']);
    self::$site['title'] = $setting['site_name'];
    self::$site['headline'] = $setting['tagline'];
    self::$site['url'] = str_replace('index.php', '', 'http://'.$domain.$_SERVER['PHP_SELF']);

    $input = Helpers::get_url_input();

    # make these cases instead of ifs

    if (!$input[0]) {$input[0] = 'page'; $input[1] = 1;}

    try {
      # create and render the current page
      $this->create_page($input);
    } catch(Exception $e) {
      if($e->getMessage() == "404") {
        # return 404 headers
        header('HTTP/1.0 404 Not Found');
        if(file_exists(Config::$soft_name.'/themes/default/404.html')) {
          $this->route = '404';
          $this->create_page('404.html');
        }
        else {
          echo '<!doctype html><html><title>404: file not found</title><h1>404</h1><h2>Page could not be found.</h2><p>Unfortunately, the page you were looking for does not exist here.</p>';
        }
      } else {
        echo '<!doctype html><html><title>Error</title><h3>'.$e->getMessage().'</h3>';
      }

    }

  }

}

 ?>
