<?php

$id    = get_the_ID();
$title = get_the_title();
$link  = esc_url( get_permalink() );

$date  = complex_date( get_field( 'start_date' ), get_field( 'end_date' ) );


$default_cat = get_term_by( 'slug', 'other', 'gfarm_eventcategory' );

$image = get_field_or_parent( 'banner_image', get_the_ID(), 'gfarm_eventcategory' );


if($image === null) {
	$image = get_field( 'banner_image', $default_cat );
}

?>


<div class="event">
	<a href="<?php echo $link; ?>">
		<div id="<?php echo $id; ?>" class="image" style="background-image: url('<?php echo $image['sizes']['card']; ?>')"></div>

		<h2><?php echo $title; ?></h2>
		<h3><?php echo $date; ?></h3>
	</a>
</div>