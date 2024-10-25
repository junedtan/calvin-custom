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
    $css_vars[] = '--button-bg-color:'.$selected_color['button']['background'];
    $css_vars[] = '--button-color:'.$selected_color['button']['text'];
  }

  if (get_field('background_image')) {
    $classes[] = 'with-bg-image';
  }

  $parallax_bg = get_field('parallax');

  if ($parallax_bg) {
    $css_vars[] = 'background-color:transparent !important';
  }

  return array(
    'id' => $id,
    'classes' => $classes,
    'css_vars' => $css_vars,
    'parallax_bg' => $parallax_bg,
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
      'properties' => implode(';',[
        "background-color:".$color['background'],
        "color:".$color['text'],
        "--text-color:".$color['text'],
        "--accent-color:".$color['accent'],
        "--button-color:".$color['button']['text'],
        "--button-bg-color:".$color['button']['background'],
      ])
    );
    $css_definitions[] = array(
      'selector' => '.color-'.$color['key'],
      'properties' => implode(';',[
        "color:".$color['background'],
      ])
    );
  }

  $font_classes = [];
  foreach ($theme_types as $theme_type) {
    switch ($theme_type['usage']) {
      case 'heading':
        $font_key = 'h1, .h1-style, h2, .h2-style, h3, .h3-style, h4, .h4-style, h5, .h5-style, h6, .h6-style';
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
  if (is_array($theme_typesetting)) {
    foreach ($theme_typesetting as $typesetting) {
      $selector = $typesetting['selector'];
      if (in_array($selector,['h1','h2','h3','h4','h5','h6'])) {
        $selector .= ', .'.$selector.'-style';
      }
      $font_sizes = ccm_split_fluid_css($typesetting['sizes']);
      $line_heights = ccm_split_fluid_css($typesetting['line_heights'], false, false);
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

function ccm_get_pages_hierarchy($parent_id=null) {
  $args = array(
    'sort_column' => 'menu_order',
    'hierarchical' => 1,
  );
  if ($parent_id) {
    $args['child_of'] = $parent_id;
  }
  global $post;
  $current_page_id = $post->ID;
  $pages = get_pages($args);
  // level 1
  $result = [];
  $homepage_id = get_option('page_on_front');
  foreach ($pages as $level1_data) {
    if ($level1_data->ID == $homepage_id) continue; // skip homepage
    if ($level1_data->post_parent == 0) {
      $result[$level1_data->ID] = array(
        'title' => $level1_data->post_title,
        'post_name' => $level1_data->post_name,
        'permalink' => get_permalink($level1_data),
        'current' => ($level1_data->ID == $current_page_id),
        'children' => [],
      );
      // level 2
      foreach ($pages as $level2_data) {
        if ($level2_data->post_parent == $level1_data->ID) {
          $result[$level1_data->ID]['children'][$level2_data->ID] = array(
            'title' => $level2_data->post_title,
            'parent_id' => $level1_data->post_name,
            'post_name' => $level2_data->post_name,
            'permalink' => get_permalink($level2_data),
            'current' => ($level2_data->ID == $current_page_id),
            'children' => [],
          );
          // level 3
          foreach ($pages as $level3_data) {
            if ($level3_data->post_parent == $level2_data->ID) {
              $result[$level1_data->ID]['children'][$level2_data->ID]['children'][$level3_data->ID] = array(
                'title' => $level3_data->post_title,
                'parent_id' => $level2_data->post_name,
                'post_name' => $level3_data->post_name,
                'permalink' => get_permalink($level3_data),
                'current' => ($level3_data->ID == $current_page_id),
                'children' => [],
              );
              // level 3
            }        
          }
        }        
      }
  
    }
  }
  // propagate "current" to parents
  foreach ($result as $level1_id => $level1) {
    foreach ($level1['children'] as $level2_id => $level2) {
      if (count($level2['children']) > 0) {
        foreach ($level2['children'] as $level3_id => $level3) {
          if ($level3['current']) {
            $result[$level1_id]['children'][$level2_id]['current'] = $level3['current'];
            $result[$level1_id]['current'] = $level3['current'];  
          }
        }
      } else {
        if ($level2['current']) {
          $result[$level1_id]['current'] = $level2['current'];  
        }
      }
    }
  }
  return $result;
}

function ccm_get_page_metadata($page_id=null) {
  if (!$page_id) {
    global $post;
    $page_id = $post->ID;
  }
  $page_sidenav = [];
  $page_hierarchy = ccm_get_pages_hierarchy();
  foreach ($page_hierarchy as $level1_id => $level1_data) {
    if ($level1_data['current']) $page_sidenav = $level1_data;
  }
  return apply_filters('ccm_page_metadata', array(
    'page_id' => $page_id,
    'sidenav' => $page_sidenav,
    'hide_mobile_sidebar_on' => 'medium',
    'show_breadcrumb_on' => 'small',
    'with_sidebar' => !empty($page_sidenav),
  ));
}

function ccm_generate_breadcrumb_items() {
  $page_hierarchy = ccm_get_pages_hierarchy();
  $links = [];
  $links[] = array(
    'level' => 0,
    'url' => '/',
    'label' => apply_filters('ccm_breadcrumb_home_icon', '<span class="breadcrumb-home ph-fill ph-house">')
  );
  foreach ($page_hierarchy as $level1_id => $level1_data) {
    if ($level1_data['current']) {
      $links[] = array(
        'level' => 1,
        'url' => $level1_data['permalink'],
        'label' => $level1_data['title'],
      );
      foreach ($level1_data['children'] as $level2_id => $level2_data) {
        if ($level2_data['current']) {
          $links[] = array(
            'level' => 2,
            'url' => $level2_data['permalink'],
            'label' => $level2_data['title'],
          );    
          foreach ($level2_data['children'] as $level3_id => $level3_data) {
            if ($level3_data['current']) {
              $links[] = array(
                'level' => 3,
                'url' => $level3_data['permalink'],
                'label' => $level3_data['title'],
              );
            }        
          }    
        }        
      }
    }
  }
  return apply_filters('ccm_breadcrumb_items', $links);
}