# Tailwind CSS Setup - ACE Theme

## ✅ Setup Complete

Your Tailwind CSS is now fully functional and working on the frontend!

## 📦 What Was Fixed

1. **Created missing directory**: `assets/css/`
2. **Fixed Tailwind config paths**: Updated `tailwind/tailwind.config.js` with correct relative paths
3. **Added build process**: Created `package.json` with npm scripts
4. **Compiled CSS**: Generated `assets/css/style.css` (15.3 KB minified)

## 🚀 Usage

### Development Mode (with auto-reload)
```bash
npm run dev
```
This will watch your PHP files and automatically rebuild CSS when you add/change Tailwind classes.

### Production Build
```bash
npm run build
```
This creates a minified CSS file for production.

## 📂 File Structure

```
ace-theme/
├── tailwind/
│   ├── input.css              # Tailwind source
│   └── tailwind.config.js     # Tailwind configuration
├── assets/
│   └── css/
│       └── style.css          # Compiled output (auto-generated)
├── inc/
│   ├── assets.php             # Enqueues style.css
│   └── carbon-fields/
│       └── blocks.php         # Contains Tailwind classes
└── package.json               # Build scripts
```

## 🎨 How It Works

1. You write Tailwind classes in your PHP files (like `blocks.php`)
2. Tailwind scans these files based on `tailwind.config.js` content paths
3. It generates only the CSS classes you actually use
4. The compiled CSS is enqueued via `inc/assets.php`

## 🔧 Tailwind Config Paths

The config currently scans:
- `../*.php` - Root PHP files
- `../**/*.php` - All PHP files in subdirectories
- `../assets/js/**/*.js` - JavaScript files
- `../template-parts/**/*.php` - Template parts
- `../inc/**/*.php` - Include files

## 💡 Tips

- Always run `npm run build` after adding new Tailwind classes
- Use `npm run dev` while actively developing
- The compiled CSS file (`assets/css/style.css`) is auto-generated - don't edit it manually
- Add custom CSS to `tailwind/input.css` if needed

## 🐛 Troubleshooting

**Styles not showing up?**
1. Clear WordPress cache
2. Hard refresh browser (Ctrl+F5)
3. Rebuild: `npm run build`
4. Check browser console for CSS loading errors

**New classes not compiling?**
1. Make sure the file is in a scanned path (see config above)
2. Run `npm run build` again
3. Check `tailwind.config.js` content array

## 📝 Example Usage

```php
<div class="bg-neutral-900 text-white px-4 py-10">
  <h2 class="text-3xl font-bold">Hello Tailwind!</h2>
</div>
```

All classes are now working! 🎉

