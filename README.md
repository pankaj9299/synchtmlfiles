# HTML Folder to Node Sync Module

A custom Drupal module to synchronize HTML files from a designated folder into Drupal nodes. Uses Drupal Queue Workers and Cron for efficient processing.

## Features

- **Automated HTML Sync**: Monitor a specified folder for HTML files and convert them into Drupal nodes.
- **Queue Workers**: Process files asynchronously to avoid performance bottlenecks.
- **Cron Integration**: Leverages Drupal's cron system for scheduled synchronization.
- **Custom Content Type Support**: Maps HTML content to a user-defined content type.
- **Logging**: Tracks file processing and node creation status.

## Installation

1. **Place the module** in your Drupal installation's `modules/custom/` directory.
2. **Enable the module**:
   ```bash
   drush en synchtmlfiles
