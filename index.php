<?php 
  ccm_redirect_to_first_child();
  get_header();
  the_post();
  $page_metadata = ccm_get_page_metadata();
?>

<main>
  <h1 class="hide"><?php the_title(); ?></h1>
  <?php 
    get_template_part('parts/breadcrumb', null, array(
      'page_metadata' => $page_metadata,
    ));
  ?>
  <?php if ($page_metadata['with_sidebar']): ?>
    <div class="grid-container sidebar-outer mobile-sidebar hide-for-<?php print $page_metadata['hide_mobile_sidebar_on']; ?>" aria-hidden="true">
      <div class="sidebar-container">
        <?php 
          get_template_part('parts/sidebar', null, array(
            'page_metadata' => $page_metadata,
          ));
        ?>
      </div>    
    </div>
  <?php endif; ?>
  <?php 
    get_template_part('parts/hero'); 
  ?>
  <div class="outer-container <?php print ($page_metadata['with_sidebar']) ? 'with-sidebar' : ''; ?>">
    <?php if ($page_metadata['with_sidebar']): ?>
      <div class="grid-container sidebar-outer desktop-sidebar show-for-<?php print $page_metadata['hide_mobile_sidebar_on']; ?>">
        <div class="sidebar-container">
          <?php 
            get_template_part('parts/sidebar', null, array(
              'page_metadata' => $page_metadata,
            ));
          ?>
        </div>   
      </div>
    <?php endif; ?>
    <?php the_content(); ?>
  </div>


</main>

<?php get_footer(); ?>