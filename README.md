# SquareCMS
> like removing the tatty old table cloth and trying to put a new fucking table under it

Welcome back, it's been a while.

## wtf is a squarecms
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

* an admin (though that's next on my list--the dream is to have a procedurally generated new/edit page, so you can add/remove tags to pages as easy as pie) -- *WIP!*
* ~~page support~~ done!
* ~~tag support (should I keep this? I'm thinking maybe I should rename it categories and add a new table to the database for hard linking)~~ categories added (textpattern style rather than wordpress style)
* searching

This is all coming, plus thanks to the OOP nature of my new beast, I'm hoping plugins and extensions will become super easy to add, fulfilling a 5 year old promise to myself to actually add it.

## installation
> I've had to remove the installation/upgrade guide because I've modified a *tad* too much in the database now (adding categories), but I have added a working demo to a shard on OpenShift

## [demo](http://square-shiftysu.rhcloud.com)

## what's the license?
Same as always:

### DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
#### Version 2, December 2004

 Copyright (C) 2016 Thomas Chatting <thomas.chatting@icloud.com>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

	DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO. 
