<?php
/**
 * Block template file: blocks/media.php
 *
 * Media Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$block_fields = get_fields();
$block_meta = ccm_get_block_metadata($block, 'media');
$id = $block_meta['id'];
$classes = $block_meta['classes'];
$css_vars = $block_meta['css_vars'];

$classes[] = 'type-'.$block_fields['type'];

$mobile_image = isset($block_fields['mobile_image']) ? $block_fields['mobile_image'] : $block_fields['image'];

?>

<style type="text/css">
  <?php echo '#' . $id; ?> {
    /* Add styles that use ACF values here */
  }
</style>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode(' ', $classes) ); ?>" style="<?php echo esc_attr( implode(';', $css_vars) ); ?>">
  <div class="grid-container">
    <div class="grid-x counter-grid-padding">
      <div class="cell">
        <?php if ($block_fields['type'] == 'single-image'): ?>
          <img src="<?php print $block_fields['image']['url']; ?>" class="image-cover show-for-medium" />
          <img src="<?php print $mobile_image['url']; ?>" class="image-cover hide-for-medium" />
        <?php elseif ($block_fields['type'] == 'slider'): ?>
          <div class="image-carousel height100" data-autoplay="<?php print ($block_fields['autoplay'] ? "1" : "0"); ?>">
            <?php foreach ($block_fields['images'] as $image): ?>
              <div class="carousel-cell fullwidth">
                <img src="<?php print $image['url']; ?>" class="image-cover" />
              </div>
            <?php endforeach; ?>
          </div>
        <?php elseif ($block_fields['type'] == 'video'): ?>
          <video src="<?php print $block_fields['video_file']; ?>" controls></video>
        <?php elseif ($block_fields['type'] == 'embed'): ?>
          <?php print $block_fields['embed_code']; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
