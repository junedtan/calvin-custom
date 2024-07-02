<?php get_header();?>

<?php the_post();?>

<main>
  
  <div class="grid-container">
    <div class="grid-x">
      <div class="cell">
        <?php the_title();?>
        <?php the_content();?>
      </div>
    </div>
  </div>
                      
</main>

<?php get_footer(); ?>