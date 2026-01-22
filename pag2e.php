<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php get_header(); ?>
       
  <main >
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
      <article>
        <h1 class="text-3xl font-semibold mb-4"><?php the_title(); ?></h1>
        <div class="prose max-w-none"><?php the_content(); ?></div>
      </article>
    <?php endwhile; endif; ?>
  </main>
  <div class="max-w-7xl mx-auto px-4 py-12"></div>
<?php get_footer(); ?>
</body>
</html>

