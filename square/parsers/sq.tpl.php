<?php

  define('LIQUID_INCLUDE_SUFFIX', 'tpl');
  define('LIQUID_INCLUDE_PREFIX', '');

  require_once('./square/parsers/liquid.ext.php');

  Class Template {

    static function parse($assigns, $page = 'page') {

      # build the template url based off the user's choice
      $template_url = './square/templates/'.Square::$site['template'].'/';

      $liquid = new LiquidTemplate($template_url);

      switch($page) {
        case 'article':
          $liquid->parse(file_get_contents($template_url.'post.tpl'));
          print $liquid->render($assigns);
          break;
        case 'p':
          $liquid->parse(file_get_contents($template_url.'page.tpl'));
          print $liquid->render($assigns);
          break;
        case 'categories':
          $liquid->parse(file_get_contents($template_url.'categories.tpl'));
          print $liquid->render($assigns);
          break;
        default:
          $liquid->parse(file_get_contents($template_url.'index.tpl'));
          print $liquid->render($assigns);
      }

    }

  }

 ?>
