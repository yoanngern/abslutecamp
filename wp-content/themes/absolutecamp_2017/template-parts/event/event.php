<section id="content">

    <div class="platter">
        <article class="content-page gfarm_event default">

            <div class="nav">
                <a href="<?php echo get_post_type_archive_link( 'gfarm_event' ); ?>"
                   class="back"><?php pll_e( 'Back' ) ?></a>

            </div>

            <header>

                <h1><?php echo get_the_title() ?></h1>
                <time><?php echo complex_date( get_field( 'start_date' ), get_field( 'end_date' ) ); ?></time>

            </header>

            <div class="content">

				<?php the_content(); ?>
            </div>


        </article>
    </div>
</section>


<?php

if ( get_field( 'speakers' ) || get_field( 'worship_leaders' ) ):?>


    <section id="guest">
        <div class="platter">
            <article class="content">


				<?php

				if ( get_field( 'speakers' ) ):?>
                    <div class="speakers">

                        <h1><?php pll_e( 'Speakers' ); ?></h1>

						<?php foreach ( get_field( 'speakers' ) as $speaker ) :

							set_query_var( 'person_id', $speaker->ID );
							get_template_part( 'template-parts/people/people_simple' );

						endforeach; ?>
                    </div>

				<?php endif; ?>

				<?php

				if ( get_field( 'worship_leaders' ) ):?>

                    <div class="worship_leaders">


                        <h1><?php pll_e( 'Worship' ); ?></h1>

						<?php foreach ( get_field( 'worship_leaders' ) as $worship_leader ) :

							set_query_var( 'person_id', $worship_leader->ID );
							get_template_part( 'template-parts/people/people_simple' );


						endforeach; ?>
                    </div>

				<?php endif; ?>
            </article>
        </div>
    </section>


<?php endif; ?>



<?php if ( have_rows( 'schedule' ) ): ?>
    <section id="schedule">

        <div class="platter">

            <article class="content">

                <h1><?php pll_e( 'Schedule' ); ?></h1>

				<?php while ( have_rows( 'schedule' ) ): the_row();

					$date = new DateTime( get_sub_field( 'date' ) );

					?>

                    <section class="day">
                        <div class="title">
                            <div class="bullet"></div>
                            <h2><?php echo date_i18n( 'l j', strtotime( $date->format( 'd-m-Y' ) ) ); ?></h2>
                        </div>
                        <div class="line"></div>

						<?php while ( have_rows( 'slot' ) ): the_row();

							$date = new DateTime( '01-01-1970 ' . get_sub_field( 'time' ) );

							?>
                            <article class="slot">
                                <div class="bullet"></div>

                                <time><?php echo time_trans( $date ); ?></time>
                                <div class="desc">
                                    <h3><?php echo get_sub_field( 'title' ); ?></h3>
                                    <span><?php echo get_sub_field( 'subtitle' ); ?></span>
                                </div>
                            </article>
						<?php endwhile; ?>

                    </section>


				<?php endwhile; ?>

            </article>
        </div>

    </section>
<?php endif; ?>
