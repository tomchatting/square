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
      define('COOKIE_VALUE', 	hash('sha256', $setting['username'].$setting['password']));
      define('COOKIE_DOMAIN',	'.'.$domain);
      define('NOW',			time());
      define('WEEK',			(24 * 60 * 60) * 7 );

      include('./square/templates/admin/top.tpl');

      if (isset($_POST['username'])) {
  			if (hash('sha256', $_POST['username'].hash('sha256', $_POST['password'].COOKIE_SALT)) == COOKIE_VALUE) {
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
        header('Location:./?lo');
        exit();
      }

      // require login
      if (!isset($_COOKIE[COOKIE_NAME]) || $_COOKIE[COOKIE_NAME] != COOKIE_VALUE) {
        include('./square/templates/admin/login.tpl');
        exit();
      } else {
        setcookie(COOKIE_NAME, COOKIE_VALUE, NOW + WEEK, '/', COOKIE_DOMAIN);
      }

      echo '
        <header class="masthead container">
          <h3 class="masthead-title">
            <a href="./">Admin</a>
            <small><a href=./>new</a> | <a href=?cmd=manage>manage</a> | <a href=?cmd=categories>categories</a> | <a href=?cmd=settings>settings</a> | <a target=_blank href=\'../\'>preview</a> | <a class=right href="?logout">logout</a></small>
          </h3>
        </header>
      ';

      switch($_GET["cmd"]) {
        case 'manage':

          if(isset($_GET['delete'])) {

            $dbh = Database::database_connect(Config::$db_settings['host'], Config::$db_settings['database'], Config::$db_settings['username'], Config::$db_settings['password']);

            $stmnt = $dbh->prepare('DELETE FROM `square_posts` WHERE `id` = :post_id');
            $stmnt->bindParam(':post_id', $_GET['delete']);

            $stmnt->execute();

            echo('<div class="message container">Post <code>'.$_GET['delete'].'</code> deleted.</div>');

          }
          $result = Database::return_array('SELECT `id`,`title`,`url`,`date`,`status`,`type` from square_posts ORDER by ID asc',true);
          include('./square/templates/admin/manage.tpl');
          break;

        case 'edit':

          if(isset($_POST['edit'])) {
            $dbh = Database::database_connect(Config::$db_settings['host'], Config::$db_settings['database'], Config::$db_settings['username'], Config::$db_settings['password']);

            $stmnt = $dbh->prepare('UPDATE square_posts
              SET
                `title` = :post_title,
                `url` = :post_url,
                `type` = :post_type,
                `category1` = :post_categoryo,
                `category2` = :post_categoryt,
                `content` = :post_content,
                `date` = :post_date,
                `status` = :post_status
              WHERE `id`=:post_id
              ');

            $stmnt->bindParam(':post_title', $_POST['title']);
            $stmnt->bindParam(':post_url', $_POST['url']);
            $stmnt->bindParam(':post_type', $_POST['type']);
            $stmnt->bindParam(':post_categoryo', $_POST['category1']);
            $stmnt->bindParam(':post_categoryt', $_POST['category2']);
            $stmnt->bindParam(':post_content', $_POST['content']);
            $stmnt->bindParam(':post_date', $_POST['date']);
            $stmnt->bindParam(':post_status', $_POST['status']);
            $stmnt->bindParam(':post_id', $_POST['id']);

            $stmnt->execute();

            echo('<div class="container message">Post <code>'.$_POST['title'].'</code> updated. </div>');

          }
          $post = Database::return_array('SELECT * from `square_posts` WHERE `id`='.intval($_GET['id']).' LIMIT 1', false);
          include('./square/templates/admin/post.tpl');
          break;

        case 'categories':

          if(isset($_POST['submit'])) {
            if($_POST['name'] == '') {

              echo('<div class="message container">Category <code>name</code> cannot be null.</div>');

            } else {

            $dbh = Database::database_connect(Config::$db_settings['host'], Config::$db_settings['database'], Config::$db_settings['username'], Config::$db_settings['password']);

            $stmnt = $dbh->prepare('INSERT INTO `square_categories` SET `name` = :category_name');
            $stmnt->bindParam(':category_name', $_POST['name']);

            $stmnt->execute();

            }
          }
          if(isset($_GET['delete'])) {

            $dbh = Database::database_connect(Config::$db_settings['host'], Config::$db_settings['database'], Config::$db_settings['username'], Config::$db_settings['password']);

            $stmnt = $dbh->prepare('DELETE FROM `square_categories` WHERE `id` = :category_id');
            $stmnt->bindParam(':category_id', $_GET['delete']);

            $stmnt->execute();

            echo('<div class="message container">Deleted category <code>'.$_GET['delete'].'</code>.</div>');

          }
          $result = Database::return_array('SELECT * from `square_categories`',true);
          include('./square/templates/admin/categories.tpl');
          break;

        case 'settings':

          $result = Database::return_array('SELECT * from `square_settings`',true);
          include('./square/templates/admin/settings.tpl');
          break;

        default:

          if(isset($_POST['new'])) {
            if($_POST['title'] == '' || $_POST['url'] == '' || $_POST['content'] == '' || $_POST['date'] == '') {
              echo('<div class="container message">Please check input and try again.</div>');
            } else {
              $dbh = Database::database_connect(Config::$db_settings['host'], Config::$db_settings['database'], Config::$db_settings['username'], Config::$db_settings['password']);

              $stmnt = $dbh->prepare('INSERT INTO square_posts
                SET
                  `title` = :post_title,
                  `url` = :post_url,
                  `type` = :post_type,
                  `category1` = :post_categoryo,
                  `category2` = :post_categoryt,
                  `content` = :post_content,
                  `date` = :post_date,
                  `status` = :post_status
                ');

              $stmnt->bindParam(':post_title', $_POST['title']);
              $stmnt->bindParam(':post_url', $_POST['url']);
              $stmnt->bindParam(':post_type', $_POST['type']);
              $stmnt->bindParam(':post_categoryo', $_POST['category1']);
              $stmnt->bindParam(':post_categoryt', $_POST['category2']);
              $stmnt->bindParam(':post_content', $_POST['content']);
              $stmnt->bindParam(':post_date', $_POST['date']);
              $stmnt->bindParam(':post_status', $_POST['status']);

              $stmnt->execute();

              echo('<div class="container message">Post <code>'.$_POST['title'].'</code> committed. </div>');

            }
          }

          include('./square/templates/admin/post.tpl');
      }

    }

  }


 ?>
