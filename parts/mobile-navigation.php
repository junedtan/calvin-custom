<?php 
  $global_fields = get_fields('option');
?>
<div class="cell auto mobile-menu-items flex-container align-center align-middle">
  <div class="grid-x">
    <div class="cell text-center">
      <?php 
        wp_nav_menu( array( 
          'theme_location' => 'main-navigation', 
          'container_class' => 'mb-4' 
        ) ); 
      ?>    
    </div>
    <div class="cell text-center">
      <?php print do_shortcode('[social-media]'); ?>
    </div>
  </div>
</div>
<div class="cell shrink text-center text-uppercase cancel-last-margin">
  <hr>
  <p>&copy; <?php print date("Y").' '.$global_fields['copyright_information']; ?> </p>
</div>
