<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php get_header(); ?>
  <main>
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
      <article>
        <div class="prose max-w-none">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endwhile; endif; ?>
  </main>
    <?php get_template_part('template-parts/home/slideshow'); ?>
   
    <?php get_template_part('template-parts/home/featured-products'); ?>
     <?php get_template_part('template-parts/home/application-solution-tabs'); ?>
  
    <?php get_template_part('template-parts/home/company-profile'); ?>
      <?php get_template_part('template-parts/home/our-advantages'); ?>
    
    <?php get_template_part('template-parts/global/media-carousel'); ?>
   
   <?php get_template_part('template-parts/home/testimonials'); ?>
    <?php get_template_part('template-parts/home/recent-news'); ?>
   <?php get_template_part('template-parts/home/image-marquee'); ?>
<?php get_footer(); ?>
</body>
</html>

