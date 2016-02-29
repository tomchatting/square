<?php

  define('LIQUID_INCLUDE_SUFFIX', 'tpl');
  define('LIQUID_INCLUDE_PREFIX', '');

  require_once('./square/parsers/liquid.ext.php');

  Class Template {

    static function parse($assigns, $page = 'page') {

      switch($page) {
        case 'article':
          $liquid = new LiquidTemplate('./square/templates/default/');
          $liquid->parse(file_get_contents('./square/templates/default/post.tpl'));
          print $liquid->render($assigns);
          break;
        default:
          $liquid = new LiquidTemplate('./square/templates/default/');
          $liquid->parse(file_get_contents('./square/templates/default/index.tpl'));
          print $liquid->render($assigns);
      }

    }

  }

 ?>
