=== Plugin Name ===
Contributors: allonsacksgmailcom
Donate link: http://www.digitalcontact.co.il
Tags: yoast, breadcrumbs, seo
Requires at least: 3.0.1
Tested up to: 4.5
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add/prepend a breacrumb to the current page for Yoast SEO breadcrumbs

== Description ==

Sometimes you have a different permalink set up than the breadcrumbs you want.
For instance: http://yourdomain.com/seo-services
The "seo-services" page is under the "services" section but you did not set it up as a child of the services page.
Still, you want the breadcrumbs to indicate the proper parent.
Example:
Home > Services > SEO Services
instead of:
Home > SEO Services

This plugin lets you do that.
It has no settings but adds a side meta box to all your posts and pages (All post types) where you can choose the title and url to prepend to the breadcrumbs trail.
Options are:
-Append a breadcrumb after the first breadcrumb (Usually “Home”)
-Prepend a breadcrumb to the last item in the breadcrumbs (the current page).
A title and URL need to be entered for each pair in order for the breadcrumbs to be affected. You can create 2 new breadcrumbs or just one.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
2. Make sure that you have installed and activated Yoast SEO and enabled breadcrumbs in the "SEO > advanced" section of the Yoast SEO settings.
3. Go to any post or page and you will see the new options box on the side titled "Add a breadcrumb". Add the title and link (link can begin with "/" instead of your domain path), and you will see that the breadcrumbs for that page have changed.


== Frequently Asked Questions ==

= What happens if Yoast is not installed or activated or if Yoast breacrumbs are not enabled? =

The meta boxes will still appear on the post edit screen but will have no effect on your site until you enable Yoast SEO and enable Yoast SEO's breadcrumbs.

== Screenshots ==

1. The meta box in the page edit screen. There is no settings screen. Activating the plugin adds the meta boxes to all pages, posts, and post types.

== Changelog ==

= 1.1 =
Added option for second breadcrumb. The original field is the breadcrumb that is prepended to the last breadcrumb.

= 1.0 =
First Version


== Future Versions ==

1. Change the page url field to use a drop down of current sites pages/posts instead of manually typing in the URL
2. Add option to use the title of selected page or enter in the title manually to override (Manual is how it currently works)
3. Please feel free to email me with bugs and/or suggestions.
