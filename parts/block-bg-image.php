<?php 
  $block_fields = $args['block_fields'];
  $block_meta = $args['block_meta'];
?>

<?php if (!empty($block_fields['background_image'])): ?>
<div class="overlay block-bg-image" aria-hidden="true">
  <img src="<?php print $block_fields['background_image']['url']; ?>" class="image-cover">
</div>
<div class="overlay block-bg-image-overlay"></div>
<?php endif; ?>
