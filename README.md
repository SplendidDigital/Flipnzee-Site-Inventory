# Flipnzee Site Inventory

A lightweight, extensible WordPress plugin that exposes useful website metadata and content inventory through a standardized, read-only REST API.

## Overview

Flipnzee Site Inventory provides a simple way to retrieve information about a WordPress website, including:

- Site information
- Content statistics
- Environment details
- Publishing activity

Unlike analytics plugins, Flipnzee Site Inventory does **not** collect visitor data or integrate with third-party analytics services. Its sole purpose is to inventory the contents and environment of a WordPress installation.

## Features

### Site Information

- Site Name
- Site URL
- Home URL
- Description
- Language
- Timezone

### Content Inventory

- Published Posts
- Draft Posts
- Pages
- Categories
- Tags
- Media Library
- Users
- Comments

### Environment

- WordPress Version
- PHP Version
- Active Theme
- SSL Status
- Multisite Status
- REST API Status

### Activity

- Last Published Post
- Last Modified Post

## REST API

Namespace:

```
flipnzee/v1
```

Primary Endpoint:

```
/wp-json/flipnzee/v1/inventory
```

## Example Response

```json
{
    "site": {},
    "content": {},
    "environment": {},
    "activity": {}
}
```

## Requirements

- WordPress 6.0+
- PHP 7.4+

## Roadmap

### Version 1.0

- REST API
- Site Information
- Content Inventory
- Environment Details
- Activity Information

### Future Versions

- WooCommerce Inventory
- Plugin Inventory
- Theme Inventory
- SEO Information
- Performance Metrics
- Sitemap Information

## Contributing

Contributions, suggestions, and bug reports are welcome.

## License

GPL-2.0-or-later
