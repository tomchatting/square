# square
> like removing the tatty old table cloth and trying to put a new fucking table under it

Welcome back, it's been a while.

## wtf is a square
SquareCMS was an attempt at a PHP Content Management System I hacked away about ten years ago. After about three years of neglect I hacked PDO onto it late last year but other than that I left it to rot in favour of using Jekyll and GitHub pages.

## why come back?
Because I'm bored and have a week off work.

## no really, why come back?
I dunno man, opensource guilt?

## fuck you i liked the old square
Now we both know that's a lie, but if you're that much of a masochist hit up [this](https://github.com/tomchatting/SquareCMS/tree/598e8992f2e474296b3451a72f179315325e9b5e) version of the app and make sure you're running it on PHP <=4.3.

## what's changed?
From a database perspective, very little; I'm quite happy with the setup I chose on that front. From a raw PHP perspective, I've transformed Square into an OOP application, reusing several functions but rewriting the vast majority of it all from scratch. I've also switched the templating system to Liquid (with the pagination plugin hacked on), removing that nasty XHTML `<square:tag />` bullshit.

## okay, so what's not done?
As a rough guideline, the following is missing:

- [x] admin-- this one is a partial, some stuff is still WIP
  - [ ] fix urls (at the moment the user has to create their own urls for posts/pages)
  - [ ] fix settings pages
  - [ ] remove hard coding from timezones
- [x] page support
- [x] tag support--I've gone with the categories idea
- [ ] searching
- [ ] rss/atom
- [ ] add [parsedown](http://parsedown.org) support

This is all coming, plus thanks to the OOP nature of my new beast, I'm hoping plugins and extensions will become super easy to add, fulfilling a 5 year old promise to myself to actually add it.

## installation
> I've had to remove the installation/upgrade guide because I've modified a *tad* too much in the database now (adding categories), but I have added a working demo to a shard on OpenShift

### square/config.php

```
<?php

class Config {

  # settings etc

  public static $db_settings  = array('host' => 'localhost', 'username' => 'root', 'password' => 'password', 'database' => 'test');

  # square's actual settings (mainly for me to fuck with)

  public static $db_prefix    = 'square_';
  public static $soft_name    = 'square';
  public static $hard_name    = 'The Bespoke Blog Engine - SquareCMS';

}

?>
```

### sql_command

```
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `square_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `square_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `url` varchar(50) NOT NULL,
  `type` varchar(7) NOT NULL DEFAULT 'article',
  `category1` int(11) NOT NULL,
  `category2` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(7) DEFAULT 'draft',
  `blurb` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `square_settings` (
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
```

### square_settings

Next, go into `square_settings` and add the following rows:

| name | value |
| --- | --- |
| `username` | your username |
| `password` | `hash('sha256', passw0rd.salt)` |
| `site_name` | your site's title |
| `tagline` | a headline for the site |
| `template` | `default`* |

\* Currently unused (along with some others), functionality will come back 'soon'.

## [demo](http://square-shiftysu.rhcloud.com)

## what's the license?
MIT license:

```
The MIT License (MIT)
Copyright (c) 2016 Thomas Chatting

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
```
