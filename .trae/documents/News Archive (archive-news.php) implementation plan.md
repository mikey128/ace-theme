## File Structure
- Add [archive-news.php] at theme root.
- Add new template parts under `template-parts/blog/`:
  - `hero.php`
  - `filter.php`
  - `featured.php`
  - `grid.php`
- Add Carbon Fields registration file `inc/carbon-fields/news-fields.php` and include it from `functions.php`.
- (Optional, cleaner JS) Add `assets/js/swiper/news-featured.js` and enqueue only on the News archive.

## Carbon Fields
- Theme Options container: **News Archive** (under Settings → News Archive)
  - `news_archive_description` (text)
  - Section toggles to match existing theme conventions and workspace rules:
    - `news_archive_hero_enable_full_width`, `news_archive_hero_hide_section`
    - `news_archive_filter_enable_full_width`, `news_archive_filter_hide_section`
    - `news_archive_featured_enable_full_width`, `news_archive_featured_hide_section`
    - `news_archive_grid_enable_full_width`, `news_archive_grid_hide_section`
- Post Meta container for CPT `news`
  - `is_featured` (checkbox)

## Template Composition
- `archive-news.php`
  - Builds the request context (active term slug from `$_GET['news_category']`, current page from `paged`).
  - Runs:
    - Featured query (featured posts only).
    - Grid query (non-featured posts, excluding featured IDs).
  - Renders sections via `get_template_part('template-parts/blog/<name>', null, $args)` with only required data passed.
  - Reuses existing CTA module at the bottom via `get_template_part('template-parts/global/contact-form')` (already dynamic via theme options).

## Filtering Behavior (News Category)
- Use a query-string filter on the News archive so **archive-news.php is always used**:
  - Default: `/news/` shows all.
  - Filtered: `/news/?news_category=term-slug`.
- `filter.php` pulls all `news_category` terms and outputs button-style links:
  - “All” resets to `/news/`.
  - Active term is highlighted by comparing against the current `news_category` query arg.
- Both featured and grid queries apply the taxonomy filter when a valid term is selected.

## Featured Carousel (Swiper)
- `featured.php` renders a Swiper slider of the most recent featured posts (e.g. up to 5): image left / content right.
- If no featured posts exist (for current filter), the section returns early and outputs nothing.
- Swiper is already globally enqueued in [inc/assets.php](file:///d:/xampp/htdocs/ace-light/wp-content/themes/ace-theme/inc/assets.php) so the only work is initialization.
  - Preferred: initialize via a dedicated JS file enqueued only on the News archive.
  - Acceptable fallback (matching current theme patterns): small inline init script inside `featured.php`.

## News Grid + Pagination
- `grid.php` renders the grid:
  - 1 col mobile, 2 cols tablet, 3 cols desktop.
  - Card: image, date, title, excerpt (Tailwind `line-clamp-4`), “Learn more”.
- Uses native WordPress pagination via `paginate_links()`.
  - Preserves the `news_category` query arg across pages (`add_args`).

## Markup + Tailwind
- Wrapper logic follows existing theme convention:
  - Full width: `w-full px-6`
  - Contained: `max-w-7xl mx-auto px-6 max-w-global`
- No inline styles; Tailwind utility classes only.
- Semantic HTML (`header`, `section`, `article`, `nav`, etc.).
- Proper escaping (`esc_html`, `esc_url`, `esc_attr`) and sanitized query args.

## Activation
- Ensure the CPT archive is enabled (already).
- Add/edit Theme Options → News Archive description.
- Mark `news` posts as Featured using the `is_featured` checkbox.
- Visit `/news/` and test:
  - Filtering buttons
  - Featured section hides when none
  - Pagination retains filters

If you confirm, I’ll implement the files exactly in the requested structure and wire Carbon Fields + queries + pagination end-to-end.