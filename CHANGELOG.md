# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [1.3.5] - 2026-03-22

### Added
- LW Site Manager integration - disable abilities for AI agents
- `lw-disable/get-options` ability - get disabled features
- `lw-disable/set-options` ability - toggle features on/off

## [1.3.4]

### Fixed
- Smarter autoloader fallback - supports root Composer dependency installs

## [1.3.3]

### Fixed
- Graceful error when autoloader is missing (admin notice instead of fatal error)

## [1.3.2]

### Added
- Disable admin email notification on new user registration

## [1.3.1]

### Fixed
- Minor fix

## [1.3.0]

### Added
- Hash-based tab navigation on settings page
- New ban icon
- Updated ParentPage with SVG icon support from registry

### Changed
- Moved save handler to `admin_init` for proper redirect

## [1.2.9]

### Fixed
- Minor fix

## [1.2.8]

### Fixed
- Minor fix

## [1.2.7]

### Changed
- Removed commands feature (causes core issues from WordPress 6.9+)

## [1.2.6]

### Fixed
- Admin notice isolation for notices relocated by WordPress core JS

## [1.2.5]

### Changed
- Isolate third-party admin notices on LW plugin pages

## [1.2.4]

### Added
- Fresh POT file and Hungarian (hu_HU) translation

## [1.2.3]

### Added
- Tabbed settings UI with vertical sidebar navigation
- Active tab preserved after save
- Success notice after settings save

## [1.2.2]

### Added
- Central plugin registry from GitHub JSON
- Release workflow for automatic GitHub releases

## [1.2.0]

### Added
- WP-CLI support
- Commands: `list`, `enable`, `disable`, `enable-all`, `disable-all`

## [1.1.0]

### Added
- 14 new disable features
- Performance: emojis, embeds, heartbeat, block library CSS
- Security: XML-RPC, REST API restriction, app passwords, generator meta
- Head Cleanup: shortlink, RSD, WLW manifest, version strings, adjacent posts
- Content: RSS feeds
- Sectioned settings UI

## [1.0.0]

### Added
- Initial release
- Disable comments feature
- Disable commands feature
