<?php

# well, that was a fun four year break, let's try this again

# kill the entire thing if someone is running on (old) php
if(phpversion() < 5.3) {
  die('<h3>this app requires php 5.3 or higher.<br>you are running on php '.phpversion().'. go figure.');
} else {

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
