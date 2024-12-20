<?php 

function ccm_shortcode_eyebrow($args=array(), $content='') {
  $result = apply_filters('the_content', $content);
  $result = str_replace('<p', '<p class="subtitle"', $result);
  // $result = '<span class="eyebrow">'.$result.'</span>';
  return $result;
}
add_shortcode('eyebrow', 'ccm_shortcode_eyebrow');

function ccm_shortcode_deck($args=array(), $content='') {
  $result = apply_filters('the_content', $content);
  $result = str_replace('<p', '<p class="deck"', $result);
  return $result;
}
add_shortcode('deck', 'ccm_shortcode_deck');

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
  if (!is_array($socmed)) return '';
  foreach ($socmed as $socmed_item) {
    $result .= '<span class="socmed-item"><a href="'.$socmed_item['url'].'" target="_blank"><span class="ph-fill ph-'.$socmed_item['type'].'-logo"></span></a></span>';
  }
  return '<span class="socmed-container">'.$result.'</span>';
}
add_shortcode('social-media', 'ccm_shortcode_social_media');

function ccm_shortcode_icon($args=array()) {
  $icon = $args['icon'];
  $style = 'regular';
  if ($style != 'regular') {
    $style = 'ph-'.$style;
  } else {
    $style = 'ph';
  }
  return '<span class="icon '.$style.' ph-'.$icon.'"></span>';
}
add_shortcode('icon', 'ccm_shortcode_icon');

function ccm_shortcode_cta_link($args=array()) {
  $use_caret = true; // dikembangkan kemudian
  $classes = isset($args['classes']) ? $args['classes'] : '';
  return '<a href="'.$args['url'].'" class="cta-link '.$classes.'" target="'.(isset($args['target']) ? $args['target'] : '').'"><span>'.$args['label'].'</span>'.($use_caret ? '<span class="ph ph-caret-right"></span>' : '').'</a>';
}
add_shortcode('cta-link', 'ccm_shortcode_cta_link');

