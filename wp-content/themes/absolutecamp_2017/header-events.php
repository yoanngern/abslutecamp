<?php get_header( 'subnav' ); ?>


<section id="bigimage">

	<?php


	if ( is_tax( 'gfarm_eventcategory' ) ):

		$banner_image = get_field_or_parent( 'banner_image', get_queried_object()->term_id, 'gfarm_eventcategory', 'term' );
		$banner_title = get_field_or_parent( 'banner_title', get_queried_object()->term_id, 'gfarm_eventcategory', 'term' );

	elseif ( $post->post_type == "gfarm_event" ):


		$default_cat = get_term_by( 'slug', 'other', 'gfarm_eventcategory' );

		$banner_image = get_field( 'banner_image', $default_cat );
		$banner_title = get_field( 'banner_title', $default_cat );

	else:

		$banner_image = get_field_or_parent( 'banner_image', get_the_ID(), 'gfarm_eventcategory' );
		$banner_title = get_field_or_parent( 'banner_title', get_the_ID(), 'gfarm_eventcategory' );


	endif;


	?>

    <div class="banner"
         style="background-image: url('<?php echo $banner_image['sizes']['banner_image']; ?>')">

        <div class="title">
            <div class="text">
                <h1><?php echo $banner_title; ?><span class="underline"></span></h1>
            </div>


        </div>
    </div>


</section>