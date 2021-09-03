=== Social Image Generator ===
Requires at least: 5.4
Tested up to: 5.7
Requires PHP: 5.6

Automatically create social images for your WordPress site, increasing your social engagement and saving you tons of time.

== Description ==

Automatically create social images for your WordPress site, increasing your social engagement and saving you tons of time.

== Changelog ==

### 1.2.1 - 2021-05-25

**Changed**

- The default image is now used when the image type is set to "Featured Image" but no featured image has been added to the post. This makes more sense from a logical perspective, and it's still possible to explictly not use an image by picking the "No Image" image type when editing a post.

### 1.2.0 - 2021-05-20

Two releases in one day—whoops!

**Added**

- Added basic Jetpack support. If Social Image Generator is active for a post, it will overwrite the social image set by Jetpack.

**Fixed**

- Social images are no longer generated for some post types that shouldn't have them.

### 1.1.3 - 2021-05-20

**Fixed**

- Non-breaking spaces should now be rendered correctly in social images.

### 1.1.2 - 2021-05-18

**Fixed**

- Reworked some code to bring the minimum PHP version back to 5.6.

### 1.1.1 - 2021-05-03

**Added**

- Added a link to the License Manager from the Settings page.

**Fixed**

- Fixed an error where activating the plugin on a multisite caused a fatal error in some instances.
- On some operating systems, activating the plugin caused the admin area to render all text in bold. This has been resolved.

### 1.1.0 - 2021-03-22

**Added**

- Updates can now be downloaded and installed automatically when a valid license key has been entered.
- New template: Dois, a super clean two-panel template inspired by recipe websites.
- New template: Brand, a template that only adds your logo to the image—great for adding some simple branding to your content.

**Changed**

- Social images are now generated as JPEG instead of PNG, greatly reducing the file size of each image with no noticeable loss in quality.
- The settings page for Social Image Generator has moved from the 'Tools' section to the more appropriate 'Settings' section.
- Only JPEG and PNG images are allowed to be used as the logo or in the featured image, since other types are not supported.

**Fixed**

- Fixed an error where viewing the social image would give a `Headers already sent` PHP warning.

### 1.0.0 - 2021-02-05

- Initial release.
