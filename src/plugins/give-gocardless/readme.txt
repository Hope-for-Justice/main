=== Give - GoCardless Gateway ===
Contributors: givewp
Tags: donations, donation, ecommerce, e-commerce, fundraising, fundraiser, gocardless, gateway
Requires at least: 4.8
Tested up to: 5.7
Stable tag: 1.3.7
Requires Give: 2.6.0
License: GPLv3
License URI: https://opensource.org/licenses/GPL-3.0

GoCardless Gateway add-on for Give.

== Description ==

This plugin requires the Give plugin activated to function properly. When activated, it adds a payment gateway for gocardless.com.

== Installation ==

= Minimum Requirements =

* WordPress 4.9 or greater
* PHP version 5.6 or greater
* MySQL version 5.5 or greater
* Some payment gateways require fsockopen support (for IPN access)

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To do an automatic install of Give, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "Give" and click Search Plugins. Once you have found the plugin you can view details about it such as the the point release, rating and description. Most importantly of course, you can install it by simply clicking "Install Now".

= Manual installation =

The manual installation method involves downloading our donation plugin and uploading it to your server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

== Changelog ==
= 1.3.7: May 19th, 2021 =
* Fix: Notice no longer shows up when using GiveWP 2.10+ and Give Recurring 1.12+

= 1.3.6: July 1st, 2020 =
* Fix: Removed HTML that was visible within the GoCardless payment screen when using a multi-level recurring donation form.

= 1.3.5: December 5th, 2019 =
* Fix: A new check is in place to trim a donation form's title if it's too long for GoCardless' API. Now you'll see "Name of donation form ..." in GoCardless if it exceeds 100 characters.

= 1.3.4: July 29th, 2019 =
* Fix: The donation description that appears in GoCardless has been updated to make it more clear when a one time donation versus recurring donation is given.

= 1.3.3: July 11th, 2019 =
* New: Added support for quarterly recurring donations. Note: You must be using Give Core 2.5.0+ and Recurring Donations 1.9.0+ in order to use the quarterly functionality.

= 1.3.2: March 27th, 2019 =
* Fix: Resolved a PHP fatal error on the donation details screen preventing proper viewing of data. This was the result of the code reorganization in the previous version.

= 1.3.1: March 25th, 2019 =
* Fix: Corrected an issue with webhooks being processed correctly for one time payments due to a function looking into an incorrect table for the reference data key. This has been corrected so now payments mark properly as processing and completed.
* Tweak: Deprecated the gateway specific "Payment Method Label" option because that feature is now available in Give Core.
* Tweak: Improved organization of code between the admin settings and gateway functionality.

= 1.3.0: February 6th, 2019 =
* New: Added useful setting to display available debit Schemes for the connected GoCardless account.
* Fix: Ensure completed GoCardless donations are not incorrectly marked as pending.
* Fix: Added additional currency symbols for all supported GoCardless currencies.

= 1.2.1: August 31st, 2018 =
* Fix: Resolved conflict with webhooks when Give - Mollie and Give - GoCardless are activated at the same time.
* Fix: Ensure users don't have a duplicate pending donations when a donor gives.

= 1.2.0: May 2nd, 2018 =
* New: Added support for new recurring options found in Recurring Donations 1.6+ - please update recurring if you're using it alongside GoCardless!
* Fix: Incorrect link to GoCardless webhook secret page.
* Fix: Validate "day" billing period for GoCardless - this gateway does not support daily recurring donations so we've built in validation to prevent admins from setting daily recurring donations.

= 1.1.2: February 9th, 2018 =
* Fix: PHP warning causing AJAX issues with certain servers and versions of GiveWP.

= 1.1.1: January 3rd, 2018 =
* Fix: Recurring subscriptions would not display the proper subscription text within the GoCardless page. This has been resolved so now all forms of recurring now display properly at the GoCardless checkout page.

= 1.1: January 3rd, 2018 =
* Tweak: Refactored plugin structure to be more inline with other gateways.
* Tweak: Constants are now obeyed within the plugin.
* Fix: There were several PHP notices when creating a subscription donation.
* Fix: Plugin did not deactivate properly when Give is not active.

= 1.0 =
* Initial plugin release. Yippee!
