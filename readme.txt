=== Plugin Name ===
Contributors: rememberlenny <Leonard Kiyoshi Bogdonoff>
Tags: remind to read, user reminder, user relationship, media tools
Requires at least: 3.0.1
Donate link: http://www.rememberlenny.com
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provide your users a reminder to come back to where they were

== Description ==

Remind To Read lets your users remind themselves about your content. 

Major features in Remindto.app include:

*	Gracefully prompt users with reminder option using modal that appears when users scroll up
*	Tracking hooks for event analytics using custom JavaScript events

PS: You'll need an RemindToRead.com API key to use it. Keys are free for personal blogs; paid subscriptions are available for businesses and commercial sites.

== Installation ==

1. Upload `wp-remind-to-read` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('article_pre_content'); ?>` in your templates with article content

== Frequently Asked Questions ==

= Can I style the module that prompts users? =

Yes! The CSS in the plugin file can be modified, or the classes used can be overwritten in your theme.

= Are there any JavaScript events to hook into the module's behavior> =

Yes. There are a series of custom JavaScript events that you can use. These are good for triggering analytics events, firing brower behavior, or adding other style hooks.

== Screenshots ==

`https://cloud.githubusercontent.com/assets/1332366/10227417/2d1a5d58-683b-11e5-89c5-05424bbb3955.gif`

1. This is a working screen of the podcast when users scroll up.

== Changelog ==

= 1.0 =
* Launched.

== Upgrade Notice ==

= 1.0 =
* No change.
