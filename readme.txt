=== Require Featured Image ===
Contributors: pressupinc, davidbhayes
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Tags: featured image, images, edit, post, admin, require featured image, image, media, thumbnail, thumbnails, post thumbnail, photo, pictures
Requires at least: 3.5
Tested up to: 3.8.0
Stable tag: 0.5.0
License: MIT
License URI: http://opensource.org/licenses/MIT

Requires post types you specify to have a featured image set before they can be published.

== Description ==

= Simplify Your Editing Life =

Requires your various post types — as specified in a simple options page — to have a featured image set before they can be published. If a lack of featured images causes your layout to break, or just look less-than-optimal, this is the plugin for you. 

Rather than forcing you to manually enforce your editorial standards of including a featured image in every post, if your contributors fail to add a featured image to a post before publishing it they'll simply find it impossible to publish. 

= Setting up the Plugin =

By default it works on the "Post" content type only, but you can specify other content types, or turn it off for Posts in the new options page in your left sidebar: Settings > Req Featured Image. Simply check and uncheck the appropriate types, hit save and you're all set. Happy publishing!

= Anything else? =

Don't forget to check out [the plugins page on our website](http://pressupinc.com/wordpress-plugins/require-featured-image/), and don't hesitate to [browse and fork on GitHub](https://github.com/pressupinc/require-featured-image). Have a unique WordPress project you need help on? [Get in touch with Press Up](http://pressupinc.com/contact/) to set yourself up for success.

== Installation ==

Activate the plugin. No other steps are necessary to require featured images on Posts only. 

If you want to require featured images on a different content type, or allow Posts to be published without them simply go to the settings page in your left sidebar: Settings > Req Featured Image. Check and uncheck the appropriate types, hit "Save", and you're all set. Happy publishing!

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

Yep, just for different "custom post types." In your left sidebar under Settings, you should see "Req Featured Image". There are options. Or an option, more accurately. Happy publishing!

== Screenshots ==

1. The warning that you see when editing a post that doesn't have a featured image set. The "Publish" button is also disabled.

2. The settings page, which lets you specify which post types the plugin should operate on.

== CHANGELOG ==

= 0.5.0 (2013.12.31) =
* Big changes: now supports all your custom post types out of the box. This can be accessed through the options page (recommended and preferred) or through a filter called 'rfi_post_types'.
* Created an options page to make it easier to update your custom post types and set them within the admin.
* Some small improvements to internal code structure to increase readability and comprehensabilty. This plugin may finally be big enough to benefit from some object-based design, but not for 0.5.0.

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
