<?php
/**
 * Block template file: blocks/text-columns.php
 *
 * Text Columns Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$block_fields = get_fields();
$block_meta = ccm_get_block_metadata($block, 'text-columns');
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
    <div class="grid-x">
      <div class="cell columns-container narrow-container narrow">
        <div class="grid-x align-middle">
          <div class="cell medium-6">
            <?php print $block_fields['left_column']; ?>
          </div>
          <div class="cell medium-6">
            <?php print $block_fields['right_column']; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>