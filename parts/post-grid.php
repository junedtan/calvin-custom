<?php 
  $post_type = isset($args['post_type']) ? $args['post_type'] : 'post';
  $fetch_type = isset($args['fetch_type']) ? $args['fetch_type'] : 'latest';
  $fetch_args = isset($args['fetch_args']) ? $args['fetch_args'] : array();
  $post_count = isset($args['post_count']) ? $args['post_count'] : -1;
  $item_template = isset($args['item_template']) ? $args['item_template'] : '';
  $items_per_row = isset($args['items_per_row']) ? $args['items_per_row'] : 4;
  $cta = isset($args['cta']) ? $args['cta'] : null;
  $grid_class = isset($args['grid_class']) ? $args['grid_class'] : '';

  $use_paging = isset($args['use_paging']) ? $args['use_paging'] : false;
  $items_per_page = isset($args['items_per_page']) ? $args['items_per_page'] : 0;
  $use_paging = $use_paging && $items_per_page > 0;
  $paging_type = 'numbers'; // option lain akan diimplement someday isset($args['title_class']) ? $args['title_class'] : v'align-middle';

  switch ($items_per_row) {
    case 4: 
      $cell_class = 'medium-6 large-3';
      break;
    case 1: 
      $cell_class = '';
      break;
    default:
    $cell_class = 'medium-6 large-4';
  }

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

  // paging
  if ($use_paging) {
    $posts_by_pages = array_chunk($fetch_posts,$items_per_page);
  } else {
    $posts_by_pages = [$fetch_posts];
  }
?>

<?php 
  get_template_part('parts/block-content-index-title', null, $args);
?>
<div class="grid-x grid-margin-x post-grid <?php print $grid_class; ?>" data-current-page="1" data-page-count="<?php print count($posts_by_pages); ?>">
  <?php if ($item_template): ?>
    <?php foreach ($posts_by_pages as $idx => $page_posts): ?>
      <?php foreach ($page_posts as $fetch_post) :?>
        <div class="cell post-grid-item <?php print $cell_class; ?> <?php print $idx > 0 ? 'hide' : ''; ?>" data-page="<?php print ($idx + 1); ?>">
          <?php get_template_part($item_template, null, array(
            'item' => $fetch_post,
            'grid_args' => $args,
          )); ?>
        </div>
      <?php endforeach; ?>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="cell">Please set item template</div>
  <?php endif; ?>
</div>

<?php if ($use_paging): ?>
  <div class="grid-x post-grid-pager">
    <div class="cell"><hr></div>
    <div class="cell flex-container align-middle">
      <a href="javascript:void(0)" class="pager prev disabled" data-page="prev"><span class="ph ph-caret-left"></span></a>
      <?php for ($i=1; $i<=count($posts_by_pages); $i++): ?>
        <a class="pager page <?php print ($i==1) ? 'active' : ''; ?>" href="javascript:void(0)" data-page="<?php print $i; ?>"><?php print $i; ?></a>
      <?php endfor; ?>
      <a href="javascript:void(0)" class="pager next" data-page="next"><span class="ph ph-caret-right"></span></a>
    </div>
  </div>
<?php endif; ?>

<?php if ($cta): ?>
  <div class="grid-x grid-margin-x pt-1 hide-for-medium">
    <div class="cell">
      <?php print do_shortcode('[cta-link url="'.$cta['url'].'" label="'.$cta['title'].'"]')?>
    </div>
  </div>
<?php endif; ?>

