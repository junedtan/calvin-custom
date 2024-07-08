<?php 

// pastikan match dengan scss/_settings.scss
define('THEME_BREAKPOINTS', array(
  'small' => '0',
  'medium' => '768px',
  'large' => '1280px',
  'xlarge' => '1440px',
  'xxlarge' => '1920px',
));

function ccm_load_color_field_choices( $field ) {
  $field['choices'] = array();
  $theme_settings = get_fields('option');
  $theme_colors = $theme_settings['theme_colors'];

  if( is_array($theme_colors) ) {    
    foreach( $theme_colors as $choice ) {
      $field['choices'][ $choice['key'] ] = $choice['name'];
    }
  }
  return $field;  
}
add_filter('acf/load_field/name=background_color', 'ccm_load_color_field_choices');
add_filter('acf/load_field/name=hero_background_color', 'ccm_load_color_field_choices');

function ccm_get_block_metadata($block, $block_type) {
  // Create id attribute allowing for custom "anchor" value.
  $id = $block_type.'-' . $block['id'];
  if ( ! empty($block['anchor'] ) ) {
      $id = $block['anchor'];
  }

  $css_vars = [];

  // Create class attribute allowing for custom "className" and "align" values.
  $classes = ['block-'.$block_type];
  if ( ! empty( $block['className'] ) ) {
      $classes[] = $block['className'];
  }
  if (in_array($block['name'], array('acf/text','acf/image-carousel'))) {
    $classes[] = 'titled-block';
  }
  $top_padding = get_field('top_margin');
  $top_padding_mapping = array(
    'none' => 'pt-0',
    'small' => 'pt-1 medium-pt-2',
    'medium' => 'pt-2 medium-pt-3 large-pt-4',
    'large' => 'pt-3 medium-pt-4 large-pt-6',
    'extra-large' => 'pt-4 medium-pt-6 large-pt-8',
  );
  if (!in_array($top_padding,array_keys($top_padding_mapping))) $top_padding = 'none';
  $classes[] = $top_padding_mapping[$top_padding];

  $bottom_padding = get_field('bottom_margin');
  $bottom_padding_mapping = array(
    'none' => 'pb-0',
    'small' => 'pb-1 medium-pb-2',
    'medium' => 'pb-2 medium-pb-3 large-pb-4',
    'large' => 'pb-3 medium-pb-4 large-pb-6',
    'extra-large' => 'pb-4 medium-pb-6 large-pb-8',
  );
  if (!in_array($bottom_padding,array_keys($bottom_padding_mapping))) $bottom_padding = 'none';
  $classes[] = $bottom_padding_mapping[$bottom_padding];

  $background_color = get_field('background_color');
  $classes[] = 'bg-color-'.$background_color;
  $colors = get_field('theme_colors','option');
  $selected_color = false;
  foreach ($colors as $color) {
    if ($color['key'] == $background_color) {
      $selected_color = $color;
      break;
    }
  }
  if ($selected_color) {
    $css_vars[] = '--bg-color:'.$selected_color['background'];
    $css_vars[] = '--text-color:'.$selected_color['text'];
    $css_vars[] = '--accent-color:'.$selected_color['accent'];
  }

  return array(
    'id' => $id,
    'classes' => $classes,
    'css_vars' => $css_vars,
  );

}

function ccm_theme_fonts() {
  $theme_settings = get_fields('option');
  $theme_fonts = $theme_settings['theme_fonts'];
  print '<link rel="preconnect" href="https://fonts.googleapis.com">';
  print '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
  foreach ($theme_fonts as $font) {
    print '<link href="'.$font['google_font_url'].'" rel="stylesheet">';
  }
}

function ccm_split_fluid_css($px_value, $use_px=true, $rounding=true) {
  // asumsi isi px_value minimal satu angka, max dua
  if (!$px_value) return [];
  $px_values = explode(',', $px_value);
  if (count($px_values) > 1) {
    if ($rounding) {
      $px_small = (int)trim($px_values[0]);
      $px_large = (int)trim($px_values[1]);  
    } else {
      $px_small = (float)trim($px_values[0]);
      $px_large = (float)trim($px_values[1]);  
    }
  } else {
    // default di mobile 2/3 di desktop
    if ($rounding) {
      $px_small = round((int)trim($px_values[0])*0.6667);
      $px_large = (int)trim($px_values[0]);  
    } else {
      $px_small = round((float)trim($px_values[0])*0.6667);
      $px_large = (float)trim($px_values[0]);  
    }
  }
  $px_medium = $px_small + round(($px_large - $px_small) / 2);
  return [$px_small.($use_px ? 'px' : ''), $px_medium.($use_px ? 'px' : ''), $px_large.($use_px ? 'px' : '')];
}

