<?php 
  $hero_id = isset($args['id']) ? $args['id'] : 'hero';
  $fullscreen = isset($args['fullscreen']) ? $args['fullscreen'] : true;
  if (isset($args['background_image'])) {
    $background_image = $args['background_image'];
    $mobile_image = isset($args['mobile_background_image']) ? $args['mobile_background_image'] : null;
    if (!$mobile_image) {
      $mobile_image = $background_image;
    }
  } else {
    $background_image = get_field('hero_image');
    $mobile_image = get_field('mobile_hero_image');
    if (!$mobile_image) {
      $mobile_image = $background_image;
    }
  }

  $title = get_field('hero_title');
  
?>
<?php if ($background_image): ?>
  <section id="hero" class="bg-color-<?php print get_field('hero_background_color'); ?> hero position-relative logo-color-flip <?php print ($fullscreen) ? 'fullscreen' : ''; ?>" aria-hidden="true">
    <img class="image-cover mobile-hero-image hide-for-medium" src="<?php print $mobile_image; ?>" alt="">
    <img class="image-cover desktop-hero-image show-for-medium" src="<?php print $background_image; ?>" alt="">
    <?php if ($title): ?>
      <div class="hero-title">
        <div class="grid-container">
          <div class="grid-x grid-margin-x fullscreen">
            <div class="cell flex-container align-center align-middle cancel-last-margin">
              <h2 class="h1-style"><?php print $title; ?></h2>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>
