=== Require Featured Image ===
Contributors: pressupinc, davidbhayes
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Tags: featured image, images, edit, post, admin, require featured image, image, media, thumbnail, thumbnails, post thumbnail, photo, pictures
Requires at least: 3.5
Tested up to: 4.9.8
Stable tag: 1.4.0
License: MIT
License URI: http://opensource.org/licenses/MIT

Requires content you specify to have a featured image set before they can be published.

== Description ==

= Simplify Your Editing Life =

Requires your various post types — as specified in a simple options page — to have a featured image set before they can be published. If a lack of featured images causes your layout to break, or just look less-than-optimal, this is the plugin for you.

Rather than forcing you to manually enforce your editorial standards of including a featured image in every post, if your contributors fail to add a featured image to a post before publishing it they'll simply find it impossible to publish.

= Setting up the Plugin =

By default it works on the "Post" content type only, but you can specify other content types, or turn it off for Posts in the new options page in your left sidebar: Settings > Req Featured Image. Simply check and uncheck the appropriate types, set a minimum image size if you desire, hit save and you're all set. Happy publishing!

= Anything else? =

Don't forget to check out [the plugins page on our website](http://pressupinc.com/wordpress-plugins/require-featured-image/), and don't hesitate to [browse and fork on GitHub](https://github.com/pressupinc/require-featured-image). Have a unique WordPress project you need help on? [Get in touch with Press Up](http://pressupinc.com/contact/) to set yourself up for success.

== Installation ==

Activate the plugin. No other steps are necessary to require featured images on Posts only.

If you want to require featured images on a different content type, or allow Posts to be published without them simply go to the settings page in your left sidebar: Settings > Req Featured Image. Check and uncheck the appropriate types, set a minimum image size if you desire, hit "Save", and you're all set. Happy publishing!

== Frequently Asked Questions ==

= What post (content) types does this plugin work for? =

Every "custom post type" — or variety of content — is now supported. Before 0.5.0, this plugin could only be used to force people include featured images on Posts, not Pages or any custom post type. Now all of them are a simple few clicks on the options page away.

= How does it prevent people from publishing a post without featured images? =

There are two methods: one is some strong Javascript on the edit screen that makes it very clear to people working there that they need to add a featured images and makes it impossible for them to press the Publish button unless they've added on.

If that failed for any reason, it also hooks into the publish method and stops publishing when no featured image is present. This should prevent publishing even if an author has Javascript off, or if publishing is attempted through more obscure methods.

= I'm not seeing one of my content types on the settings page. Why? =

To simplify the settings page, and avoid confusion, only content types that support Featured Images will appear on the page. It wouldn't make sense for us to try to enforce that a content type that can't have a featured image set can't be published without it. If you want to require that a content type has a featured image but it doesn't currently support it, get in touch with your developer, fiddle with the `register_post_type()` call creating the content type yourself, or get in touch with us at [Press Up](http://pressupinc.com/), we love to help!

= Why would I use this plugin? =

Because you want it to be *required* that your posts have featured images before they be published. If you'd like that your posts have featured images, but it's not a show-stopper for your editorial standards, this plugin may not be for you.

= Are there any options? =

Yep, just for different "custom post types." In your left sidebar under Settings, you should see "Req Featured Image". There are options. You can choose which Post Types you want check as well as setting a minimum size for the featured image. Happy publishing!

= Support for other languages? =

Yes. We're currently (early 2016) hoping that these can start being done on [traslate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/require-featured-image), so if you'd like to contribute one and are familiar with the process, go ahead and do it there.

As the dust is still settling on that process, we will continue supporting other languages via contributions of translations which will be rolled into the next point release of the plugin, as we've done historically.

== Screenshots ==

1. The warning that you see when editing a post that doesn't have a featured image set. The "Publish" button is also disabled.

2. The settings page, which lets you specify which post types the plugin should operate on.

== CHANGELOG ==

= 1.4.0 (2018.11.09) =
* Crude-and-quick Gutenberg compatibility

= 1.3.0 (2017.08.16) =
* Fixing an issue where the PHP didn't stop the post from publishing, if it were invoked
* Fixing an issue where the size warning banner would flash on in Chrome erroneously

= 1.2.3 (2016.11.23) =
* Fixing an issue that would make the plugin seem not to work when newly installed.
* Adding composer.json and Japanese translation.

= 1.2.2 (2016.02.22) =
* Lots of code style changes for better readability and comprehensibility.

= 1.2.1 (2016.02.08) =
* Smattering of small changes to make code more readable and standardized in formatting.
* Addressed and issue where a translation function was being used in the wrong place at the wrong time.

= 1.2.0 (2016.02.01) =
* Adding the ability to declare, check for, and enforce a minimum featured image size. Big props to [@cjk508](https://github.com/cjk508) for making that happen.

= 1.1.4 (2015.12.7) =
* Adding Finnish translation. This commit might/should also unlock language packs on .org, so it could be the last one!
* Added support for WordPress v4.4

= 1.1.3 (2015.10.19) =
* Improving support for WP4.3 by getting right of h1/h2 targetting issue in jQuery. Thanks [Jamie](https://github.com/hubdotcom).
* Added Danish translation. Thanks [Jess](https://github.com/JessNielsen)!

= 1.1.2 (2015.10.01) =
* Added support for WordPress v4.3+

= 1.1.1 (2015.06.22) =
* Fixed an logic error that made it nearly impossible to publish posts. Apologies to all affected.

= 1.1.0 (2015.06.21) =
* Version bump because we finally resolved the issue people started complaining about in 1.0, where you were able to publish with an image and then go remove the image. The change was made in 1.0 to allow for people with old content without featured images to edit posts easily, which was an issue in pre-1.0. The solution, turned out to be to store an option on plugin activation, and then only start enforcing from that time forward. People with the plugin already activated will be auto-set to two weeks before when they upgrade.

= 1.0.10 (2015.05.24) =
* Adding Portuguese (Portugal) translation.
* Adding Dutch translation.
* Bumping WP version tested number.

= 1.0.9 (2015.04.21) =
* Brazilian Portuguese translation from [matheusmb](https://github.com/matheusmb).

= 1.0.8 (2015.04.21) =
* VCS games...

= 1.0.7 (2015.04.21) =
* Adding translation to Serbian by from Andrijana Nikolic of [WebHostingGeeks](http://www.webhostinggeeks.com/). Thanks Andrijana!

= 1.0.6 (2015.03.24) =
* Adding translation to Norwegian by Alf Otto Fagermo.

= 1.0.5 (2015.03.18) =
* Adding translation to German by Wolfgang Tischer.
* Fixing typo in .pot file that was causing a string to not come through translated.

= 1.0.4 (2015.03.10) =
* Cleaned up settings page a fair bit.

= 1.0.3 (2015.01.27) =
* Fixed a mis-named function in the Javascript.

= 1.0.2 (2015.01.24) =
* Made as mistake during VCS games, bumping again was easiest.

= 1.0.1 (2015.01.24) =
* Realized that JS check to allow for edit of featured-image-less unpublished posts would not work in non-English installs. Found a markup-based way to discover the same thing.

= 1.0.0 (2015.01.24) =
* Big JS Refactoring so the final action statements are quite obvious.
* Made it so that when a post is published without a featured image, the plugin doesn't block you from changing it (say to fix a typo).
* Big version bump! This is too widely used to not be at 1.*, and should have been sooner.

= 0.6.5 (2015.01.12) =
* Adding Greek translations.
* Readme changes (4.1 support).

= 0.6.4 (2014.09.18) =
* Adding Arabic translation.
* Readme changes (4.0 support).

= 0.6.3 (2013.04.30) =
* Readme changes (3.9 support rev, some copy changes).

= 0.6.2 (2013.04.05) =
* Adding Spanish translation from Andrew Kurtis of [WebHostingHub](http://www.webhostinghub.com/). Thanks Andrew!

= 0.6.1 (2013.03.02) =
* Updating readme so the live version will change, and removing a .mo file I didn't mean to commit.

= 0.6.0 (2013.03.02) =
* Big changes: Added support for languages localization. I think. I'm new at this.
* Changed it under the hood to use a proper hook rather than a terrible hack system I'd devised before.

= 0.5.0 (2013.12.31) =
* Big changes: now supports all your custom post types out of the box. This can be accessed through the options page (recommended and preferred) or through a filter called 'rfi_post_types'.
* Created an options page to make it easier to update your custom post types and set them within the admin.
* Some small improvements to internal code structure to increase readability and comprehensibility. This plugin may finally be big enough to benefit from some object-based design, but not for 0.5.0.

= 0.3.0 (2013.08.07) =
* Improved conditional fall-back PHP test of publishing because it was stopping saves.

= 0.2.2 (2013.08.02) =
* Fixed some minor documentation errors

= 0.2.1 (2013.08.02) =
* Fixing typo in JS file name.
* Fixed wp_die() to only be triggered if post_type is post.
* Updating documentation after seeing it in repository.

= 0.2 (2013.08.01) =
* First release
