<?php

if ( is_single() ) :

get_template_part( 'template-parts/event/single' );

else:

get_template_part( 'template-parts/event/list' );

endif;

?>