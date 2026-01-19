<?php
/*
Template Name: Product Special
Template Post Type: product
*/

get_header();

while ( have_posts() ) : the_post();
?>
 
  <?php get_template_part('template-parts/product/gallery'); ?>
 

  <div class="product-content">
    <?php the_content(); ?>
  </div>
 
<?php endwhile;

get_footer();