=== TEDTalks Embedder ===
Contributors: samuelaguilera
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2UT9S9ACVEHHL
Tags: TED, Talks, TEDx
Requires at least: 2.9
Tested up to: 3.2.1
Stable tag: 1.0.1

Helps you to embed TED Talks videos on your self hosted WordPress simply using same shortcode used for WordPress.com

== Description ==

Helps you to embed TED Talks videos on your self hosted WordPress simply using same shortcode used for WordPress.com

First time you see a TED Talk video embedded in your site, the plugin needs to grab the sharing HTML code for that video from TED.com
After that first load, the embedding code is stored in one custom field, so no need to grab the code again from TED.com

By the way, this plugin has been specially made for TEDxZaragoza 'The Future of Happiness', an independently organized TED event that
will take place on November 5, 2011 in Zaragoza (Spain).

== Usage ==

After installation and activation of the plugin.

- Locate the TED Talk that you want to embed in your WordPress site.
- Press the Share button and copy the shortcode for WordPress.com (i.e. [ted id=1048] )
- Paste the shorcode in your post or page and click on Preview button to check that is ok.

You're done.

Also, if the TED Talk has subtitles available, you can use the enable subtitles option to choose your lang and use that code (i.e. [ted id=1048 lang=spa] )

= Features =

* Easy and simple usage
* Uses same shortcode used for WordPress.com
* You can choose to force your desired language for subtitles (if available for that TEDTalk)
* Supports multiple TED Talks in the same post
* Stores embed HTML code in a custom field, so no need to grab the code again from TED.com

= Requirements =

* WordPress 2.9 or higher.
* fopen or CURL must be available in your host
    	
== Installation ==

* Extract the zip file and just drop the contents in the <code>wp-content/plugins/</code> directory of your WordPress installation (or install it directly from your dashboard) and then activate the Plugin from Plugins page.

== Changelog ==

= 1.0 =

* First public release.
* Added support for multiple TED Talks in the same post.

= 0.9 =

* Some code cleanup and improvements.
* Added support for multilanguage codes.

= 0.7 =

* 99% rewriting of the plugin code.
* Now using totally different method. Instead of generating the embed code, I grab it completely from TED.com
* Changed shortcode to use same format as in WordPress.com

= 0.1 =

* Not released to the public.
* Originally based on TedTalks for WordPress by Robert Anselm.
* Updated ted.com embed code and made some little changes.
