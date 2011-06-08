=== MD Table of Contents Generator ===
Contributors: mdavison
Tags: table of contents, generated table of contents, index
Requires at least: 3.01
Tested up to: 3.01
Stable tag: trunk

Plugin to automatically generate a table of contents based on Headings tags.


== Description ==

Plugin to automatically generate a table of contents based on Headings tags. Also generates links to the headings on the page. User can choose which headings
tags to include in Settings.


== Installation ==

1. Upload the entire 'md-toc-generator' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Put `[toc]` in your post or page where you want the table of contents to display. It is 
   configured to include all `<h1>` through `<h6>` tags by default, unless selected otherwise 
   in the settings

You will find the 'Table of Contents' menu in the Settings menu in the admin panel.


== Frequently Asked Questions ==


== Screenshots ==

1. screenshot1.png: View of generated table of contents. Included css file can be customized however you like.
2. screenshot2.png: View of the settings page
3. screenshot3.png: View of using the '[toc]' tag in a post


== Changelog ==

= 1.0 =
Fixed admin stylesheet being added above html

= .1 =
Alpha


== Upgrade Notice ==

= 1.0 =
Fixes error to the effect of "headers already sent by..."