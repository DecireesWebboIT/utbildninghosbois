=== Nav Menu Manager ===
Contributors: rnoakes3rd
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XNE7BREHR7BZQ
Tags: anchor, collpase, copy, expand, id, manager, menus, nav, query, shortcode, string, widget
Requires at least: 3.8
Tested up to: 4.7.2
Stable tag: 1.4.2
Copyright: (c) 2016 Robert Noakes (mr@robertnoak.es)
License: GNU General Public License v3.0
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Simplifies nav menu maintenance and functionality providing more control over nav menus with less coding.

== Description ==

Simplifies nav menu maintenance and functionality providing more control over nav menus with less coding. The plugin is coded with efficiency in-mind and loads quickly with all settings enabled according to the [Plugin Performance Profiler](https://wordpress.org/plugins/p3-profiler/).

= Site Menus =

* Collapse/expand functionality for easier nav menu maintenance
* Improved nav menu sidebar widget for better widgetized menus
* Easily register nav menus via the WordPress admin
* Fail-safe code helps add a layer of protection to the theme
* Disable already registered nav menus that won't be used on the site
* **wp_nav_menu** code generator for quick theme implementation

= Menu Settings =

* Add a global active class for all active nav menu items
* Exclude default ID attributes from all nav menu list items
* Include custom fields on nav menu items for ID, query string and/or anchor
* All settings are optional and disabled by default

= Compatibility =

* Compatible with other great plugins like [Nav Menu Roles](https://wordpress.org/plugins/nav-menu-roles/)
* Uses a customized **Walker_Nav_Menu_Edit** class with minimal added functionality

== Installation ==

= Automatic =

1. Log into the WordPress admin
2. Go to **Plugins > Add New**
3. Search for **Nav Menu Manager**
4. Click **Install Now** for the 'Nav Menu Manager' plugin
5. Click **Activate**

= Manual Upload =

1. Download the plugin
2. Log into the WordPress admin
3. Go to **Plugins > Add New**
4. Click **Upload Plugin**
5. Click **Browse** and select the downloaded ZIP file
6. Click **Install Now**
7. Click **Activate Plugin**

= Manual Extraction =

1. Download the plugin
2. Extract the ZIP file
3. Upload the contents of the ZIP file to **wp-content/plugins/**
4. Log into the WordPress admin
5. Go to **Plugins**
6. Click **Activate** under 'Nav Menu Manager'

= What's Next? =

Once the plugin is active, simply visit **Settings > Nav Menu Manager** and enable the settings required for the site.

== Frequently Asked Questions ==

= Could the plugin be made compatible with [currently incompatible plugin or theme]? =

**Nav Menu Manager** was built with compatibility in-mind, but because it uses a customized **Walker_Nav_Menu_Edit** class, incompatibilities are always possible. I got my inspiration for compatibility from the [Nav Menu Roles](https://wordpress.org/plugins/nav-menu-roles/) plugin and the [FAQs](https://wordpress.org/plugins/nav-menu-roles/faq/) contain extensive information on making a plugin or theme compatible with this and other plugins/themes that use the same action hook.

== Screenshots ==

1. Plugin settings page w/fail-safe code output
2. Code generator page
3. Nav menu collapse/expand and custom fields
4. Improved nav menu sidebar widget

== Changelog ==

= 1.4.2 =

Released on 2017-02-22

* Changed: Optimized the generator form
* Changed: Improved plugin update calls

= 1.4.1 =

Released on 2017-02-17

* Fixed: Sanitization callbacks for earlier versions of WordPress
* Fixed: Customizer preview function call for  earlier versions of WordPress
* Fixed: Small issue with Custom Post Types UI styles that were affecting the generator form

= 1.4.0 =

Released on 2017-02-16

* Added: Ability to remove help tabs entirely
* Added: Fail-safe code output for menu stability
* Added: Plugin settings sanitization
* Added: **wp_nav_menu** code generator
* Added: Item Spacing option for the NMM Menu widget
* Added: **nmm_starts_with** and **nmm_ends_with** template functions
* Added: Sourcemaps for compressed assets
* Changed: Widget menus can now be selected by **theme_location**
* Removed: Deprecated functionality

= 1.3.0 =

Released on 2016-12-30

* Added: Gulp for simplified asset maintenance
* Removed: Buttons action hook from the **Walker_Nav_Menu_Edit** class

= 1.2.5 =

Released on 2016-12-13

* Deprecated: Buttons action hook in the **Walker_Nav_Menu_Edit** class for added compatibility

= 1.2.4 =

Released on 2016-11-28

* Added: Made sure the plugin works in WordPress 4.7
* Fixed: Child nav menu items now expand when the collapsed parent item is deleted
* Fixed: Depth option in the **NMM Menu** widget

= 1.2.3 =

Released on 2016-10-29

* Fixed: Working meta box fix for **Revolution Slider**

= 1.2.2 =

Released on 2016-10-12

* Fixed: Meta box fix for **Revolution Slider**

= 1.2.1 =

Released on 2016-09-30

* Fixed: Meta box fix for [qTranslate X](https://wordpress.org/plugins/qtranslate-x/)

= 1.2.0 =

Released on 2016-09-16

* Added: Option to disabled help buttons
* Added: AJAX action template function
* Changed: Display name set to **Nav Menu Manager**
* Changed: Improved the nav menu widget for **WPML**
* Changed: Moved uninstall options to the bottom of the settings page
* Removed: Deprecated functionality

= 1.1.2 =

Released on 2016-08-10

* Added: Empty nav menu option to the nav menu widget
* Fixed: Issue that was preventing the custom fields from being displayed on new menu items

= 1.1.1 =

Released on 2016-08-09

* Changed nav menu widget name to **NMM Menu**
* Changed template function names to start with 'nmm'

= 1.1.0 =

Released on 2016-08-04

* Added: Collapse/expand functionality to nav menus
* Added: Help buttons for easier access to documentation
* Changed: Moved all nav menus functionality to a separate class
* Fixed: Made the plugin backward compatible with WordPress 3.8 and up

= 1.0.4 =

Released on 2016-07-28

* Added: Improved nav menu sidebar widget
* Added: Made sure the plugin works in WordPress 4.6
* Fixed: Issue that was preventing custom fields from appearing in certain circumstances
* Fixed: Made the plugin backward compatible with WordPress 4.0 and up

= 1.0.3 =

Released on 2016-07-22

* Added: Removal of leading and trailing redundancies from custom fields
* Fixed: Made the plugin backward compatible with WordPress 4.4 and up

= 1.0.2 =

Released on 2016-07-19

* Added: Help tab to nav menus for custom fields
* Added: Nav menus nonce for custom fields
* Fixed: Issue that was preventing the custom fields from being displayed on new menu items

= 1.0.1 =

Released on 2016-07-15

* Changed: Custom field action hook for plugin compatibility

= 1.0.0 =

Released on 2016-07-14

* Initial release

== Upgrade Notice ==

= 1.4.0 =

Previously, invalid nav menu location slugs could be saved in the plugin settings. New and existing nav menu locations are now sanitized which could affect menu output on the site until resolved within the theme.

= 1.3.0 =

Removed the **wp_nav_menu_item_custom_buttons** action hook from the **Walker_Nav_Menu_Edit** class and now use the **wp_nav_menu_item_custom_fields** action hook for all code added to nav menu items.
