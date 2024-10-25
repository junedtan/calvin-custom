<?php 
  $global_fields = get_fields('option');
  $show_main_nav_on = apply_filters('ccm_show_main_nav_on', 'medium');
  $hamburger_icon = apply_filters('ccm_hamburger_icon', '<span class="ph ph-list"></span>');
?> 

<header class="headroom--top bg-color-<?php print $global_fields['theme_header_background_color']; ?>">
  <div class="grid-container">
    <div class="grid-x align-justify align-middle cancel-last-margin">
      <div class="cell shrink logo-container">
        <?php get_template_part('parts/company-logo'); ?>
      </div>
      <div class="cell auto show-for-<?php print $show_main_nav_on; ?>" role="navigation" aria-label="Main Navigation">
        <?php 
          get_template_part('parts/top-navigation');
        ?>
      </div>
      <div class="cell shrink hide-for-<?php print $show_main_nav_on; ?>">
        <a href="#" class="menu-toggle" title="Open Navigation Menu">
          <?php print $hamburger_icon; ?>
        </a>
      </div>
      <?php $social_media = do_shortcode('[social-media]'); ?>
      <?php if ($social_media): ?>
        <div class="cell-shrink show-for-<?php print $show_main_nav_on; ?>" aria-hidden="1">
          <?php print $social_media; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</header>

<div class="hide-for-<?php print $show_main_nav_on; ?> mobile-navigation bg-color-<?php print $global_fields['theme_mobile_nav_background_color']; ?>" aria-hidden="true">
  <div class="grid-container height100">
    <div class="grid-y height100">
      <div class="cell shrink">
        <div class="grid-x align-justify align-middle cancel-last-margin close-button-container">
          <div class="cell shrink">
            <?php get_template_part('parts/company-logo'); ?>
          </div>
          <div class="cell shrink hide-for-<?php print $show_main_nav_on; ?>">
            <a href="#" class="menu-toggle" title="Close Navigation Menu">
            <span class="ph ph-x"></span>
            </a>
          </div>
        </div>
      </div>
      <?php 
        get_template_part('parts/mobile-navigation');
      ?>
    </div>
  </div>
</div>
