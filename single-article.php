<?php
get_header();
?>
  <?php get_template_part('template-parts/article/hero'); ?>
<main class="py-10">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
  
    <div class="max-w-7xl mx-auto px-6 max-w-global">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <div class="lg:col-span-8">
          <?php get_template_part('template-parts/article/main'); ?>
        </div>
        <aside class="lg:col-span-4">
          <?php get_template_part('template-parts/article/related'); ?>
        </aside>
      </div>
    </div>
  <?php endwhile; endif; ?>
</main>

<?php
get_footer();
