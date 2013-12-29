=== Require Featured Image ===
Contributors: pressupinc
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Tags: featured image, images, edit, post, admin
Requires at least: 3.5
Tested up to: 3.6
Stable tag: 0.3.0
License: MIT
License URI: http://opensource.org/licenses/MIT

Like it says on the tin: requires posts to have a featured image set before they'll be published.

== Description ==

Requires posts to have a featured image set before they'll be published. If your layouts break, or look less-than-optimal if your contributors fail to add a featured image to a post before publishing it, this is the plugin for you. Does just what it says on the tin.

== Installation ==

Activate the plugin. No other steps required.

== Frequently Asked Questions ==

= How does it prevent people from publishing a post without featured images? =

There are two methods: one is some strong Javascript on the edit screen that makes it very clear to people working there that they need to add a featured images and makes it impossible for them to press the Publish button unless they've added on.

If that failed for any reason, it also hook into the publish method and does a pretty harsh warning screen that stops the publishing, if attempted through more obscure methods, from working.

= What post (content) types does this plugin work for? =

This is only meant to force people include featured images on Posts, not Pages or any custom post type. If you're interested in that get in touch with us at [Press Up](http://www.pressupinc.com).

= Why would I use this plugin? =

Because you want it to be *required* that your posts have featured images before they be published. If you'd like that your posts have featured images, but it's not a show-stopper for your editorial standards, this is probably too harsh for you to use.

= Are there any options? =

Nope.

== Screenshots ==

1. The warning that you see when editing a post that doesn't have a featured image set. The "Publish" button is also disabled.

== CHANGELOG ==

= 0.3.0 (2013.08.07) =
* Improved conditional fall-back PHP test of publishing because it was stopping saves.

= 0.2.2 (2013.08.02) =
* Fixed some minor documentation errors

= 0.2.1 (2013.08.02) =
* Fixing typo in JS file name.
* Fixed wp_die to only be triggered if post_type is post.
* Updating documentation after seeing it in repository.

= 0.2 (2013.08.01) =
* First release
