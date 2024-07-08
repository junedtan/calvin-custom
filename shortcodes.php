<?php 

function ccm_shortcode_eyebrow($args=array(), $content='') {
  $result = apply_filters('the_content', $content);
  $result = str_replace('<p', '<p class="subtitle"', $result);
  // $result = '<span class="eyebrow">'.$result.'</span>';
  return $result;
}
add_shortcode('eyebrow', 'ccm_shortcode_eyebrow');

function ccm_shortcode_button($args=array()) {
  $url = isset($args['url']) ? $args['url'] : '';
  $label = isset($args['label']) ? $args['label'] : '';
  if (!($url && $label)) return '';
  $target = isset($args['target']) ? $args['target'] : '';

  return '<a href="'.$url.'" target="'.$target.'" class="button">'.$label.'</a>';
}
add_shortcode('button', 'ccm_shortcode_button');

function ccm_shortcode_social_media($args=array()) {
  $socmed = get_field('social_media', 'option');
  $result = '';
  foreach ($socmed as $socmed_item) {
    $result .= '<span class="socmed-item"><a href="'.$socmed_item['url'].'" target="_blank"><span class="fa-brands fa-'.$socmed_item['type'].'"></span></a></span>';
  }
  return '<span class="socmed-container">'.$result.'</span>';
}
add_shortcode('social-media', 'ccm_shortcode_social_media');

