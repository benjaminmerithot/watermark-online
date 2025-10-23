# Migration Guide: Custom Author Byline → Contributors

This guide explains how to migrate from the "Custom Author Byline" plugin to the new Contributors system.

## What Gets Migrated

The migration script will:

1. **Find all posts** using the Custom Author Byline plugin (meta key: `author`)
2. **Create Contributor posts** for each unique custom author name
3. **Link posts to Contributors** using the new `_watermark_contributor_ids` meta field
4. **Preserve original data** - keeps the old `author` meta field as backup

## Before You Start

### ⚠️ IMPORTANT: Back Up Your Database!

Before running any migration, create a database backup:

1. Use your hosting provider's backup tool, OR
2. Use a plugin like UpdraftPlus, OR
3. Use phpMyAdmin to export your database

### Requirements

- WordPress admin access
- "Custom Author Byline" plugin currently active
- Contributors feature installed (already done ✅)

## Migration Steps

### Step 1: Access the Migration Script

1. The migration script is located at:
   ```
   /wp-content/themes/watermark-theme/migrate-custom-authors.php
   ```

2. Access it in your browser:
   ```
   https://yoursite.com/wp-content/themes/watermark-theme/migrate-custom-authors.php
   ```

3. You must be logged in as an admin to access the script

### Step 2: Review the Preview

The migration script will show you:

- **Number of posts** with custom author bylines
- **Number of unique authors** that will be created as Contributors
- **A table listing** all custom authors and how many posts they have

### Step 3: Run Dry Run (Optional but Recommended)

1. Click the **"🔍 Dry Run (Preview Only)"** button
2. This shows what would happen WITHOUT making any changes
3. Review the output to ensure everything looks correct

### Step 4: Run the Migration

1. Click the **"▶️ Run Migration"** button
2. Confirm the prompt (make sure you backed up!)
3. Wait for the migration to complete
4. Review the success message showing:
   - Contributors created
   - Posts updated
   - Any errors (if applicable)

### Step 5: Verify the Migration

1. **Check a few posts** to ensure contributors are displaying correctly
2. Visit **Contributors** in WordPress admin to see all migrated contributors
3. **Add photos and bios** to contributor profiles as needed
4. Check the **Staff & Contributors page** if you've created one

### Step 6: Clean Up

Once you've verified the migration was successful:

1. **Deactivate** the "Custom Author Byline" plugin
2. **Delete** the `migrate-custom-authors.php` script for security
3. **Optional**: Delete the "Custom Author Byline" plugin entirely

## What Happens to the Old Data?

- **Meta field `author`** is preserved (not deleted)
- This allows fallback compatibility
- You can safely delete this meta field later if desired
- The Contributors system takes priority over the old meta field

## Troubleshooting

### "No custom author bylines found"

This means there are no posts using the Custom Author Byline plugin. Nothing to migrate!

### Duplicate Contributors

If you run the migration twice, it will:
- Skip creating duplicate contributors (checks by name)
- Not duplicate the contributor assignments

### Some posts still show the old author

Check:
1. Is the Contributor post published? (Draft contributors won't display)
2. Is the contributor properly linked in the "Article Contributors" meta box?
3. Clear any caching plugins

### Migration errors

If you see errors during migration:
- Note the error message
- Check that the Contributors custom post type is registered
- Ensure you have proper permissions
- Contact your developer if issues persist

## After Migration: Using Contributors

### Editing Existing Contributors

1. Go to **Contributors** in WordPress admin
2. Edit any contributor to:
   - Add a photo (Featured Image)
   - Add a bio (Content editor)
   - Add a job title (Staff Page Settings)
   - Mark to show on Staff page (checkbox)

### Assigning Contributors to New Posts

1. Edit any post
2. Look for **Article Contributors** meta box in sidebar
3. Check one or more contributors
4. Update the post

### Creating New Contributors

1. Go to **Contributors** > **Add New**
2. Enter name (title)
3. Add bio (optional)
4. Add photo (optional)
5. Publish

## Technical Details

### Data Structure

**Old System (Custom Author Byline):**
- Meta key: `author` (text string)
- Meta key: `uri` (URL string)

**New System (Contributors):**
- Meta key: `_watermark_contributor_ids` (array of contributor post IDs)
- Contributor data stored as custom post type

### Priority Order

When displaying post authors, the system checks:
1. **Contributors** (`_watermark_contributor_ids`) ← Highest priority
2. **Custom Author Byline** (`author` meta field) ← Fallback for old data
3. **WordPress Author** (actual post author) ← Default fallback

This means your old posts will continue to work even before migration!

## Need Help?

If you encounter issues during migration:
1. Restore your database backup
2. Check the error messages
3. Contact your developer
4. Do NOT delete the migration script until issues are resolved

## Summary Checklist

- [ ] Back up database
- [ ] Access migration script in browser
- [ ] Review preview statistics
- [ ] Run dry run (optional)
- [ ] Run migration
- [ ] Verify posts display correctly
- [ ] Add photos/bios to contributors
- [ ] Deactivate Custom Author Byline plugin
- [ ] Delete migration script
- [ ] Optional: Delete Custom Author Byline plugin
