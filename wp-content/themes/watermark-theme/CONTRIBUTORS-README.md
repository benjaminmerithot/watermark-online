# Contributors Feature Documentation

## Overview
The Contributors feature allows you to attribute articles to people who are not WordPress users. Contributors function similarly to Authors with their own archive pages, but they don't require user accounts.

## How It Works

### Creating Contributors
1. In WordPress admin, navigate to **Contributors** in the sidebar
2. Click **Add New** to create a new contributor
3. Fill in the following fields:
   - **Title**: Contributor's full name
   - **Content**: Bio/description of the contributor
   - **Featured Image**: Contributor's photo (optional)
4. Click **Publish**

### Assigning Contributors to Posts
1. When editing a post, look for the **Article Contributors** meta box in the sidebar
2. Check one or more contributors from the checkbox list
3. You can select multiple contributors for a single article
4. If you select contributor(s), they will override the post author
5. Leave all unchecked to use the default WordPress author
6. Contributors will be displayed with links to their individual archive pages, separated by commas (e.g., "By John Smith, Jane Doe")

### Viewing Contributors
- **Single Contributor Page**: `https://yoursite.com/contributor/contributor-name/`
  - Shows the contributor's photo, bio, and all their articles
- **Archive**: Contributors have their own archive pages that display all articles they've written

## Built-in Fields

Contributors already include these fields by default:
- **Name** (post title)
- **Bio** (post content/editor)
- **Photo** (featured image)

## Adding Custom Fields (Optional)

If you need additional fields like social media links, email, website, etc., you can add them using Advanced Custom Fields (ACF):

1. In WordPress admin, go to **Custom Fields** > **Add New**
2. Create a new field group with fields like:
   - Email
   - Twitter URL
   - LinkedIn URL
   - Website
   - Phone Number
3. Set the location rules to show when:
   - **Post Type** is equal to **Contributor**
4. Save the field group

To display these custom fields in the contributor templates, edit:
- `single-contributor.php`
- `archive-contributor.php`

Example code to display ACF fields:
```php
<?php if ( get_field('email') ) : ?>
    <p>Email: <a href="mailto:<?php the_field('email'); ?>"><?php the_field('email'); ?></a></p>
<?php endif; ?>
```

## Template Files

The Contributors feature includes these template files:
- `single-contributor.php` - Individual contributor page
- `archive-contributor.php` - Contributor archive (shows when viewing a contributor)
- Helper functions in `functions.php`:
  - `watermark_get_post_contributors()` - Get all contributors for a post (returns array)
  - `watermark_get_post_contributor()` - Get first contributor for a post (backwards compatibility)
  - `watermark_get_author_name()` - Get contributor(s) or author name (comma-separated if multiple)
  - `watermark_get_author_link()` - Get first contributor or author link

## Permalink Structure

Contributors use the permalink structure:
- `/contributor/contributor-name/`

After activating the feature, go to **Settings** > **Permalinks** and click **Save Changes** to flush the rewrite rules.

## Priority Order for Post Attribution

When displaying post author information, the system checks in this order:
1. **Contributor** (if one is assigned to the post)
2. **Custom Author** (legacy custom author meta field)
3. **WordPress Author** (the actual post author/user)

## Technical Details

- Custom post type slug: `contributor`
- Meta key for post-contributors relationship: `_watermark_contributor_ids` (stores array of contributor IDs)
- Supports: title, editor, thumbnail
- Public: Yes
- Has archive: Yes
- Show in REST API: Yes (for Gutenberg support)
- Multiple contributors: Yes (supports 1 or more contributors per article)
