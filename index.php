<?php

 ## ### # #  ## ### ###
 #  # # # # # # #   ##
##  ### ### ### #   ###
     #

/* square - copyright (c) Thomas Chatting 2010-2016
 * https://github.com/tomchatting/square
 * MIT license */

# kill the entire thing if someone is running on (old) php
if(phpversion() < 5.3) {
  die('<h3>this app requires php 5.3 or higher.<br>you are running on php '.phpversion().'.');
} else {

  # while in alpha it's best we report all errors as they lay
  error_reporting(E_ALL^E_NOTICE);
  # require config
  require_once './square/config.php';
  # require helpers
  require_once './square/helpers.inc.php';
  # require the template parser
  require_once './square/parsers/sq.tpl.php';
  # include php files sitting in the apps folder
  foreach(Helpers::rglob('./square/**.inc.php') as $include) include_once $include;

  # run
  new Square($_GET);

}

?>
