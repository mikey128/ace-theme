# Tailwind CSS Troubleshooting Guide

## 🔍 Step-by-Step Debugging

### Step 1: Test Direct CSS File Access
Open this URL in your browser:
```
http://localhost/ace-light/wp-content/themes/ace-theme/test-css.html
```

**Expected Result:**
- You should see colored boxes (blue, red, green, yellow)
- Text should be styled with proper fonts and sizes

**If this WORKS:** ✅ CSS file is fine, issue is with WordPress enqueuing
**If this FAILS:** ❌ CSS file path or content issue

---

### Step 2: Create a Test Page in WordPress

1. Go to WordPress Admin → Pages → Add New
2. Title: "Tailwind Test"
3. In the "Page Attributes" box on the right, select Template: **"Test Tailwind CSS"**
4. Publish the page
5. View the page

**Expected Result:**
- You should see colored boxes and debug information
- Check the "CSS File Exists" line - should say ✅ YES

**If debug info shows CSS exists but no styling:**
- Issue is with CSS not being loaded in HTML `<head>`

---

### Step 3: Check WordPress Page Source

1. Go to your frontpage
2. Right-click → View Page Source (or Ctrl+U)
3. Search for (Ctrl+F): `style.css`

**You should find a line like:**
```html
<link rel='stylesheet' id='ace-style-css' href='http://localhost/ace-light/wp-content/themes/ace-theme/assets/css/style.css?ver=1736416823' media='all' />
```

**If you DON'T see this line:** ❌ CSS is not being enqueued
**If you SEE this line:** ✅ CSS is enqueued, check the URL

---

### Step 4: Enable Debug Mode

Add `?debug` to your homepage URL (you must be logged in as admin):
```
http://localhost/ace-light/?debug
```

**Check the debug panel at the bottom of the page** - it will show all enqueued styles.

---

## 🛠️ Common Issues & Fixes

### Issue 1: CSS File Not Found (404)
**Symptoms:** Page source shows the `<link>` tag but CSS returns 404

**Fix:**
```bash
cd D:\xampp\htdocs\ace-light\wp-content\themes\ace-theme
npm run build
```

Verify file exists:
```bash
dir assets\css\style.css
```

---

### Issue 2: Browser Caching
**Symptoms:** Old styles showing, changes not appearing

**Fix:**
1. Hard refresh: `Ctrl + Shift + R` (or `Ctrl + F5`)
2. Clear browser cache completely
3. Try in incognito/private window

---

### Issue 3: WordPress Cache Plugin
**Symptoms:** Styles work sometimes, not other times

**Fix:**
1. Deactivate ALL caching plugins temporarily
2. Go to WordPress Admin → Plugins
3. Deactivate W3 Total Cache, WP Super Cache, etc.
4. Test again

---

### Issue 4: PHP Errors Preventing Enqueue
**Symptoms:** White screen or partial page load

**Fix:**
1. Check PHP error log: `D:\xampp\php\logs\php_error_log`
2. Enable WordPress debug in `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```
3. Check `wp-content/debug.log`

---

### Issue 5: Template Not Using wp_head()
**Symptoms:** Styles work on some pages but not others

**Fix:** Check your template file (index.php, front-page.php, etc.)

**Must have:**
```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?> <!-- THIS IS CRITICAL -->
</head>
<body <?php body_class(); ?>>
  
  <!-- YOUR CONTENT -->
  
  <?php wp_footer(); ?> <!-- THIS TOO -->
</body>
</html>
```

---

## 📝 Quick Checklist

- [ ] CSS file exists: `wp-content/themes/ace-theme/assets/css/style.css`
- [ ] CSS file is not empty (should be ~24KB)
- [ ] Direct HTML test works (test-css.html)
- [ ] WordPress enqueues the CSS (check page source)
- [ ] No 404 error for CSS file (check browser Network tab)
- [ ] Hard refreshed browser (Ctrl+Shift+R)
- [ ] No caching plugins active
- [ ] Template has `<?php wp_head(); ?>` in `<head>`
- [ ] No PHP errors in error log

---

## 🔧 Manual Fix: Force Enqueue in Template

If all else fails, add this **temporarily** to your template header:

```php
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css?v=<?php echo time(); ?>">
```

Put this BEFORE `<?php wp_head(); ?>`

---

## 📞 Report Back

After testing, report which step failed:
1. "Direct CSS test (test-css.html)" - working or not?
2. "WordPress Test Page template" - working or not?
3. "Page source contains style.css link" - yes or no?
4. "Browser Network tab shows CSS loaded" - yes or no (200 or 404)?

This will help pinpoint the exact issue!

