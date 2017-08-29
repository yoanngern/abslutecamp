<?php get_header( 'default' ); ?>


<section id="content">

    <div class="platter">

		<?php
		// TO SHOW THE PAGE CONTENTS
		while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
            <article class="content-page">
				<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
				<?php the_content(); ?> <!-- Page Content -->

            </article><!-- .entry-content-page -->


			<?php
		endwhile; //resetting the page loop
		wp_reset_query(); //resetting the page query
		?>

    </div>


</section>


<?php get_footer(); ?>

