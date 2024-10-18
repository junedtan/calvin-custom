<?php
/**
 * Block template file: blocks/text.php
 *
 * Text Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$block_fields = get_fields();
$block_meta = ccm_get_block_metadata($block, 'text');
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
      <div class="cell cancel-last-margin">
        <div>
        <?php
          get_template_part('parts/block-title', null, array(
            'title' => $block_fields['title'],
            'subtitle' => $block_fields['subtitle'],
          ));
        ?>
        <div class="mb-1 cancel-last-margin">
          <?php print apply_filters('the_content', get_field( 'text' )); ?>
        </div>
        <?php if ($block_fields['cta']): ?>
          <p>
            <a class="cta" href="<?php print $block_fields['cta']['url']; ?>" target="<?php print $block_fields['cta']['target']; ?>"><?php print $block_fields['cta']['title'];?></a>
          </p>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
