<?php 
  $post_type = isset($args['post_type']) ? $args['post_type'] : 'post';
  $fetch_type = isset($args['fetch_type']) ? $args['fetch_type'] : 'latest';
  $fetch_args = isset($args['fetch_args']) ? $args['fetch_args'] : array();
  $post_count = isset($args['post_count']) ? $args['post_count'] : -1;
  $item_template = isset($args['item_template']) ? $args['item_template'] : '';
  $grid_class = isset($args['grid_class']) ? $args['grid_class'] : '';

  $get_posts_args = array(
    'post_type' => $post_type,
    'post_status' => 'publish',
    'posts_per_page' => $post_count,
  );

  switch ($fetch_type) {
    case 'random':
      $get_posts_args['orderby'] = 'rand';
      break;
    case 'latest':
      $get_posts_args['orderby'] = 'publish_date';
      $get_posts_args['order'] = 'desc';
      break;
  }
  if ($fetch_type == 'custom') {
    $fetch_posts = $get_posts_args['custom_posts'];
  } else {
    $get_posts_args = array_merge($get_posts_args,$fetch_args);
    $fetch_posts = get_posts($get_posts_args);
  }

?>

<?php 
  get_template_part('parts/block-content-index-title', null, $args);
?>
<div class="grid-x grid-margin-x post-accordion <?php print $grid_class; ?>">
  <?php if ($item_template): ?>
    <div class="cell">
      <ul class="accordion" data-accordion data-multi-expand="true" data-allow-all-closed="true">
        <?php foreach ($fetch_posts as $fetch_post) :?>
          <li class="accordion-item" data-accordion-item>
            <?php get_template_part($item_template, null, array(
              'item' => $fetch_post,
              'accordion_args' => $args,
            )); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php else: ?>
    <div class="cell">Please set item template</div>
  <?php endif; ?>
</div>