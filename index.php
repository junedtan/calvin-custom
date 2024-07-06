<?php get_header();?>

<?php the_post();?>

<main>
  
  <?php 
    get_template_part('parts/hero');
    the_content();
  ?>

</main>

<?php get_footer(); ?>