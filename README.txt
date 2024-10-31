=== @Reply \w comment preview ===
Contributors: Marcu5, iyus
Donate link: http://blog.acidchaos.de/donate
Tags: reply, at-reply, comments, twitter, preview
Requires at least: 2.3
Tested up to: 2.6.*
Stable tag: 0.0.41

This plugin allows you to add Twitter-like @reply links to comments, including a preview of the comment replied to.

MASHUP of this: http://www.spreeblick.com/2007/09/25/worst-code-ever/ and that: http://wordpress.org/extend/plugins/reply-to/

== Description ==

This plugin allows you to add Twitter-like @reply links to comments, including a preview of the comment replied to.
When clicked, those links insert the author name and a link to the comment you are replying to in the textarea, and adds a Preview of the original comment to the @Reply (on hover using javascript).

This is a MASHUP of [this](http://www.spreeblick.com/2007/09/25/worst-code-ever/) and [that](http://wordpress.org/extend/plugins/reply-to/)

== From the original README (Credits) ==

by [Yus](http://wordpress.org/extend/plugins/profile/iyus/)

Most of the code is taken from the Custom Smilies plugin by Quang Anh Do which is released under GNU GPL :
http://onetruebrace.com/custom-smilies

Thanks to [Guillaume Ringuenet](http://blog.guillaumeringuenet.info/) who made the arrow graphics.

I didn't create anything new, and I do not claim so in any way.
This plugin is just a feature I wanted and thought it could interest some other people.

== Changelog ==

**0.0.41** - jQuery loading tweaks

**0.0.4** - (hopefully) fixed code to autoload jQuery and included jQuery in the package so it will hopefully work with older WP versions

**0.0.3** - WP wont allow commenters to use the `class` attribute, so this will now be created by a filter.

**0.0.2** - set ID for comment-textarea used by theme in the settings panel.

**0.0.1** - initial release

== Installation ==

1. Upload the plugin **folder** to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php if( function_exists( 'atrwcp_reply' ) ) atrwcp_reply(); ?>` in your comments.php where you want the link to appear. For example, before the `<?php edit_comment_link(...` part.
4. (optional) Go to `Settings -> @Reply with preview` to see some andvanced settings and advanced uasge of `atrwcp_reply()`.
5. (optional) In the `extra` folder you will find a `reply.png` file for dark background themes, use it to replace the default file if you need.

6. (optional) Themes like the WP default theme Kubrick don't have their comments wrapped up properly. For this plugin to work your theme's code should really look somewhat like this:<br/>`<div class="comment-text">`<br/>`  <?php comment_text() ?>`<br/>`</div>`<br/>if your theme only has a different class used, you can change the settings of the plugin (`Settings -> @Reply with preview`) to work with that. 

== Frequently Asked Questions ==

= It doesn't work ! I activated the plugin but I can't see the reply arrows. =

You skipped the 3rd step of the installation process. Try again. :)

= Where's the settings for this plugin? =

Navigate to `Settings -> @Reply with preview`.

= It doesn't work ! I can see the reply arrows but clicking them does nothing. =

Either you have disabled JavaScript in your browser or your WordPress theme is not using the default id for the comments `<textarea>` (which is `comment`). In the later case, check your `comments.php` file to find your textarea id, then go set that in the Options for this plugin.

= It doesn't work ! I don't see the comment preview. =

Either you have disabled JavaScript in your browser or your WordPress theme is not using the default class for the comments text's encapsulating `<div>` (which is `comment-text`). In the later case, check your `comments.php` file to find the id of the div containing the comments' text, then go set that in the Options for this plugin.

In addition, you might have to add `position:relative;` to the stylesheet definition of the DOM-elements holding the comments in order to make the preview positioning work. You can also use the custon CSS section in the plugin's settings (eg. `div.comment-text { position:relative; }`).

= Possible conflicts with other plugins. =

A plugin that filters the default WordPress comments functions, may prevent @ Reply from working. For example, WP_Identicon does this, but it also has an alternate setup for "advanced users" that doesn't conflict with @ Reply.

= More problems? =

Please provide some [feedback @ the forums](http://wordpress.org/tags/reply-w-comment-preview?forum_id=10#postform)

== Screenshots ==

1. The reply arrows as they appear in comments.
2. This is automaticaly inserted when you click on a reply arrow.
3. Preview of linked comment shown when hovering over the link.
4. Advanced options