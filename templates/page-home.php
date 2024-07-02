<?php
  /*
  Template Name: Home
  */
?>

<?php get_header();?>

<main>

  <div class="grid-container">
    <div class="grid-x">
      <div class="cell">
        <h1><?php the_title();?></h1>
        <?php the_content();?>
      </div>
    </div>
  </div>

</main>

<?php get_footer(); ?>
