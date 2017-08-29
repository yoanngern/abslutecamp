<?php get_header( 'events' ); ?>


<section id="content" class="events">

    <div class="platter">

		<?php


		if ( have_posts() ) :

		else :

			get_template_part( 'template-parts/blog/none' );

		endif;
		?>


    </div>

</section>

<?php get_footer(); ?>
