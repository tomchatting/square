<?php

Class Square {

  # version is symantic where possible
  static $version = '2.0-alpha';

  # set $site as a static so we can modify it and read it down the line
  #   particularly in other classes
  static $site    = array(
    'title' => 'Blog',
    'version' => '2.0-alpha'
  );

  # takes a file path as a variable and passes it to Pages::
  function create_page($file_path) {

    $path = $file_path[0];
    $request = $file_path[4];
    if (!$request) { $request = 1; }

    if(method_exists('Pages', $path)) {
      Pages::$path($request, $file_path);
    } else {
      Pages::p($path);
    }

  }

  # in PHP/5.3.0 they added a requisite for setting a default timezone, this should be handled via the php.ini, but as we cannot rely on this, we have to set a default timezone ourselves
  function php_fixes() {

    if(function_exists('date_default_timezone_set')) date_default_timezone_set('Europe/London');

  }

  # this is how we do it
  function __construct($get) {

    $this->php_fixes();

    # some database settings
    $db_posts 		= Config::$db_prefix.'posts';
    $db_trash 		= Config::$db_prefix.'posts_trash';
    $db_settings  = Config::$db_prefix.'settings';

    $result = Database::sql_command("SELECT * FROM $db_settings");
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $setting[$row['name']] = $row['value'];
    }

    $domain = preg_replace('#^www\.#', '', $_SERVER['SERVER_NAME']);
    $url = str_replace('index.php', '', 'http://'.$domain.$_SERVER['PHP_SELF']);
    self::$site['title'] = $setting['site_name'];
    self::$site['headline'] = $setting['tagline'];

    # check to see if we're using htaccess and add a ?, otherwise spit out the url
    self::$site['url'] = file_exists('.htaccess') ? $url : $url.'?/';
    self::$site['template'] = $setting['template'];
    self::$site['template-url'] = $url.'square/templates/'.$setting['template'].'/';

    $input = Helpers::get_url_input();

    # set the input as 'archive', basically allows index to work
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
