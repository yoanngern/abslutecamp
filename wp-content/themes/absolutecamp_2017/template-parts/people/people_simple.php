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

    <div class="picture">
		<?php if ( ! empty( $avatar ) ) : ?>
            <img src="<?php echo $avatar['sizes']['avatar']; ?>" alt="">
		<?php endif; ?>
        <h2><?php echo $first_name . " " . $last_name; ?><?php
			if ( $country_id != null ) {
				echo " (" . $country_id . ")";
			}
			?></h2>
    </div>

    <div class="bio">
        <p><?php echo $bio; ?></p>
        <p>
            <a target="_blank"
               href="http://<?php echo $url; ?>"><?php echo $url; ?></a>
        </p>
    </div>

</section>
