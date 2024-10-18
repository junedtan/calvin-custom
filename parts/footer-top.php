<?php 
  $global_fields = get_fields('option');
?> 

<div class="grid-x grid-margin-x">
  <div class="cell medium-shrink mb-2 medium-mb-0">
    <?php get_template_part('parts/company-logo'); ?>
  </div>
  <div class="cell medium-auto mb-2 medium-mb-0">
    <div class="footer-center">
      <?php if (is_array($global_fields['theme_footer_center_column'])): ?>
        <?php foreach ($global_fields['theme_footer_center_column'] as $center_footer): ?>
          <div class="cancel-last-margin mb-1"><?php print $center_footer['content']; ?></div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <div class="cell medium-shrink mb-2 medium-mb-0">
    <?php print $global_fields['theme_footer_right_column']; ?>
  </div>
</div>
