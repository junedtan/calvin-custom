<?php 
  $global_fields = get_fields('option');
?> 

<header class="headroom--top bg-color-<?php print $global_fields['theme_header_background_color']; ?>">
  <div class="grid-container">
    <div class="grid-x align-justify align-middle cancel-last-margin">
      <div class="cell shrink medium-pr-2 large-pr-4">
        <?php get_template_part('parts/company-logo'); ?>
      </div>
      <div class="cell auto show-for-medium" role="navigation" aria-label="Main Navigation">
        <?php 
          wp_nav_menu( array( 
            'theme_location' => 'main-navigation', 
            'container_class' => 'main-navigation' 
          ) ); 
        ?>
      </div>
      <div class="cell shrink hide-for-medium">
        <a href="#" class="menu-toggle" title="Open Navigation Menu">
        <span class="fa-regular fa-bars"></span>
        </a>
      </div>
      <div class="cell-shrink show-for-medium pl-2" aria-hidden="1">
        <?php print do_shortcode('[social-media]'); ?>
      </div>
    </div>
  </div>
</header>

<div class="hide-for-medium mobile-navigation bg-color-<?php print $global_fields['theme_header_background_color']; ?>" aria-hidden="true">
  <div class="grid-container height100">
    <div class="grid-y height100">
      <div class="cell shrink">
        <div class="grid-x align-justify align-middle cancel-last-margin close-button-container">
          <div class="cell shrink">
            <?php get_template_part('parts/company-logo'); ?>
          </div>
          <div class="cell shrink hide-for-medium">
            <a href="#" class="menu-toggle" title="Close Navigation Menu">
            <span class="fa-regular fa-times"></span>
            </a>
          </div>
        </div>
      </div>
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
    </div>
  </div>
</div>
