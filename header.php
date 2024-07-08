<!doctype html>
  <html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://kit.fontawesome.com/36ca2cd26f.js" crossorigin="anonymous"></script>
		<?php wp_head(); ?>
		<?php ccm_theme_fonts(); ?>
		<?php ccm_theme_styles(); ?>
	</head>
	<body <?php body_class(); ?>>
    
    <?php get_template_part( 'parts/top' ); ?>