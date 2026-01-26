=== LW Disable ===
Contributors: lwplugins
Tags: disable, performance, security
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 1.1.0
Requires PHP: 8.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Disable WordPress features: comments, commands, emojis, embeds, and more.

== Description ==

Lightweight plugin to disable WordPress features you don't need.

= General =

* Disable admin command palette (Cmd/Ctrl+K)
* Disable comments completely

= Performance =

* Disable WordPress emoji scripts and styles
* Disable oEmbed discovery and scripts
* Disable WordPress heartbeat API
* Disable Gutenberg block CSS on frontend

= Security =

* Disable XML-RPC protocol
* Restrict REST API to logged-in users
* Disable application passwords
* Remove WordPress version meta tag

= Head Cleanup =

* Remove shortlink from head
* Remove Really Simple Discovery (RSD) link
* Remove Windows Live Writer manifest link
* Remove ?ver= query strings from assets
* Remove prev/next post links from head

= Content =

* Disable RSS feeds completely

Part of [LW Plugins](https://lwplugins.com) - lightweight WordPress plugins.

== Installation ==

1. Upload to `/wp-content/plugins/lw-disable/`
2. Activate the plugin
3. Go to LW Plugins → Disable

Or: `composer require lwplugins/lw-disable`

== Changelog ==

= 1.1.0 =
* Add 14 new disable features
* Performance: emojis, embeds, heartbeat, block library CSS
* Security: XML-RPC, REST API restriction, app passwords, generator meta
* Head Cleanup: shortlink, RSD, WLW manifest, version strings, adjacent posts
* Content: RSS feeds
* Sectioned settings UI

= 1.0.0 =
* Initial release
* Disable comments feature
* Disable commands feature
