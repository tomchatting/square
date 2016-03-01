<?php
  ob_start();

  Class Admin {

    function __construct($get) {

      define('COOKIE_SALT',	'BB3154R4TH3RG00DBL0G3NG1N3');
      $domain = preg_replace('#^www\.#', '', $_SERVER['SERVER_NAME']);

      $result = Database::sql_command("SELECT * FROM `square_settings`");
      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $setting[$row['name']] = $row['value'];
      }

      // NOMOMOM - COOKIES
      define('COOKIE_NAME', 	'square_auth');
      define('COOKIE_VALUE', 	md5($setting['username'].$setting['password'].COOKIE_SALT));
      define('COOKIE_DOMAIN',	'.'.$domain);
      define('NOW',			time());
      define('WEEK',			(24 * 60 * 60) * 7 );

      echo '<style>
        html {
          font: 18px/1.5 \'Helvetica Neue\', helvetica, arial, sans-serif;
          background: #fff;
          color: #515151;
        }
      </style>';

      if (isset($_POST['username'])) {
  			if (md5($_POST['username'].md5($_POST['password']).COOKIE_SALT) == COOKIE_VALUE) {
  				setcookie(COOKIE_NAME, COOKIE_VALUE, NOW + WEEK, '/', COOKIE_DOMAIN);
  				$_COOKIE[COOKIE_NAME] = COOKIE_VALUE;
  			} else {
  				$fail = true;
  				include('./square/templates/admin/login.tpl');
  				exit();
  			}
  		}

      // handle logout
      if (isset($_GET['logout'])) {
        setcookie(COOKIE_NAME, '', NOW - WEEK, '/', COOKIE_DOMAIN);
        unset($_COOKIE[COOKIE_NAME]);
        header('Location:./');
        exit();
      }

      // require login
      if (!isset($_COOKIE[COOKIE_NAME]) || $_COOKIE[COOKIE_NAME] != COOKIE_VALUE) {
        include('./square/templates/admin/login.tpl');
        exit();
      } else {
        echo '<p>is logged in, let\'s show them the goods, or let them <a href="?logout">logout.</a></p>';
        setcookie(COOKIE_NAME, COOKIE_VALUE, NOW + WEEK, '/', COOKIE_DOMAIN);
      }

      switch($_POST["cmd"]) {
        default:
          if (!isset($_POST["submit"])) {
            include('./square/templates/admin/post.tpl');
          } else {
            echo '<p>you tried to submit a new post</p>';
          }
      }

    }

  }


 ?>
