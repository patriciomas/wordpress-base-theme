<?php require_once('functions.php'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?> >
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="<?php bloginfo('description'); ?>">
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );

	?></title>

<!-- Estilos -->
<link href="<?php bloginfo('template_url'); ?>/css/bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" media="screen,projection" />

<!-- Fonts -->
<link href='https://fonts.googleapis.com/css?family=Raleway:300,500|Open+Sans:300,400,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/font-awesome-4.5.0/css/font-awesome.min.css">

<!-- Favicon -->
<link rel="icon" href="<?php bloginfo('template_url'); ?>/css/images/favicon.ico" type="image/x-icon" />

<!-- JQuery -->
<?php wp_enqueue_script("jquery"); ?>

<?php wp_head(); ?>

</head>

<!-- Send your website�s header before sending the rest of the content. By using the flush function, the browser has time to download all the stylesheets referenced in the header while waiting for the other parts of the web page. -->
<?php flush(); ?>

<body <?php body_class($class); ?>>

<div id="container">

    <header id="header">
    <h1><a href="<?php bloginfo('url'); ?>" title="Inicio"><?php bloginfo( 'name' ); ?></a></h1>
    <p><?php bloginfo( 'description' ); ?></p>

		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

		<ul class="social">
		<?php if( get_theme_mod( 'url_facebook' ) != '') { ?>
			<li class="twitter"><a href="<?php echo get_theme_mod( 'url_facebook' ); ?>" target="_blank" title="Facebook"><i class="fa fa-facebook-square"></i><span>Facebook</span></a></li>
		<?php } // end if ?>
		<?php if( get_theme_mod( 'url_twitter' ) != '') { ?>
			<li class="twitter"><a href="<?php echo get_theme_mod( 'url_twitter' ); ?>" target="_blank" title="Twitter"><i class="fa fa-twitter-square"></i><span>Twitter</span></a></li>
		<?php } // end if ?>
		<?php if( get_theme_mod( 'url_linkedin' ) != '') { ?>
			<li class="linkedin"><a href="<?php echo get_theme_mod( 'url_linkedin' ); ?>" target="_blank" title="Linkedin"><i class="fa fa-linkedin-square"></i><span>Linkedin</span></a></li>
		<?php } // end if ?>
		</ul>

        <div id="mobile-menu"><i class="fa fa-bars"></i></div>
        <?php wp_nav_menu(array('menu' => 'Main Menu', 'container' => 'nav', 'container_class' => 'menu-header')); ?>

      <div id="breadcrumb">
          <?php the_breadcrumb(); ?>
      </div><!-- breadcrumb -->

    </header><!-- header -->

		<main role="main" class="clearfix">
