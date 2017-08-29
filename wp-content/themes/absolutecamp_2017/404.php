<?php wp_redirect( home_url() ); exit; ?>

<?php


/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

//**  wp_redirect('healing-ministries.org/', $status = 302); exit; */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<p></p><p></p>
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'iahm_2016' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location.', 'iahm_2016' ); ?></p>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
