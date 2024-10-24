<?php 
  $block_fields = $args['block_fields'];
  $block_meta = $args['block_meta'];
  $is_parallax = $block_meta['parallax_bg'];
?>

<?php if (!empty($block_fields['background_image'])): ?>
<div class="overlay block-bg-image" aria-hidden="true" <?php print ($is_parallax) ? 'data-parallax="scroll" data-image-src="'.$block_fields['background_image']['url'].'"' : ''; ?>>
  <?php if (!$is_parallax): ?>
    <img src="<?php print $block_fields['background_image']['url']; ?>" class="image-cover">
  <?php endif; ?>
</div>
<div class="overlay block-bg-image-overlay"></div>
<?php endif; ?>
