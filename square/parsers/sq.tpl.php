<?php

  define('LIQUID_INCLUDE_SUFFIX', 'tpl');
  define('LIQUID_INCLUDE_PREFIX', '');

  require_once('./square/parsers/liquid.ext.php');

  Class Template {

    static function parse($assigns, $page = 'page') {

      $liquid = new LiquidTemplate('./square/templates/default/');

      switch($page) {
        case 'article':
          $liquid->parse(file_get_contents('./square/templates/default/post.tpl'));
          print $liquid->render($assigns);
          break;
        case 'p':
          $liquid->parse(file_get_contents('./square/templates/default/page.tpl'));
          print $liquid->render($assigns);
          break;
        case 'categories':
          $liquid->parse(file_get_contents('./square/templates/default/categories.tpl'));
          print $liquid->render($assigns);
          break;
        default:
          $liquid->parse(file_get_contents('./square/templates/default/index.tpl'));
          print $liquid->render($assigns);
      }

    }

  }

 ?>
