<?php function wpdocs_excerpt_more( $more ) {
    return sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
          esc_url( get_permalink( get_the_ID() ) ),
          sprintf( __( 'Read More %s', 'wpdocs' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

?>