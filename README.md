# LW Disable

Disable WordPress features: comments, commands, emojis, embeds, and more.

[![Packagist](https://img.shields.io/packagist/v/lwplugins/lw-disable.svg)](https://packagist.org/packages/lwplugins/lw-disable)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)
[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org)
[![License](https://img.shields.io/badge/License-GPL--2.0-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

## Features

### General

- **Disable Commands** - Remove the admin command palette (Cmd/Ctrl+K)
- **Disable Comments** - Remove comments completely from your site

### Performance

- **Disable Emojis** - Remove WordPress emoji scripts and styles
- **Disable Embeds** - Remove oEmbed discovery and scripts
- **Disable Heartbeat** - Remove WordPress heartbeat API
- **Disable Block Library** - Remove Gutenberg CSS on frontend

### Security

- **Disable XML-RPC** - Disable XML-RPC protocol
- **Restrict REST API** - Limit REST API to logged-in users only
- **Disable App Passwords** - Remove application passwords feature
- **Remove Generator** - Hide WordPress version meta tag

### Head Cleanup

- **Remove Shortlink** - Remove shortlink from head
- **Remove RSD Link** - Remove Really Simple Discovery link
- **Remove WLW Manifest** - Remove Windows Live Writer link
- **Remove Version Strings** - Strip ?ver= from asset URLs
- **Remove Adjacent Posts** - Remove prev/next post links

### Content

- **Disable RSS Feeds** - Disable all RSS feeds completely

## Installation

```bash
composer require lwplugins/lw-disable
```

Or download and upload to `/wp-content/plugins/`.

## Usage

1. Go to **LW Plugins → Disable**
2. Check the features you want to disable
3. Save

## Links

- [GitHub](https://github.com/lwplugins/lw-disable)
- [Packagist](https://packagist.org/packages/lwplugins/lw-disable)
- [LW Plugins](https://lwplugins.com)
