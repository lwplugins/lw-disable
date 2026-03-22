# LW Disable - Site Manager Abilities

LW Disable registers two abilities with [LW Site Manager](https://github.com/lwplugins/lw-site-manager)
when that plugin is active. These abilities allow AI agents and REST API clients to read and update
the plugin's feature flags programmatically.

## Category

`disable` - WordPress feature disabling abilities.

---

## Abilities

### `lw-disable/get-options`

Get all current LW Disable feature settings.

- **Permission:** `can_manage_options` (administrator)
- **Readonly:** yes
- **Destructive:** no
- **Idempotent:** yes

#### Input

No required fields (empty object is fine).

#### Output

```json
{
  "success": true,
  "options": {
    "comments": false,
    "admin_new_user_email": false,
    "emojis": true,
    "embeds": false,
    "heartbeat": true,
    "block_library": false,
    "xmlrpc": true,
    "rest_api": false,
    "application_passwords": false,
    "generator": true,
    "shortlink": false,
    "rsd_link": false,
    "wlw_manifest": false,
    "version_strings": false,
    "adjacent_posts": false,
    "feeds": false
  }
}
```

#### curl example

```bash
curl -s -X POST https://example.com/wp-json/lw-site-manager/v1/abilities/lw-disable/get-options \
  -H "Content-Type: application/json" \
  -H "X-WP-Nonce: <nonce>" \
  -d '{}'
```

---

### `lw-disable/set-options`

Enable or disable WordPress features managed by LW Disable.

- **Permission:** `can_manage_options` (administrator)
- **Readonly:** no
- **Destructive:** no
- **Idempotent:** yes

#### Input

| Field     | Type   | Required | Description                         |
|-----------|--------|----------|-------------------------------------|
| `options` | object | yes      | Map of option keys to boolean values |

#### Option keys

| Key                    | Description                                             |
|------------------------|---------------------------------------------------------|
| `comments`             | Disable comments completely                             |
| `admin_new_user_email` | Disable admin email on new user registration            |
| `emojis`               | Disable WordPress emoji scripts and styles              |
| `embeds`               | Disable oEmbed discovery and scripts                    |
| `heartbeat`            | Disable WordPress heartbeat API                         |
| `block_library`        | Disable Gutenberg block CSS on frontend                 |
| `xmlrpc`               | Disable XML-RPC protocol                                |
| `rest_api`             | Restrict REST API to logged-in users                    |
| `application_passwords`| Disable application passwords                           |
| `generator`            | Remove WordPress version meta tag                       |
| `shortlink`            | Remove shortlink from head                              |
| `rsd_link`             | Remove Really Simple Discovery link                     |
| `wlw_manifest`         | Remove Windows Live Writer link                         |
| `version_strings`      | Remove ?ver= query strings from assets                  |
| `adjacent_posts`       | Remove prev/next post links from head                   |
| `feeds`                | Disable RSS feeds completely                            |

Unknown keys are silently ignored.

#### Output

```json
{
  "success": true,
  "message": "2 option(s) updated.",
  "updated": ["emojis", "heartbeat"]
}
```

#### Error response

```json
{
  "code": "no_valid_keys",
  "message": "No valid option keys provided.",
  "data": { "status": 400 }
}
```

#### curl example - disable emojis and heartbeat

```bash
curl -s -X POST https://example.com/wp-json/lw-site-manager/v1/abilities/lw-disable/set-options \
  -H "Content-Type: application/json" \
  -H "X-WP-Nonce: <nonce>" \
  -d '{"options": {"emojis": true, "heartbeat": true}}'
```

#### curl example - re-enable comments

```bash
curl -s -X POST https://example.com/wp-json/lw-site-manager/v1/abilities/lw-disable/set-options \
  -H "Content-Type: application/json" \
  -H "X-WP-Nonce: <nonce>" \
  -d '{"options": {"comments": false}}'
```

---

## Notes

- Changes take effect immediately after saving; a page reload may be needed to observe the frontend effects.
- The abilities register themselves via the `lw_site_manager_register_categories` and
  `lw_site_manager_register_abilities` action hooks, so they are completely inert when LW Site Manager
  is not installed.
