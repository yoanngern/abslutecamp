<?php ?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>

	<title><?php echo get_bloginfo( 'title'); ?></title>


	<meta name="description" content="<?php echo get_bloginfo( 'description'); ?>">

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport"
	      content="initial-scale=1, width=device-width, minimum-scale=1, user-scalable=no, maximum-scale=1, width=device-width, minimal-ui">
	<link rel="profile" href="http://gmpg.org/xfn/11">



	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_stylesheet_directory_uri(); ?>/images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-16x16.png">
	<link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/images/manifest.json">
	<link rel="mask-icon" href="images/favicon_hd.svg" color="#B5191D">
	<meta name="msapplication-TileColor" content="#B5191D">
	<meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri(); ?>/images/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

	<script>

	</script>
	<?php wp_head(); ?>


	<script>


	</script>

</head>

<body <?php body_class(); ?>>

<header>



</header>