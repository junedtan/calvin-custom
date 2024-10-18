<?php 
  $content = $args['content'];
  $content_classes = apply_filters('ccm_hero_content_classes', array(
    'container' => 'align-center align-middle',
    'title' => 'h1-style',
    'subtitle' => 'subtitle',
    'cta' => 'cta',
  ));
?>
<?php if ($content): ?>
  <div class="hero-content overlay">
    <div class="grid-container">
      <div class="grid-x grid-margin-x">
        <div class="cell flex-container flex-dir-column <?php print $content_classes['container']; ?> cancel-last-margin">
          <?php if ($content['title']): ?>
            <h2 class="<?php print $content_classes['title'];?>"><?php print $content['title']; ?></h2>
          <?php endif; ?>
          <?php if ($content['subtitle']): ?>
            <p class="<?php print $content_classes['subtitle'];?>"><?php print $content['subtitle']; ?></p>
          <?php endif; ?>
          <?php if ($content['cta']): ?>
            <p>
              <a href="<?php print $content['cta']['url']; ?>" class="<?php print $content_classes['cta'];?>" target="<?php print $content['cta']['target']; ?>"><?php print $content['cta']['title']; ?></a>
            </p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
