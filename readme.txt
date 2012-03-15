=== Visual Website Optimizer ===
Contributors: @commentluv
Donate link:http://comluv.com/about/donate
Tags: split testing, analytics, stats, visual web optimizer
Requires at least: 2.7
Tested up to: 2.9.2
Stable tag: 2.0
	
World's easiest to use A/B, Split and Multivariate testing tool. 

== Description ==

This plugin will allow you to automatically insert the script required to test your site using the Visual Website Optimizer code. Just enter your ID from here http://visualwebsiteoptimizer.com/ to the settings page.
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

=2.0=
* Option to choose between asynchronous or synchronous code
* Updated code snippet
* Faster website loading

=1.3=
* code snippet updated

=1.0.1=
* use Website instead of Web in name of functions and readme (branding)

= 1.0 =
* First Version

== Configuration ==

Enter your ID in the field marked 'YOUR VWO ACCOUNT ID'

== Adding to your template ==

header code :
`<?php wp_head();?>`

footer code : 
`<?php wp_footer();?>`