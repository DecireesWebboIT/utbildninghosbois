=== Simple Automatic Updates ===
Contributors: xpoon
Tags: update, upgrade, security, auto
Requires at least: 4.0
Tested up to: 4.7.3
Stable tag: 0.1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Activate automatic updates or weekly notifications for the site.

== Description ==

This plugin will give you three alternatives for managing your WordPress updates:

* **Update automatically** - This updates WordPress/themes/plugins automatically and sends an email to the site admin when an update has been performed.
* **Update automatically (no email)** - Same as the first alternative, but without the email.
* **Inform about updates once a week** - This will send an email to the admin once a week if there are anything that can be updated.

Notice that only plugins/themes that resides in the WordPress 
repository will be updated/informed about.

The plugin has not been tested and is not primarily made for multi site-installations. 

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/simple-automatic-updates` directory, or install the plugin through the WordPress plugins screen directly.
2. Configure the plugin under Settings->General.

== Changelog ==

= 0.1.3 =
* Fixing compability issue with php 7.1

= 0.1.2 =
* Bugfix: Fixing so emails aren't being sent after manual updates.

= 0.1.1 =
* Updating readme.txt

= 0.1 =
* Initial release
