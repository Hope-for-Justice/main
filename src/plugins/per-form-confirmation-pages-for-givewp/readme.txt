=== Per Form Confirmations for GiveWP ===
Contributors: givewp, webdevmattcrom
Donate link: https://givewp.com
Tags: givewp, donation, donations, receipt, fundraising, multilingual, wpml
Requires at least: 5.0
Tested up to: 5.7
Stable tag: 1.1.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.en.html

A [GiveWP](https://givewp.com/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=Free_Addons&utm_content=pfconfs) add-on that let's you designate unique confirmation pages per form. Useful for multilingual sites or customizing your thank you messaging.

== Description ==

"Per Form Confirmations for GiveWP" let's you designate unique confirmation pages per form in the [GiveWP](https://givewp.com/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=Free_Addons&utm_content=pfconfs) plugin. This let's you customize your "thank you" messaging per form. It is also very helpful for sites that use WPML to support multiple languages, since they have to designate a unique confirmation page per language, per form.

This has many potential use-cases. Here's a few ideas:

* Customize the look/feel of a thank you page to match the form your donors come from
* Add unique custo messaging above or below your receipt table on a per form basis.
* Helpful for sites using WPML to support multiple languages since they have to designate a unique confirmation page per language per form. 

[Learn more about this free add-on and all the free GiveWP add-ons we are creating in 2020 here](https://givewp.com/february-free-add-on-per-form-confirmations/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=Free_Addons&utm_content=pfconfs).

**FEATURES**

* No global settings, only per-form settings 
* Easy select dropdown of your existing page that have the `[give_receipt]` shortcode on them. 
* BONUS: Add custom messaging above or below your receipt table

**BASIC USAGE**

Once enabled, all you need to do is:
1. Add a new confirmation page and include the `[give_receipt]` shortcode in it. 
2. Go to edit your form and navigate to the "Confirmation" tab. 
3. Choose your new confirmation page 
4. You can additionally add content before or afer the receipt table. This is useful if you are sending multiple forms to the same page, but still want customized messaging. 

**ABOUT GIVEWP**
> [GiveWP](https://givewp.com/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=Free_Addons&utm_content=pfconfs) is the fundraising plugin of choice for WordPress. It has the most downloads, active installs, and 5-star ratings of any other donation plugin on wordpress.org. Whether you are running a small personal fundraiser or a large nonprofit, GiveWP provides you with flexible forms, donor management, visually compelling and insightful reports, and more. 
> 
> You can [install GiveWP](https://wordpress.org/plugin/give?utm_source=wp-org&utm_medium=pfconfs&utm_campaign=readme) on your WordPress website today for free. Then make sure to check out our pricing plans to see all the ways you can take your fundraising to the next level. 

== Installation ==

= Minimum Requirements =

* WordPress 5.0 or greater
* PHP version 5.6 or greater
* MySQL version 5.5 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To install Give Receipt Attachments, login to your WordPress dashboard, navigate to the Plugins menu and click "Add New".

In the search field type "Per Form Confirmation for GiveWP" and click Search Plugins. Once you have found the plugin you can view details about it such as the the point release, ratings and description. Most importantly of course, you can install it by simply clicking "Install Now".

= Manual installation =

The manual installation method involves downloading the plugin and uploading it to your server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site before doing any plugin or theme updates just in case. If you have any trouble with an update, try out our [WP-Rollback plugin](https://wordpress.org/plugins/wp-rollback) which lets you revert to previous versions of WordPress plugins or themes with just a couple clicks.


== Frequently Asked Questions ==

= Can I choose any post or page on my site? =

Currently the add-on only looks for Pages (not Posts or other post types) that already have the `[give_receipt]` shortcode on them. But if many users need more flexibility, let us know kindly in the Support Forum.

= I can't find the Page I want to point my form to =

The dropdown in the form settings is populated *ONLY* with Pages that already have the `[give_receipt]` shortcode in them. So go add that to your page, and come back to the Form, refresh the page, and try again. 

= I have A LOT of donation confirmation pages, but only the first 30 appear. What do I do? = 

I chose "30" for performance reasons and because most folks don't need more than that. But if you do, then you can add this filter to your site to add as many as you need:

`add_filter('pfc4g_receipt_page_query_number', 'my_query_number');

function my_query_number() {
	$query = 50;

	return $query;
}`

Just update the `$query = 50;` to be whatever number you like. 

Then, keep in mind that the page query results are stored in a "transient". If you need to see immediate results, then I recommend you install the "Transient Manager" addon. The navigate to "Tools > Transients", then in the search field, search for "pfconfs" and delete that transient. Then your results will show all 50 results in the dropdown. 

If you need assitance adding custom PHP snippets to your website, [check out our tutorial here](https://givewp.com/documentation/resources/adding-custom-functions-to-your-wordpress-website/).

= How can I use this with the new GiveWP Form Templates? =

The new form templates feature made this add-on obsolete, except for the Legacy form style. That's why you'll now see a notice on the Confirmation form settings if you have a non-Legacy form template activated. 

The only way to use this correctly with GiveWP 2.7 and higher is to have your form use the Legacy form style. 

= I have a feature request, or would like to contribute to this plugin. Where can I do that? =

Per Form Confirmations is hosted publicly on Github. We welcome your feedback and suggestions [there](https://github.com/impress-org/givewp-per-form-confirmations/issues).

= Where can I submit Support Questions? =

If you have purchased any of our Premium Add-ons, we can provide with your [Priority Support here](https://givewp.com/support?utm_source=wordpress.org&utm_medium=referral&utm_campaign=Free_Addons&utm_content=pfconfs).

If you are a free GiveWP user and have a general question about GiveWP, [submit a ticket here](https://wordpress.org/support/plugin/give/).

Otherwise, if your question is specific to "Per Form Confirmations for GiveWP," we're happy to answer your questions [here](https://wordpress.org/support/plugin/per-form-confirmation-pages-for-givewp/).

== Screenshots ==

1. The GiveWP form edit screen, on the "Confirmations" tab. This is where all the settings are.
2. An example custom confirmation page with the custom message shown "above" the receipt table.

== Changelog ==
= 1.1.1 =
* Hotfix to address a problem introduced with the form settings names preventing form settings from saving correctly. -- [issue #11](https://github.com/impress-org/givewp-per-form-confirmations/issues/11)

= 1.1 =
* Fix: Ensure more than 9 page results appear in the "Page" option -- [issue# 9](https://github.com/impress-org/givewp-per-form-confirmations/issues/9)
* Tweak: Improve compatibility with GiveWP 2.7 by showing an alert that this add-on is only relevant for Legacy form templates -- [issue# 10](https://github.com/impress-org/givewp-per-form-confirmations/issues/10)

= 1.0 =
Initial release, launched with the following:
* Form settings to choose a custom confirmation page 
* Form setting to add a custom message above or below the receipt table 
* Internationalization
* Dropdown query is cached for performance.

== Upgrade Notice ==

= 1.0 =
This is the initial release. Thanks for installing!