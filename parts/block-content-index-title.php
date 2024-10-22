<?php 
  $title = isset($args['title']) ? $args['title'] : '';
  $cta = isset($args['cta']) ? $args['cta'] : null;
  $title_class = isset($args['title_class']) ? $args['title_class'] : '';

?>

<?php if ($title || $cta): ?>
<div class="grid-x grid-margin-x <?php print $title_class; ?>">
  <?php if ($title): ?>
    <div class="cell auto cancel-last-margin">
      <h2><?php print $title; ?></h3>
    </div>
  <?php endif; ?>
  <?php if ($cta): ?>
    <div class="cell shrink show-for-medium text-right">
      <?php print do_shortcode('[cta-link url="'.$cta['url'].'" label="'.$cta['title'].'"]')?>
    </div>
  <?php endif; ?>
</div>
<?php endif; ?>
