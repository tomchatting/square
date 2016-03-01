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

      echo '<!DOCTYPE html>
      <html lang=en>
      <title>'.Square::$site['title'].' admin</title>
      <style>
        *{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}html,body{margin:0;padding:0}html{font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;font-size:16px;line-height:1.5}@media (min-width: 38em){html{font-size:18px}}body{color:#515151;background-color:#fff;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{color:#268bd2;text-decoration:none}a:hover,a:focus{text-decoration:underline}a strong{color:inherit}img{display:block;max-width:100%;margin:0 0 1rem;border-radius:5px}table{margin-bottom:1rem;width:100%;font-size:85%;border:1px solid #e5e5e5;border-collapse:collapse}td,th{padding:.25rem .5rem;border:1px solid #e5e5e5}th{text-align:left}tbody tr:nth-child(odd) td,tbody tr:nth-child(odd) th{background-color:#f9f9f9}h1,h2,h3,h4,h5,h6{margin-bottom:.5rem;font-weight:bold;line-height:1.25;color:#313131;text-rendering:optimizeLegibility}h1{font-size:2rem}h2{margin-top:1rem;font-size:1.5rem}h3{margin-top:1.5rem;font-size:1.25rem}h4,h5,h6{margin-top:1rem;font-size:1rem}p{margin-top:0;margin-bottom:1rem}strong{color:#303030}ul,ol,dl{margin-top:0;margin-bottom:1rem}dt{font-weight:bold}dd{margin-bottom:.5rem}hr{position:relative;margin:1.5rem 0;border:0;border-top:1px solid #eee;border-bottom:1px solid #fff}abbr{font-size:85%;font-weight:bold;color:#555;text-transform:uppercase}abbr[title]{cursor:help;border-bottom:1px dotted #e5e5e5}blockquote{padding:.5rem 1rem;margin:.8rem 0;color:#7a7a7a;border-left:.25rem solid #e5e5e5}blockquote p:last-child{margin-bottom:0}@media (min-width: 30em){blockquote{padding-right:5rem;padding-left:1.25rem}}a[href^="#fn:"],a[href^="#fnref:"]{display:inline-block;margin-left:.1rem;font-weight:bold}.footnotes{margin-top:2rem;font-size:85%}.lead{font-size:1.25rem;font-weight:300}.highlight .hll{background-color:#ffc}.highlight .c{color:#999}.highlight .err{color:#a00;background-color:#faa}.highlight .k{color:#069}.highlight .o{color:#555}.highlight .cm{color:#09f;font-style:italic}.highlight .cp{color:#099}.highlight .c1{color:#999}.highlight .cs{color:#999}.highlight .gd{background-color:#fcc;border:1px solid #c00}.highlight .ge{font-style:italic}.highlight .gr{color:red}.highlight .gh{color:#030}.highlight .gi{background-color:#cfc;border:1px solid #0c0}.highlight .go{color:#aaa}.highlight .gp{color:#009}.highlight .gu{color:#030}.highlight .gt{color:#9c6}.highlight .kc{color:#069}.highlight .kd{color:#069}.highlight .kn{color:#069}.highlight .kp{color:#069}.highlight .kr{color:#069}.highlight .kt{color:#078}.highlight .m{color:#f60}.highlight .s{color:#d44950}.highlight .na{color:#4f9fcf}.highlight .nb{color:#366}.highlight .nc{color:#0a8}.highlight .no{color:#360}.highlight .nd{color:#99f}.highlight .ni{color:#999}.highlight .ne{color:#c00}.highlight .nf{color:#c0f}.highlight .nl{color:#99f}.highlight .nn{color:#0cf}.highlight .nt{color:#2f6f9f}.highlight .nv{color:#033}.highlight .ow{color:#000}.highlight .w{color:#bbb}.highlight .mf{color:#f60}.highlight .mh{color:#f60}.highlight .mi{color:#f60}.highlight .mo{color:#f60}.highlight .sb{color:#c30}.highlight .sc{color:#c30}.highlight .sd{color:#c30;font-style:italic}.highlight .s2{color:#c30}.highlight .se{color:#c30}.highlight .sh{color:#c30}.highlight .si{color:#a00}.highlight .sx{color:#c30}.highlight .sr{color:#3aa}.highlight .s1{color:#c30}.highlight .ss{color:#fc3}.highlight .bp{color:#366}.highlight .vc{color:#033}.highlight .vg{color:#033}.highlight .vi{color:#033}.highlight .il{color:#f60}.css .o,.css .o+.nt,.css .nt+.nt{color:#999}code,pre{font-family:Menlo, Monaco, "Courier New", monospace}code{padding:.25em .5em;font-size:85%;color:#bf616a;background-color:#f9f9f9;border-radius:3px}pre{margin-top:0;margin-bottom:1rem}pre code{padding:0;font-size:100%;color:inherit;background-color:transparent}.highlight{padding:1rem;margin-bottom:1rem;font-size:.8rem;line-height:1.4;background-color:#f9f9f9;border-radius:.25rem}.highlight pre{margin-bottom:0;overflow-x:auto}.highlight .lineno{display:inline-block;padding-right:.75rem;padding-left:.25rem;color:#999;-webkit-user-select:none;-moz-user-select:none;user-select:none}.container, textarea{max-width:38rem;padding-left:1.5rem;padding-right:1.5rem;margin-left:auto;margin-right:auto}footer{margin-bottom:2rem}.masthead{padding-top:1rem;padding-bottom:1rem;margin-bottom:3rem}.masthead-title{margin-top:0;margin-bottom:0;color:#505050}.masthead-title a{color:#505050}.masthead-title small{font-size:75%;font-weight:400;color:#c0c0c0;letter-spacing:0}.page,.post{margin-bottom:4em}.page-title,.post-title,.post-title a{color:#303030}.page-title,.post-title{margin-top:0}.post-date{display:block;margin-top:-.5rem;margin-bottom:1rem;color:#9a9a9a}.related{padding-top:2rem;padding-bottom:2rem;border-top:1px solid #eee}.related-posts{padding-left:0;list-style:none}.related-posts h3{margin-top:0}.related-posts li small{font-size:75%;color:#999}.related-posts li a:hover{color:#268bd2;text-decoration:none}.related-posts li a:hover small{color:inherit}.pagination{overflow:hidden;margin:0 -1.5rem 1rem;font-family:"PT Sans", Helvetica, Arial, sans-serif;color:#ccc;text-align:center}.pagination-item{display:block;padding:1rem;border:solid #eee;border-width:1px 0}.pagination-item:first-child{margin-bottom:-1px}a.pagination-item:hover{background-color:#f5f5f5}@media (min-width: 30em){.pagination{margin:3rem 0}.pagination-item{float:left;width:50%;border-width:1px}.pagination-item:first-child{margin-bottom:0;border-top-left-radius:4px;border-bottom-left-radius:4px}.pagination-item:last-child{margin-left:-1px;border-top-right-radius:4px;border-bottom-right-radius:4px}}.message{margin-bottom:1rem;padding:1rem;color:#717171;background-color:#f9f9f9}input,button,select,textarea{font-size:16px;line-height:1.6}
        textarea{width:100%;height:10rem;margin:0;padding:0.2rem;}
        input.title{width:100%}
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
            <small><a href=./>new</a> | <a href=?cmd=manage>manage</a> | <a href=?cmd=categories>categories</a> | <a href=\'../\'>preview</a> | <a class=right href="?logout">logout</a></small>
          </h3>
        </header>
      ';

      switch($_GET["cmd"]) {
        case 'manage':
          $result = Database::return_array('SELECT `id`,`title`,`url`,`date`,`status`,`type` from `square_posts`',true);
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
        default:
          if(isset($_POST['new'])) {

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

            echo('<div class="container message">Post <code>'.$_POST['title'].'</code> commited. </div>');

          }

          include('./square/templates/admin/post.tpl');
      }

    }

  }


 ?>
