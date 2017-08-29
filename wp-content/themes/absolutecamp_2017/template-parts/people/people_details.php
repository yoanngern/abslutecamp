<?php

$person = get_post( $person_id );

$first_name = get_field( 'first_name', $person->ID );
$last_name  = get_field( 'last_name', $person->ID );

$avatar     = get_field( 'avatar', $person->ID );
$bio        = get_field( 'bio', $person->ID );
$country_id = get_field( 'country_id', $person->ID );
$url        = get_field( 'url', $person->ID );
$label      = get_field( 'website_label', $person->ID );


?>

<section class="person">


	<?php if ( ! empty( $avatar ) ) : ?>
        <div class="picture">
            <img src="<?php echo $avatar['sizes']['avatar']; ?>" alt="">
        </div>
	<?php endif; ?>


    <div class="bio">
        <h2><?php echo $first_name . " " . $last_name; ?><?php
			if ( $country_id != null ) {
				echo " (" . $country_id . ")";
			}
			?></h2>
        <p><?php echo $bio; ?></p>
        <p>
            <a target="_blank"
               href="<?php echo $url; ?>"><?php echo $label; ?></a>
        </p>
    </div>

</section>
