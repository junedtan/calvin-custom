<?php 
  $global_fields = get_fields('option');
?> 

<footer class="pt-1 pb-1 medium-pt-2 bg-color-<?php print $global_fields['theme_footer_bg_color']; ?>">
  <div class="grid-container">
    <div class="grid-x">
      <div class="cell">
        <div class="grid-x grid-margin-x">
          <div class="cell medium-shrink mb-2 medium-mb-0">
            <a href="/">
              <img class="logo" src="<?php print $global_fields['company_logo']['url']; ?>" alt="<?php print $global_fields['copyright_information']; ?>">
            </a>
          </div>
          <div class="cell medium-auto mb-2 medium-mb-0">
            <div class="footer-center">
              <?php foreach ($global_fields['theme_footer_center_column'] as $center_footer): ?>
                <div class="cancel-last-margin mb-1"><?php print $center_footer['content']; ?></div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="cell medium-shrink mb-2 medium-mb-0">
            <?php print $global_fields['theme_footer_right_column']; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="grid-x">
      <div class="cell text-center text-uppercase copyright cancel-last-margin">
        <hr>
        <p>&copy; <?php print date("Y").' '.$global_fields['copyright_information']; ?> </p>
      </div>
    </div>
  </div>
</footer>