<?php /* Template Name: Page Elementor */ ?>

<?php get_header(); ?>

<section id="content">

	<?php
	// TO SHOW THE PAGE CONTENTS
	while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->

		<?php the_content(); ?> <!-- Page Content -->


		<?php
	endwhile; //resetting the page loop
	wp_reset_query(); //resetting the page query
	?>


</section>


<?php get_footer(); ?>

