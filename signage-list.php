<?php // Template Name: Signage 

if ( isset( $_GET['location'] ) )
    $location = sanitize_title_for_query( $_GET['location'] );

if ( ! isset( $_GET['description'] ) ) {
    $short_description = true;
} else {
    $short_description = false;
}
    

if ( isset( $_GET['day'] ) )
    $day = sanitize_title_for_query( $_GET['day'] );

if ( ! empty( $location ) )
    $term = wpcom_vip_get_term_by( 'name', $location, 'location' );

/**
 * Get our schedule stuff
 * @param  String $location [description]
 * @return [type]           [description]
 */
function get_schedule_list( $location, $short_description = false, $day_set = '' ) {
    $output = '';

    if ( empty( $day_set ) || $day_set == 'saturday' ) {
        $saturday = wp_cache_get( $location . '_saturday_schedule' );
        if( $saturday == false ) {
            $args = array( 
                'location'      => $location,
                'post_type'     => 'event-items',
                'orderby'       => 'meta_value', 
                'meta_key'      => 'mfei_start',
                'faire'         => $GLOBALS['current_faire'],
                'order'         => 'asc',
                'posts_per_page'=> '30',
                'meta_query' => array(
                    array(
                        'key'   => 'mfei_day',
                        'value' => 'Saturday'
                   )
                )
                );
            $saturday = new WP_Query( $args );
            wp_cache_set( $location . '_saturday_schedule', $saturday, '', 300 );
        }

        $output .= '<h2>Saturday</h1>';
        $output .= '<table style="width:100%;">';
        while ( $saturday->have_posts() ) : $saturday->the_post();
            $meta = get_post_meta( get_the_ID());
            $sched_post = get_post( $meta['mfei_record'][0] );
            $json = json_decode( mf_convert_newlines( mf_character_fixer( $sched_post->post_content ) ) );
            $day = ($meta['mfei_day'][0]) ? $meta['mfei_day'][0] : '' ;
            $start = ($meta['mfei_start'][0]) ? $meta['mfei_start'][0] : '';
            $stop = ($meta['mfei_stop'][0]) ? $meta['mfei_stop'][0] : '';

            $output .= '<tr>';
            $output .= '<td width="160" style="max-width:160px; padding:15px 0;" valign="top">';
            if ( ! isset ( $location ) ) {
                $output .= '<h4 style="margin-top:0;">' . strip_tags( get_the_term_list( get_the_ID(), 'location' ) ) . '</h4>'; 
            }
            $output .= '<h2 style="font-size:.9em; color:#333; margin-top:3px;">' . esc_html( $start ) . ' &mdash; ' . esc_html( $stop ) . '</h2>';
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<h3 style="margin-top:0;">' . esc_html( get_the_title( $sched_post->ID ) ) . '</h3>';
            if ( ! empty( $json->presenter_name ) ) {
                $names = $json->presenter_name;
                $names_output = '';
                foreach ( $names as $name ) {
                    $names_output .= ', ' . esc_html( $name );
                }
                $output .= '<h4 style="margin:5px 0 0; color:#666;">' . substr($names_output, 2) . '</h4>';
            }
            if ( $short_description == true && ! empty( $json->short_description) ) {
                $output .= Markdown ( mf_character_fixer( stripslashes( wp_filter_post_kses( mf_convert_newlines( esc_html( $json->short_description ), "\n" ) ) ) ) );
            }
            $output .= '<tr><td colspan="2"><div style="border-bottom:2px solid #ccc;"></div></td></tr>';
            $output .= '</td>';
            $output .= '</tr>';
        endwhile;
        $output .= '</table>';
        wp_reset_postdata();
    }

    // Roll the schedule for Sunday.
    if ( empty( $day_set ) || $day_set == 'sunday' ) {
        $sunday = wp_cache_get( $location . '_sunday_schedule' );
        if( $sunday == false ) {
            $args = array( 
                'location'      => $location,
                'post_type'     => 'event-items',
                'orderby'       => 'meta_value', 
                'meta_key'      => 'mfei_start',
                'faire'         => $GLOBALS['current_faire'],
                'order'         => 'asc',
                'posts_per_page'=> '30',
                'meta_query' => array(
                    array(
                        'key'   => 'mfei_day',
                        'value' => 'Sunday'
                   )
                )
                );
            $sunday = new WP_Query( $args );
            wp_cache_set( $location . '_sunday_schedule', $sunday, '', 300 );
        }
        $output .= '<h2 style="margin-top:30px;">Sunday</h1>';
        $output .= '<table style="width:100%;">';
        while ( $sunday->have_posts() ) : $sunday->the_post();
            $meta = get_post_meta( get_the_ID());
            $sched_post = get_post( $meta['mfei_record'][0] );
            $json = json_decode( mf_convert_newlines( mf_character_fixer( $sched_post->post_content ) ) );
            $day = ($meta['mfei_day'][0]) ? $meta['mfei_day'][0] : '' ;
            $start = ($meta['mfei_start'][0]) ? $meta['mfei_start'][0] : '';
            $stop = ($meta['mfei_stop'][0]) ? $meta['mfei_stop'][0] : '';

            $output .= '<tr>';
            $output .= '<td width="160" style="max-width:160px; padding:15px 0;" valign="top">';
            if ( ! isset ( $location ) ) {
                $output .= '<h4 style="margin-top:0;">' . strip_tags( get_the_term_list( get_the_ID(), 'location' ) ) . '</h4>'; 
            }
            $output .= '<h2 style="font-size:.9em; color:#333; margin-top:3px;">' . esc_html( $start ) . ' &mdash; ' . esc_html( $stop ) . '</h2>';
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<h3 style="margin-top:0;">' . esc_html( get_the_title( $sched_post->ID ) ) . '</h3>';
            if ( ! empty( $json->presenter_name ) ) {
                $names = $json->presenter_name;
                $names_output = '';
                foreach ( $names as $name ) {
                    $names_output .= ', ' . esc_html( $name );
                }
                $output .= '<h4 style="margin:5px 0 0; color:#666;">' . substr($names_output, 2) . '</h4>';
            }
            if ( $short_description == true && ! empty( $json->short_description) ) {
                $output .= Markdown ( mf_character_fixer( stripslashes( wp_filter_post_kses( mf_convert_newlines( esc_html( $json->short_description ), "\n" ) ) ) ) );
            }
            $output .= '<tr><td colspan="2"><div style="border-bottom:2px solid #ccc;"></div></td></tr>';
            $output .= '</td>';
            $output .= '</tr>';
        endwhile;
        $output .= '</table>';
        wp_reset_postdata();

    }

    return $output;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Stage Signage - <?php echo sanitize_title( $location ); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <style>
            body { font-family: 'Benton Sans', Helvetica, sans-serif; }
            a { text-decoration:none; color:#000; }
            h1, h2, h3, h4 { margin:5px 0 0; }
        </style>
    </head>
    <body>
        <h1 style="font-size:2.2em; margin:31px 0 0; max-width:75%;"><?php echo ucwords( str_replace( '-', ' ', esc_html( $location ) ) ); ?></h1>
        <?php if ( ! empty( $term->description ) ) {
            echo '<div style="font-weight:normal; margin-top:-15px; margin-left:5px; text-decoration:italic;">' . Markdown( esc_html( $term->description ) ) . '</div>';
        } ?>
        <h2 style="position:absolute; top:16px; right:30px;"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" style="width:200px;" alt="" ></h2>
        <p></p>
        <p></p>
        <p></p>
        <?php echo get_schedule_list( $location, $short_description, $day ); ?>
    </body>
</html>
