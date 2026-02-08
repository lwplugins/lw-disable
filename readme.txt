=== LW Disable ===
Contributors: lwplugins
Tags: disable, performance, security
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 1.2.7
Requires PHP: 8.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Disable WordPress features: comments, emojis, embeds, and more.

== Description ==

Lightweight plugin to disable WordPress features you don't need.

= General =

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

== WP-CLI ==

Manage features via command line.

= List all features =

`wp lw-disable list`

Shows a table with all features and their current status (enabled/disabled).

= Enable a feature =

`wp lw-disable enable <feature>`

Examples:
`wp lw-disable enable emojis`
`wp lw-disable enable comments`
`wp lw-disable enable xmlrpc`

= Disable a feature =

`wp lw-disable disable <feature>`

Examples:
`wp lw-disable disable emojis`
`wp lw-disable disable heartbeat`

= Enable all features =

`wp lw-disable enable-all`

Enables all disable features at once.

= Disable all features =

`wp lw-disable disable-all`

Disables all features (restores WordPress defaults).

= Available features =

* comments - Comments system
* emojis - Emoji scripts/styles
* embeds - oEmbed system
* heartbeat - Heartbeat API
* block_library - Gutenberg CSS
* xmlrpc - XML-RPC protocol
* rest_api - REST API restriction
* application_passwords - App passwords
* generator - Version meta tag
* shortlink - Shortlink header
* rsd_link - RSD link
* wlw_manifest - WLW manifest
* version_strings - Asset version strings
* adjacent_posts - Adjacent post links
* feeds - RSS feeds

== Changelog ==

= 1.2.7 =
* Remove commands feature (causes core issues from WordPress 6.9+)

= 1.2.6 =
* Fix admin notice isolation for notices relocated by WordPress core JS

= 1.2.5 =
* Isolate third-party admin notices on LW plugin pages

= 1.2.4 =
* Add fresh POT file and Hungarian (hu_HU) translation

= 1.2.3 =
* New: Tabbed settings UI with vertical sidebar navigation
* New: Active tab preserved after save
* New: Success notice after settings save

= 1.2.2 =
* New: Central plugin registry from GitHub JSON
* New: Release workflow for automatic GitHub releases

= 1.2.0 =
* Add WP-CLI support
* Commands: list, enable, disable, enable-all, disable-all

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
