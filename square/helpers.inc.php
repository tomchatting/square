<?php

Class Helpers {

  static function rglob($pattern, $flags = 0, $path = '') {
    if (!$path && ($dir = dirname($pattern)) != '.') {
      if ($dir == '\\' || $dir == '/') $dir = '';
      return self::rglob(basename($pattern), $flags, $dir . '/');
    }
    $paths = glob($path . '*', GLOB_ONLYDIR | GLOB_NOSORT);
    $files = glob($path . $pattern, $flags);
    if(is_array($paths) && is_array($files)) {
      foreach ($paths as $p) $files = array_merge($files, self::rglob($pattern, $flags, $p . '/'));
    }
    return is_array($files) ? $files : array();
  }

  static function construct_nav() {

    return Database::return_array("SELECT `title`,`url` from `square_posts` WHERE `type`='page'", true);

  }

  /*
    Function Name: get_url_input()
    Author: Thomas Chatting
    Version: 1.0
    Description: Returns anything in the URL after the 'destination' as an array of instructions
  */
  static function get_url_input() {

    # parse users input
    $uri = $_SERVER['REQUEST_URI'];
    # Strip any .html from the URL
    $uri = preg_replace('#\.html#','',$uri);

    # Strip any .xhtml from the URL
    $uri = preg_replace('#\.xhtml#','',$uri);

    # Strip the .php from the URL (if there is one)
    $uri = preg_replace('#\.php#','',$uri);

    # Strip the ? from the URL (handling weird configs in Apache)
    $uri = preg_replace('#\?\/#','',$uri);
    $temp = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
    $uri = str_replace($temp, '', $uri);

    if ($uri[0] == '/') {
      # If the first character of input is "/" this might break our array
      $uri = substr($uri, 1);
    }

    # returns an array
    return explode('/',$uri);

  }

  /*
    Function Name: curPageURL()
    Author: http://www.webcheatsheet.com/PHP/get_current_page_url.php
    Version: 1.0
    Description: Sometimes, you might want to get the current page URL that is shown in the browser URL window.
  */
  static function curPageURL() {
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
    Function Name: base58_decode() and base58_encode()
    Author: http://darklaunch.com/2009/08/07/base58-encode-and-decode-using-php-with-example-base58-encode-base58-decode
    Version: 1.0
    Description: Encodes and decodes base58 strings
  */
  static function base58_decode($num) {
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

  static function base58_encode($num) {
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

}

 ?>