function ccm_theme_styles() {
  $theme_settings = get_fields('option');
  $theme_colors = $theme_settings['theme_colors'];
  $theme_fonts = $theme_settings['theme_fonts'];
  $theme_types = $theme_settings['theme_types'];
  $theme_typesetting = $theme_settings['theme_typesetting'];
  $theme_default_typesetting = $theme_settings['theme_default_typesetting'];

  $font_mapping = array();
  foreach ($theme_fonts as $font) {
    $font_mapping[$font['name']] = $font;
  }

  $css_definitions = [];
  $css_medium_definitions = [];
  $css_large_definitions = [];

  $color_classes = [];
  foreach ($theme_colors as $color) {
    $css_definitions[] = array(
      'selector' => '.bg-color-'.$color['key'],
      'properties' => "background-color:".$color['background'].";color:".$color['text'].";--text-color:".$color['text'].";--accent-color:".$color['accent'],
    );
  }

  $font_classes = [];
  foreach ($theme_types as $theme_type) {
    switch ($theme_type['usage']) {
      case 'heading':
        $font_key = 'h1, h2, h3, h4, h5, h6';
        break;
      case 'subtitle':
        $font_key = '.subtitle,.eyebrow';
        break;
      case 'body':
        $font_key = 'body';
        break;
      case 'body-alt':
        $font_key = '.p2';
        break;
      case 'cta':
        $font_key = 'button, .button, .cta, input[type="button"], input[type="submit"]';
        break;
    }
    $css_definitions[] = array(
      'selector' => $font_key,
      'properties' => "font-family:\"".$theme_type['font']."\", ".$font_mapping[$theme_type['font']]['serif']."; font-weight: ".$theme_type['weight'].";",
    );
  }

  $typesetting_defaults = array(
    'line_height' => $theme_default_typesetting['line_height'],
  );
  $css_definitions[] = array(
    'selector' => 'body',
    'properties' => "line-height: ".$typesetting_defaults['line_height'],
  );
  foreach ($theme_typesetting as $typesetting) {
    $selector = $typesetting['selector'];
    if (in_array($selector,['h1','h2','h3','h4','h5','h6'])) {
      $selector .= ', .'.$selector.'-style';
    }
    $font_sizes = ccm_split_fluid_css($typesetting['sizes']);
    $line_heights = ccm_split_fluid_css($typesetting['line_heights'], false);
    $kernings = ccm_split_fluid_css($typesetting['kernings'], true, false);
    $properties = "font-size:".$font_sizes[0].';';
    $properties_medium = "font-size:".$font_sizes[1].';';
    $properties_large = "font-size:".$font_sizes[2].';';
    if ($line_heights) {
      $properties .= "line-height:".$line_heights[0].';';
      $properties_medium .= "line-height:".$line_heights[1].';';
      $properties_large .= "line-height:".$line_heights[2].';';
      }
    if ($kernings) {
      $properties .= "letter-spacing:".$kernings[0].';';
      $properties_medium .= "letter-spacing:".$kernings[1].';';
      $properties_large .= "letter-spacing:".$kernings[2].';';
    }
    if ($properties) {
      $css_definitions[] = array(
        'selector' => $selector,
        'properties' => $properties,
      );  
    }
    if ($properties_medium) {
      $css_medium_definitions[] = array(
        'selector' => $selector,
        'properties' => $properties_medium,
      );  
    }
    if ($properties_large) {
      $css_large_definitions[] = array(
        'selector' => $selector,
        'properties' => $properties_large,
      );  
    }
  }


  print '<style>';
  // let's go!
  foreach ($css_definitions as $definition) {
    print $definition['selector']." {".$definition['properties']."}";
  }
  if ($css_medium_definitions) {
    print '@media screen and (min-width:'.THEME_BREAKPOINTS['medium'].') {';
    foreach ($css_medium_definitions as $definition) {
      print $definition['selector']." {".$definition['properties']."}";
    }  
    print '}';
  }
  if ($css_large_definitions) {
    print '@media screen and (min-width:'.THEME_BREAKPOINTS['large'].') {';
    foreach ($css_large_definitions as $definition) {
      print $definition['selector']." {".$definition['properties']."}";
    }  
    print '}';
  }
  print '</style>';
}