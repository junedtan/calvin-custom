<?php 
  $page_metadata = $args['page_metadata'];
  $arrow_icon = apply_filters('ccm_breadcrumb_arrow_icon', 'ph ph-caret-right');
  $show_breadcrumb = apply_filters('ccm_breadcrumb_show', !is_front_page());
  $links = ccm_generate_breadcrumb_items();
  $link_htmls = [];
  foreach ($links as $link_data) {
    if ($link_data['url']) {
      $link_htmls[] = '<a href="'.$link_data['url'].'" data-level="'.$link_data['level'].'">'.$link_data['label'].'</a>';
    } else {
      $link_htmls[] = $link_data['label'];
    }
  }
?>

<?php if ($show_breadcrumb && $links): ?>
  <div class="breadcrumb-outer">
    <div class="grid-container breadcrumb-container show-for-<?php print $page_metadata['show_breadcrumb_on']; ?>">
      <div class="inherit-a-color">
        <?php print implode('<span class="breadcrumb-separator '.$arrow_icon.'"></span>', $link_htmls); ?>
      </div>
    </div>
  </div>
<?php endif; ?>