<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php get_header(); ?>
    <?php get_template_part('template-parts/home/slideshow'); ?>
    <?php get_template_part('template-parts/home/featured-products'); ?>
    <?php get_template_part('template-parts/global/media-carousel'); ?>

<?php get_footer(); ?>
</body>
</html>

