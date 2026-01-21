<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header" class="sticky top-0 border-b border-gray-200 bg-white transition-transform duration-300 ease-out">
  <style>
    #site-header { position: sticky; top: 0; z-index: 10030; }
    /* Desktop Sub-menu Styles */
    @media (min-width: 768px) {
      .menu-item-has-children {
        position: relative;
      }
      
      /* Regular Dropdown Menu */
      .menu-item-has-children > .sub-menu {
        position: absolute;
        left: 0;
        top: 93%;
        z-index: 50;
        min-width: 14rem;
        background-color: white;
        box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1);
        border-radius: 0.375rem;   
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1),
                    transform 0.25s cubic-bezier(0.4, 0, 0.2, 1),
                    visibility 0.25s;
        padding-top: 0.75rem;
        margin-top: 0.25rem;
        pointer-events: none;
      }

      /* Megamenu Style - for Products */
      .menu-item-has-children.megamenu {
        position: static;
      }
      
      .menu-item-has-children.megamenu > .sub-menu {
        left: 0;
        right: 0;
        width: 100%;
        transform: translateY(-8px);
        padding: 0;
        padding-top: 0.75rem;
        border-radius: 0;
        border-left: none;
        border-right: none;
      }
      
      .menu-item-has-children.megamenu:hover > .sub-menu {
        transform: translateY(0);
      }

      /* Megamenu Grid Container */
      .menu-item-has-children.megamenu > .sub-menu {
        display: flex;
        flex-direction: column;
      }
      
      .menu-item-has-children.megamenu > .sub-menu > li {
        display: none;
      }
      
      .menu-item-has-children.megamenu .megamenu-wrapper {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        padding: 2rem 1rem;
        width: 100%;
        max-width: 80rem;
        margin: 0 auto;
      }
      
      @media (min-width: 640px) {
        .menu-item-has-children.megamenu .megamenu-wrapper {
          padding: 2rem 1.5rem;
        }
      }
      
      /* Adjust columns if fewer items */
      .menu-item-has-children.megamenu .megamenu-wrapper:has(> :nth-child(3):last-child) {
        grid-template-columns: repeat(3, 1fr);
      }
      
      .menu-item-has-children.megamenu .megamenu-wrapper:has(> :nth-child(2):last-child) {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .menu-item-has-children.megamenu .megamenu-wrapper:has(> :nth-child(1):last-child) {
        grid-template-columns: repeat(1, 1fr);
        max-width: 300px;
        margin: 0 auto;
      }

      /* Product Card Styling */
      .menu-item-has-children.megamenu .sub-menu .product-card {
        display: flex;
        flex-direction: column;
        background: white;
        border-radius: 0.5rem;
        overflow: hidden;
        transition: all 0.25s ease;       
        text-decoration: none;
      }

      .menu-item-has-children.megamenu .sub-menu .product-card:hover {
        transform: translateY(-4px);    
     
      }
     

      .menu-item-has-children.megamenu .sub-menu .product-card-image {
        width: 100%;
        height: 240px;
        object-fit: cover;      
        display: flex;
        align-items: center;
        justify-content: center;           
      }

      .menu-item-has-children.megamenu .sub-menu .product-card-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.25s ease;
      }

      .menu-item-has-children.megamenu .sub-menu .product-card-content {
        padding: 1rem;
        flex: 1;
      }

      .menu-item-has-children.megamenu .sub-menu .product-card-title {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.5rem;
        line-height: 1.3;
      }

      .menu-item-has-children.megamenu .sub-menu .product-card-desc {
        font-size: 0.8125rem;
        color: #6b7280;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }

      /* Megamenu Footer */
      .menu-item-has-children.megamenu > .sub-menu > .megamenu-footer {
        padding: 1.5rem 1rem;      
        text-align: center;
        width: 100%;
        max-width: 80rem;
        margin: 0 auto;
      }
      
      @media (min-width: 640px) {
        .menu-item-has-children.megamenu > .sub-menu > .megamenu-footer {
          padding: 1.5rem 1.5rem;
        }
      }

      .menu-item-has-children.megamenu .megamenu-footer .contact-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 2rem;
        background: #2563eb;
        color: white;
        font-size: 0.9375rem;
        font-weight: 600;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: all 0.2s ease;
      }

      .menu-item-has-children.megamenu .megamenu-footer .contact-btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
      }

      .menu-item-has-children:hover > .sub-menu,
      .menu-item-has-children > .sub-menu:hover {
        opacity: 1;
        visibility: visible;
        transition-delay: 0s;
        pointer-events: auto;
      }

      .menu-item-has-children:not(.megamenu):hover > .sub-menu {
        transform: translateY(0);
      }

      /* Add delay when leaving */
      .menu-item-has-children > .sub-menu {
        transition-delay: 0s, 0s, 150ms;
      }
      .menu-item-has-children:hover > .sub-menu {
        transition-delay: 100ms;
      }

      .menu-item-has-children > .sub-menu::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 0.75rem;
        background: transparent;
        pointer-events: auto;
      }

      /* Regular submenu items */
      .sub-menu li {
        list-style: none;
      }
      
      .menu-item-has-children:not(.megamenu) .sub-menu li a {
        display: block;
        padding: 0.625rem 1rem;
        transition: background-color 0.15s ease;
        color: #374151;
        text-decoration: none;
        font-size: 0.9375rem;
        font-weight: 500;
      }
      
      .menu-item-has-children:not(.megamenu) .sub-menu li:first-child a {
        padding-top: 0.75rem;
        border-radius: 0.375rem 0.375rem 0 0;
      }
      
      .menu-item-has-children:not(.megamenu) .sub-menu li:last-child a {
        padding-bottom: 0.75rem;
        border-radius: 0 0 0.375rem 0.375rem;
      }
      
      .menu-item-has-children:not(.megamenu) .sub-menu li a:hover {
        background-color: rgb(249 250 251);
        color: #111827;
      }
    }

    /* Mobile Menu Button */
    .mobile-menu-toggle {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 40px;
      height: 40px;
      cursor: pointer;
      background: none;
      border: none;
      padding: 8px;
      z-index: 10020;
      position: relative;
      border-radius: 4px;
      transition: background-color 0.2s;
    }
    .mobile-menu-toggle:hover {
     /* background-color: rgba(0, 0, 0, 0.05);*/
    }
    .mobile-menu-toggle span {
      display: block;
      width: 22px;
      height: 2.5px;
      background-color: #1f2937;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: absolute;
      border-radius: 2px;
    }
    .mobile-menu-toggle span:nth-child(1) {
      top: 12px;
    }
    .mobile-menu-toggle span:nth-child(2) {
      top: 19px;
    }
    .mobile-menu-toggle span:nth-child(3) {
      top: 26px;
    }
    /* Close Icon (X) when active */
    .mobile-menu-toggle.active span:nth-child(1) {
      top: 19px;
      transform: rotate(45deg);
    }
    .mobile-menu-toggle.active span:nth-child(2) {
      opacity: 0;
      transform: translateX(-10px);
    }
    .mobile-menu-toggle.active span:nth-child(3) {
      top: 19px;
      transform: rotate(-45deg);
    }

    /* Mobile Menu Overlay */
    .mobile-menu-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.2);
      z-index: 10000;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }
    .mobile-menu-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    /* Mobile Menu Panel */
    .mobile-menu-panel {
      position: fixed;
   
      top:0;   
      left: 0;
      bottom: 0;
      width: 300px;
      max-width: 85%;
      background-color: white;
      z-index: 10010;
      overflow-y: auto;
      transform: translateX(-100%) translateY(45px);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
    }
    .mobile-menu-panel.active {
      transform: translateX(0) translateY(45px);
    }

    /* Mobile Menu Items */
    .mobile-menu-panel ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .mobile-menu-panel > nav > ul > li {
      border-bottom: 1px solid #e5e7eb;
    }
    .mobile-menu-panel > nav > ul > li > a {
      display: block;
      padding: 1rem 1.25rem;
      font-size: 1rem;
      font-weight: 600;
      color: #1f2937;
      text-decoration: none;
      transition: background-color 0.2s;
      text-transform: uppercase;
      letter-spacing: 0.025em;
    }
    .mobile-menu-panel > nav > ul > li > a:hover {
      background-color: #f9fafb;
    }

    /* Mobile Submenu */
    .mobile-menu-panel .sub-menu {
      position: static;
      background-color: #f9fafb;
      border: none;
      border-radius: 0;
      box-shadow: none;
      margin: 0;
      padding: 0;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .mobile-menu-panel .sub-menu.active {
      max-height: 500px;
    }
    .mobile-menu-panel .sub-menu li {
      border-bottom: 1px solid #e5e7eb;
    }
    .mobile-menu-panel .sub-menu li:last-child {
      border-bottom: none;
    }
    .mobile-menu-panel .sub-menu li a {
      display: block;
      padding: 0.875rem 1.25rem 0.875rem 2.5rem;
      font-size: 0.875rem;
      font-weight: 500;
      color: #4b5563;
      text-decoration: none;
      transition: background-color 0.2s;
    }
    .mobile-menu-panel .sub-menu li a:hover {
      background-color: #f3f4f6;
    }
    .mobile-menu-panel .menu-item-has-children > a {
      position: relative;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-right: 3rem;
    }
    .mobile-menu-panel .menu-item-has-children > a::after {
      content: '';
      position: absolute;
      right: 1.25rem;
      width: 8px;
      height: 8px;
      border-right: 2px solid #6b7280;
      border-bottom: 2px solid #6b7280;
      transform: rotate(45deg);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .mobile-menu-panel .menu-item-has-children.active > a::after {
      transform: rotate(-135deg);
    }

    @media (min-width: 768px) {
      .mobile-menu-toggle,
      .mobile-menu-overlay,
      .mobile-menu-panel {
        display: none !important;
      }
    }
  </style>
  <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-2">
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-toggle md:hidden" aria-label="Toggle mobile menu" id="mobile-menu-btn">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
      <div class="flex items-center">
        <?php
          $logo = get_custom_logo();
          if ($logo) {
            $logo = preg_replace('/<img([^>]*)class="([^"]*)"/','<img$1class="$2 h-8 sm:h-9 md:h-10 w-auto"',$logo);
            $logo = preg_replace('/<a([^>]*)class="([^"]*)"/','<a$1class="$2 inline-flex items-center"',$logo);
            echo $logo;
          } else {
            the_custom_logo();
          }
        ?>
      </div>
    <?php else : ?>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center" aria-label="<?php bloginfo('name'); ?>">
        <span class="text-2xl font-bold  text-red-600"><?php bloginfo('name'); ?></span>
      </a>
    <?php endif; ?>

    <nav class="hidden md:flex items-center text-base md:text-lg font-semibold" aria-label="Main navigation">
      <?php
        class Ace_Dropdown_Walker extends Walker_Nav_Menu {
          private $current_parent_title = '';
          private $product_count = 0;
          
          function start_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            
            // Check if this is a megamenu (Products)
            if ($depth === 0 && strtolower($this->current_parent_title) === 'products') {
              $this->product_count = 0;
              $output .= "\n$indent<ul class=\"sub-menu\">\n";
              $output .= "$indent\t<div class=\"megamenu-wrapper\">\n";
            } else {
              $output .= "\n$indent<ul class=\"sub-menu\">\n";
            }
          }
          
          function end_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            
            // Close megamenu wrapper and add footer
            if ($depth === 0 && strtolower($this->current_parent_title) === 'products') {
              $output .= "$indent\t</div>\n";
              $output .= "$indent\t<div class=\"megamenu-footer\">\n";
              $output .= "$indent\t\t<a href=\"" . esc_url(home_url('/contact/')) . "\" class=\"contact-btn\">Contact Us</a>\n";
              $output .= "$indent\t</div>\n";
            }
            
            $output .= "$indent</ul>\n";
          }
          
          function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $has_children = in_array('menu-item-has-children', $classes, true);
            
            // Store parent title for megamenu detection
            if ($depth === 0 && $has_children) {
              $this->current_parent_title = $item->title;
              // Add megamenu class if it's Products
              if (strtolower($item->title) === 'products') {
                $classes[] = 'megamenu';
              }
            }
            
            if ($has_children && $depth === 0) { 
              $classes[] = 'relative'; 
            }
            
            $class_names = implode(' ', array_filter($classes));
            
            // Top level menu items
            if ($depth === 0) {
              $output .= '<li class="' . esc_attr($class_names) . '">';
              $link_classes = 'inline-block px-1 py-2 hover:text-gray-900';
              $output .= '<a class="' . $link_classes . '" href="' . esc_url($item->url ?? '') . '">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
            }
            // Submenu items for megamenu (Products)
            else if ($depth === 1 && strtolower($this->current_parent_title) === 'products') {
              // Limit to 4 products
              if ($this->product_count >= 4) {
                return;
              }
              $this->product_count++;

              $thumb_id = get_post_thumbnail_id($item->object_id);
              $thumb_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'medium') : '';
              
              // Fetch description logic from featured-products.php
              $desc_text = '';
              $desc = (string) carbon_get_post_meta($item->object_id, 'product_short_description');
              if ($desc === '') {
                $excerpt = has_excerpt($item->object_id) ? get_the_excerpt($item->object_id) : '';
                if (!empty($excerpt)) {
                  $desc = $excerpt;
                } else {
                  $desc = wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $item->object_id)), 24, '…');
                }
              }
              $desc_text = $desc;
              
              // Don't wrap in li, output directly as card
              $output .= '<a href="' . esc_url($item->url ?? '') . '" class="product-card">';
              $output .= '<div class="product-card-image">';
              if ($thumb_url) {
                $output .= '<img src="' . esc_url($thumb_url) . '" alt="' . esc_attr($item->title) . '" loading="lazy">';
              } else {
                $output .= '<svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>';
              }
              $output .= '</div>';
              $output .= '<div class="product-card-content">';
              $output .= '<div class="product-card-title">' . esc_html($item->title) . '</div>';
              if ($desc_text) {
                $output .= '<div class="product-card-desc">' . wp_kses_post($desc_text) . '</div>';
              }
              $output .= '</div>';
              $output .= '</a>';
            }
            // Regular submenu items
            else {
              $output .= '<li class="' . esc_attr($class_names) . '">';
              $output .= '<a href="' . esc_url($item->url ?? '') . '">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
            }
          }
          
          function end_el(&$output, $item, $depth = 0, $args = null) {
            // Don't close li for megamenu product cards (they're not wrapped in li)
            if ($depth === 1 && strtolower($this->current_parent_title) === 'products') {
              // Product cards are already closed, no </li> needed
            } else {
              $output .= "</li>";
            }
          }
        }

        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'fallback_cb'    => '__return_empty_string',
          'menu_class'     => 'flex items-center space-x-8 md:space-x-10 text-base md:text-lg',
          'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
          'walker'         => new Ace_Dropdown_Walker(),
        ]);
      ?>
    </nav>

    <div class="flex items-center gap-4">
      <?php if (!is_user_logged_in()) : ?>
        <a href="<?php echo esc_url( function_exists('ace_user_get_page_url') ? ace_user_get_page_url('login') : home_url('/login/') ); ?>" class="hidden sm:inline text-sm text-gray-600">Sign in</a>
        <a href="<?php echo esc_url( function_exists('ace_user_get_page_url') ? ace_user_get_page_url('register') : home_url('/register/') ); ?>" class="inline-flex items-center justify-center rounded-full bg-black px-5 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-gray-800">
          Sign up
          <span class="ml-2">&rarr;</span>
        </a>
      <?php else : ?>
        <?php $u = wp_get_current_user(); ?>
        <div class="relative z-50">
          <button type="button" class="js-user-menu inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-semibold text-gray-900 hover:bg-gray-50 whitespace-nowrap">
            <?php echo get_avatar($u->ID, 20, '', '', ['class' => 'rounded-full']); ?>
            <span class="whitespace-nowrap"><?php echo esc_html($u->display_name ?: $u->user_login); ?></span>
            <svg class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
          </button>
          <div class="js-user-dropdown absolute right-0 mt-2 w-56 rounded-md border border-gray-200 bg-white shadow-md hidden z-50">
            <a href="<?php echo esc_url( function_exists('ace_user_get_page_url') ? ace_user_get_page_url('account') : home_url('/account/') ); ?>" class="block px-3 py-2 text-sm text-gray-900 hover:bg-gray-50">Account</a>
            <a href="<?php echo esc_url( admin_url('admin-post.php?action=ace_logout&_wpnonce=' . wp_create_nonce('ace_logout')) ); ?>" class="block px-3 py-2 text-sm text-gray-900 hover:bg-gray-50">Logout</a>
          </div>
        </div> 
      <?php endif; ?>
    </div>
  </div>

  <!-- Mobile Menu Overlay -->
  <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

  <!-- Mobile Menu Panel -->
  <div class="mobile-menu-panel" id="mobile-menu-panel">
    <nav class="pt-2" aria-label="Mobile navigation">
      <?php
        class Ace_Mobile_Walker extends Walker_Nav_Menu {
          function start_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
          }
          function end_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
          }
          function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $has_children = in_array('menu-item-has-children', $classes, true);
            $class_names = implode(' ', array_filter($classes));
            $output .= '<li class="' . esc_attr($class_names) . '">';
            if ($has_children && $depth === 0) {
              $output .= '<a href="' . esc_url($item->url ?? '#') . '" class="submenu-toggle">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
            } else {
              $output .= '<a href="' . esc_url($item->url ?? '') . '">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
            }
          }
          function end_el(&$output, $item, $depth = 0, $args = null) { 
            $output .= "</li>"; 
          }
        }

        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'fallback_cb'    => '__return_empty_string',
          'menu_class'     => '',
          'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
          'walker'         => new Ace_Mobile_Walker(),
        ]);
      ?>
    </nav> 
  </div>

  <script>
    (function() {
      var btn = document.getElementById('mobile-menu-btn');
      var overlay = document.getElementById('mobile-menu-overlay');
      var panel = document.getElementById('mobile-menu-panel');
      var header = document.getElementById('site-header');
      
      if (!btn || !overlay || !panel || !header) return;

      // Set header height as CSS variable
      function setHeaderHeight() {
        var headerHeight = header.offsetHeight;
        document.documentElement.style.setProperty('--header-height', headerHeight + 'px');
        panel.style.top = headerHeight + 'px';
        overlay.style.top = 0;
      }
      
      setHeaderHeight();

      function openMenu() {
        btn.classList.add('active');
        overlay.classList.add('active');
        panel.classList.add('active');
        document.body.style.overflow = 'hidden';
      }

      function closeMenu() {
        btn.classList.remove('active');
        overlay.classList.remove('active');
        panel.classList.remove('active');
        document.body.style.overflow = '';
      }

      btn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (panel.classList.contains('active')) {
          closeMenu();
        } else {
          openMenu();
        }
      });

      overlay.addEventListener('click', closeMenu);

      // Handle submenu toggles
      var menuItems = panel.querySelectorAll('.menu-item-has-children');
      menuItems.forEach(function(item) {
        var link = item.querySelector('a.submenu-toggle');
        var submenu = item.querySelector('.sub-menu');
        if (link && submenu) {
          link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close all other submenus
            menuItems.forEach(function(otherItem) {
              if (otherItem !== item) {
                otherItem.classList.remove('active');
                var otherSubmenu = otherItem.querySelector('.sub-menu');
                if (otherSubmenu) {
                  otherSubmenu.classList.remove('active');
                }
              }
            });
            
            // Toggle current submenu
            var isActive = item.classList.contains('active');
            if (isActive) {
              item.classList.remove('active');
              submenu.classList.remove('active');
            } else {
              item.classList.add('active');
              submenu.classList.add('active');
            }
          });
        }
      });

      // Close menu on window resize to desktop
      var resizeTimer;
      window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
          setHeaderHeight();
          if (window.innerWidth >= 768) {
            closeMenu();
          }
        }, 250);
      });
    })();
  </script>
</header>

