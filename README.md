# HTML Files to Node Sync Module

This custom Drupal module syncs HTML files from a specified folder under the public repository and creates new nodes under a custom content type. The module utilizes Drupal QueueWorkers and the Drupal Cron system to efficiently handle the task.

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

## Dependencies

1. Drupal 10 or later
2. Drupal QueueWorkers
