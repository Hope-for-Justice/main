=== Give - Zapier ===
Contributors: givewp
Tags: donations, donation, zapier
Requires at least: 4.9
Tested up to: 5.7
Requires Give: 2.10.0
Stable tag: 1.4.0
License: GPLv3
License URI: https://opensource.org/licenses/GPL-3.0

Connect your Give install to Zapier and unleash integrations with many of today’s top services and applications.

== Description ==

Connect your Give install to Zapier and unleash integrations with many of today’s top services and applications.

A simple and powerful way to integrate Give with 1,000+ third party web services, including Highrise, Twilio, Campaign Monitor, MailChimp, Xero, Zendesk, Dropbox, Google Docs and more!

== Installation ==

= Minimum Requirements =

* WordPress 4.9 or greater
* PHP version 5.6 or greater
* MySQL version 5.5 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To do an automatic install of Give, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "Give" and click Search Plugins. Once you have found the plugin you can view details about it such as the the point release, rating and description. Most importantly of course, you can install it by simply clicking "Install Now".

= Manual installation =

The manual installation method involves downloading our donation plugin and uploading it to your server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

== Changelog ==

= 1.4.0: March 25th, 2021 =
* New: Updated the logging to use the fancy new logging system in GiveWP 2.10.0
* Fix: Improved logging for failed zaps

= 1.3.2: January 7th, 2021 =
* Fix: Resolved an issue where real data and test donations sent through Zapier would have the incorrect donation status of "publish" or "give_subscription" rather than "Complete".

= 1.3.1: September 16th, 2020 =
* New: Added a setting and support for logging Zapier events and errors. This is not turned on by default, so if you would like to use it please enable it within the add-on's settings. Note: Zapier also logs so if you're troubleshooting you can use both logs to help troubleshoot any issues.

= 1.3.0: January 29th, 2020 =
* New: Updated how Zaps are processed so that they are more reliable on websites processing many donations. We moved away from using WP Cron to using a background processing utility that is more reliable.

= 1.2.3: July 25th, 2019 =
* Fix: There was an issue with connecting to Zapier if you did not have the Recurring Donations add-on activated. This is because Zapier was expecting a response from the newly created "Subscription Completed" trigger added in the previous version. This fix now allows all users with or without Recurring Donations active to connect to Zapier.

= 1.2.2: April 17th, 2019 =
* New: Added a trigger for "Subscription Completed".
* Fix: Resolved issue with the "Pending Donation" trigger not firing properly.
* Fix: Resolved an issue with Zapier pulling in sample data correctly. Note: you must update to the latest version of Give Core 2.4.5+ for this to work.

= 1.2.1: May 23rd, 2018 =
* Fix: The "Create a New API Key" link was incorrect in the plugin settings. It has now been fixed.
* Fix: The add-on was not pushing the correct date to Zapier and was defaulting to the Unix epoch date.

= 1.2: May 2nd, 2018 =
* Fix: Resolved conflcit between "live" and "test" zaps which could cause data to not be sent correctly through the Zap once configured.
* Fix: Prevent the word "false" from being passed within blank data lines (like the Address Line 2 field).
* Tweak: Refactored settings class to use new Settings API within Give core.
* Tweak: Removed old hooks for 2.1+ compatibility.

= 1.1.2 =
* New: Fixed issue with sending over custom fields via live Zapier mode.

= 1.1.1 =
* New: The plugin now checks to see if Give is active and up to the minimum version required to run the plugin

= 1.1 =
* New: Trigger for when a donor is updated
* Fix: Billing address not being passed to Zapier
* Fix: Donor's first and last name not being passed to Zapier
* Fix: Form field manager fields not being passed to Zapier
* Tweak: Updated settings layout with additional content and style

= 1.0.1 =
* New: Added a link from the plugin's listing page to the settings tab
* Tweak: Settings tab compatibility for the Give release version 1.5

= 1.0 =
* Initial plugin release. Yippee!
