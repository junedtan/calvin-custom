<?php
/**
 * Block template file: blocks/image-carousel.php
 *
 * Image Carousel Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$block_fields = get_fields();
$block_meta = ccm_get_block_metadata($block, 'image-carousel');
$id = $block_meta['id'];
$classes = $block_meta['classes'];
$css_vars = $block_meta['css_vars'];

?>

<style type="text/css">
  <?php echo '#' . $id; ?> {
    /* Add styles that use ACF values here */
  }
</style>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode(' ', $classes) ); ?>" style="<?php echo esc_attr( implode(';', $css_vars) ); ?>">
  <div class="grid-container">    
    <div class="grid-x grid-margin-x">
      <div class="cell">
        <?php
          get_template_part('parts/block-title', null, array(
            'title' => $block_fields['title'],
            'subtitle' => $block_fields['subtitle'],
          ));
        ?>
      </div>
    </div>
    <div class="grid-x counter-grid-padding-right">
      <div class="cell">
        <div class="image-carousel">
          <?php foreach ($block_fields['images'] as $image): ?>
            <div class="carousel-cell">
              <?php if ($image['url']): ?>
                <a href="<?php print $image['url']['url'];?>" target="<?php print $image['url']['target']; ?>">
                  <img src="<?php print $image['image']['url']; ?>" alt="<?php print $image['url']['title'];?>" class="image-cover">
                </a>
              <?php else: ?>
                <img src="<?php print $image['image']['url']; ?>" alt="<?php print $image['image']['alt'];?>" class="image-cover">
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
