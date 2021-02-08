# Send Password Reset plugin for Craft CMS 3.x

Add send password reset email action to users element index page action menu

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require elementworks/send-password-reset

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Send Password Reset.

## Send Password Reset

This plugin adds a `Send Password Reset` option to the user element index action menu to enable sending password reset emails to multiple users.

Admin users can always see the `Send Password Reset` action menu item. To allow other users to use it too, make sure you enable the custom Send Password Reset Action permission for them. This can be done at a user group or individual user level in exactly the same way as native Craft permissions.

## Send Password Reset Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [Steve Rowling](https://springworks.co.uk)
