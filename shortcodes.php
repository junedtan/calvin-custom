<?php 

function ccm_shortcode_eyebrow($args=array(), $content='') {
  $result = apply_filters('the_content', $content);
  $result = str_replace('<p', '<p class="eyebrow"', $result);
  // $result = '<span class="eyebrow">'.$result.'</span>';
  return $result;
}
add_shortcode('eyebrow', 'ccm_shortcode_eyebrow');
