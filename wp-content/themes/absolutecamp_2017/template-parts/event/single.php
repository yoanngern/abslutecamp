<?php get_header( 'event' ); ?>



<?php

if ( have_posts() ) :

	/* Start the Loop */
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/event/event', 'single-gfarm_event' );


	endwhile; ?>

	<?php

else :

	get_template_part( 'template-parts/event/none' );

endif;
?>

<?php get_footer(); ?>