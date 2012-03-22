=== Visual Website Optimizer ===
Contributors: @commentluv, VWO
Plugin Name: Visual Website Optimizer
Plugin URI: http://visualwebsiteoptimizer.com/
Tags: split testing, analytics, stats, visual web optimizer, vwo
Donate link:http://comluv.com/about/donate
Requires at least: 2.7
Tested up to: 3.3.1
Stable tag: 2.3

World's easiest to use A/B, Split and Multivariate testing tool. 

== Description ==
This plugin will allow you to automatically insert the Visual Website Optimizer tracking code. Just enter your VWO Account ID from http://v2.visualwebsiteoptimizer.com/account/

== Installation ==
Wordpress : Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

WordpressMu : Same as above 

== Frequently Asked Questions ==
= I can't see any code added to my header or footer when I view my page source =
Your theme needs to have the header and footer actions in place before the `</head>` and before the `</body>`

= If I use this plugin, do I need to enter any other code on my website? =
No, this plugin is sufficient by itself

== Screenshots ==
1. Settings page (Asynchronous Code)
2. Settings page (Synchronous Code)

== ChangeLog ==
= 2.3 =
* Minor bug fix

= 2.2 =
* Bug fix to have default tolerance values when plugin is updated

= 2.1 =
* Better documentation

= 2.0 =
* Option to choose between asynchronous or synchronous code
* Updated code snippet
* Faster website loading

= 1.3 =
* code snippet updated

= 1.0.1 =
* use Website instead of Web in name of functions and readme (branding)

= 1.0 =
* First Version

== Upgrade Notice ==
Option to choose the new asynchronous code. This will make the website load faster

== Configuration ==

Enter your ID in the field marked 'YOUR VWO ACCOUNT ID'

== Adding to your template ==

header code :
`<?php wp_head();?>`

footer code : 
`<?php wp_footer();?>`