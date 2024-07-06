<?php
  $title = $args['title'];
  $subtitle = $args['subtitle'];
?>

<?php if ($subtitle): ?>
  <p class="subtitle"><?php print $subtitle; ?></p>
<?php endif; ?>
<?php if ($title): ?>
  <h2 class="h1-style"><?php print $title; ?></h2>
<?php endif; ?>
