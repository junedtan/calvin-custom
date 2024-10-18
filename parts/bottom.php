<?php 
  $global_fields = get_fields('option');
  $footer_padding = apply_filters('ccm_footer_padding_class', '');
?> 

<?php do_action('ccm_before_footer'); ?>

<footer class="<?php print $footer_padding; ?> bg-color-<?php print $global_fields['theme_footer_bg_color']; ?>">
  <div class="grid-container">
    <div class="grid-x">
      <div class="cell">
        <?php get_template_part('parts/footer-top'); ?>
      </div>
    </div>
    <div class="grid-x">
      <div class="cell copyright cancel-last-margin">
        <?php get_template_part('parts/footer-copyright'); ?>
      </div>
    </div>
  </div>
</footer>