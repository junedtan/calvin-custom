<?php 
  $hero_id = isset($args['id']) ? $args['id'] : 'hero';
  $fullscreen = isset($args['fullscreen']) ? $args['fullscreen'] : false;
  if (isset($args['type'])) {
    $background_image = $args['background_image'];
    $mobile_image = isset($args['mobile_background_image']) ? $args['mobile_background_image'] : null;
    if (!$mobile_image) {
      $mobile_image = $background_image;
    }
    $title = $args['title'];
    $background_color = $args['background_color'];
    $content = array(); // dikembangkan kemudian
  } else {
    $hero = get_field('hero');
    if ($hero) {
      $hero_type = $hero['type'];
      $background_image = $hero['image'];
      $mobile_image = $hero['mobile_image'];
      if (!$mobile_image) {
        $mobile_image = $background_image;
      }
      $slider_images = $hero['slider_images'];
      $slider_animation = $hero['animation_type'];
      $slider_speed = $hero['slider_speed'];
      $content = array(
        'title' => $hero['title'],
        'subtitle' => $hero['subtitle'],
        'cta' => $hero['cta'],
      );
      $background_color = $hero['background_color'];  
    } else {
      $hero_type = 'none';
    }
  }

  $display_hero = ($hero_type != 'none');
  if ($hero_type == 'image') {
    $display_hero = $display_hero && !empty($background_image);
  } elseif ($hero_type == 'slider') {
    $display_hero = $display_hero && !empty($slider_images);
  }

  
?>
<?php if ($display_hero): ?>
  <section id="hero" class="bg-color-<?php print $background_color; ?> hero position-relative logo-color-flip <?php print ($fullscreen) ? 'fullscreen' : ''; ?>" aria-hidden="true">
    <?php if ($hero_type == 'image'): ?>
      <img class="image-cover mobile-hero-image hide-for-medium" src="<?php print $mobile_image; ?>" alt="">
      <img class="image-cover desktop-hero-image show-for-medium" src="<?php print $background_image; ?>" alt="">
    <?php elseif ($hero_type == 'slider'): ?>
      <div class="hero-carousel" data-slider-speed="<?php print $slider_speed; ?>" data-slider-animation="<?php print $slider_animation; ?>">
        <?php
          if (count($slider_images) < 3) {
            // bug flickity: kalo cuman dua dia ngedip pas fade
            $slider_images = array_merge($slider_images, $slider_images);
          }
        ?>
        <?php foreach ($slider_images as $image): ?>
          <div class="carousel-cell">
            <img src="<?php print $image['url']; ?>" class="image-cover" />
          </div>
        <?php endforeach; ?>
      </div>
    <?php elseif ($hero_type == 'slides'): ?>
      <div>Ini ntar buat hero slider</div>
    <?php endif; ?>
    <div class="overlay hero-overlay"></div>
    <?php 
      get_template_part('parts/hero-content', null, array(
        'content' => $content,
      ));
    ?>
  </section>
<?php else: ?>
  <section class="pt-1">
    <div class="grid-container">
      <div class="grid-x grid-margin-x">
        <div class="cell cancel-last-margin"><h2 class="h1-style"><?php the_title(); ?></h2></div>
      </div>
    </div>
  </section>
<?php endif; ?>
