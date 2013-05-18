<?php // Template Name: Signage 

if ( isset( $_GET['location'] ) )
    $location = $_GET['location'];

if ( isset( $_GET['description'] ) ) 
    $public_description = true;

if ( isset( $_GET['day'] ) )
    $day = $_GET['day'];

if ( ! empty( $location ) )
    $term = wpcom_vip_get_term_by( 'name', $location, 'location' );

/**
 * Get our schedule stuff
 * @param  String $location [description]
 * @return [type]           [description]
 */
function get_schedule_list( $location, $public_description = false, $day = '' ) {
    if ( isset( $day ) && ($day == 'Saturday' || $day == 'saturday') ) {
        $output = '';
        $query = wp_cache_get( $location . '_saturday_schedule' );
        if( $query == false ) {
            $args = array( 
                'location'      => $location,
                'post_type'     => 'event-items',
                'orderby'       => 'meta_value', 
                'meta_key'      => 'mfei_start',
                'order'         => 'asc',
                'posts_per_page'=> '30',
                'meta_query' => array(
                    array(
                        'key'   => 'mfei_day',
                        'value' => 'Saturday'
                   )
                )
                );
            $query = new WP_Query( $args );
            wp_cache_set( $location . '_saturday_schedule', $query, '', 300 );
        }

        $output .= '<h2>Saturday</h1>';
        $output .= '<table style="width:100%;">';
        while ( $query->have_posts() ) : $query->the_post();
            $meta = get_post_meta( get_the_ID());
            $sched_post = get_post( $meta['mfei_record'][0] );
            $json = json_decode( str_replace( "\'", "'", $sched_post->post_content ) );
            $day = ($meta['mfei_day'][0]) ? $meta['mfei_day'][0] : '' ;
            $start = ($meta['mfei_start'][0]) ? $meta['mfei_start'][0] : '';
            $stop = ($meta['mfei_stop'][0]) ? $meta['mfei_stop'][0] : '';

            $output .= '<tr>';
            $output .= '<td width="160" style="max-width:160px; padding:15px 0;" valign="top">';
            $output .= '<h2 style="font-size:.9em; color:#333; margin-top:3px;">' . esc_html( $start ) . ' &mdash; ' . esc_html( $stop ) . '</h2>';
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<h3 style="margin-top:0;">' . get_the_title( $sched_post->ID ) . '</h3>';
            if ( ! empty( $json->presenter_name ) ) {
                $names = $json->presenter_name;
                $names_output = '';
                foreach ( $names as $name ) {
                    $names_output .= ', ' . $name;
                }
                $output .= '<h5 style="margin:5px 0 0; color:#666;">' . substr($names_output, 2) . '</h5>';
            }
            if ( isset( $public_description ) && ! empty( $json->public_description) ) {
                $output .= Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) ) ;
            }
            $output .= '<tr><td colspan="2"><div style="border-bottom:2px solid #ccc;"></div></td></tr>';
            $output .= '</td>';
            $output .= '</tr>';
        endwhile;
        $output .= '</table>';
        wp_reset_postdata();
    } elseif ( isset( $day ) && ($day == 'Sunday' || $day == 'sunday') ) {
        // Roll the schedule for Sunday.
        $query = wp_cache_get( $location . '_sunday_schedule' );
        if( $query == false ) {
            $args = array( 
                'location'      => $location,
                'post_type'     => 'event-items',
                'orderby'       => 'meta_value', 
                'meta_key'      => 'mfei_start',
                'order'         => 'asc',
                'posts_per_page'=> '30',
                'meta_query' => array(
                    array(
                        'key'   => 'mfei_day',
                        'value' => 'Sunday'
                   )
                )
                );
            $query = new WP_Query( $args );
            wp_cache_set( $location . '_sunday_schedule', $query, '', 300 );
        }
        $output .= '<h2 style="margin-top:30px;">Sunday</h1>';
        $output .= '<table class="table table-striped table-bordered" style="width:100%;">';
        while ( $query->have_posts() ) : $query->the_post();
            $meta = get_post_meta( get_the_ID());
            $sched_post = get_post( $meta['mfei_record'][0] );
            $json = json_decode( str_replace( "\'", "'", $sched_post->post_content ) );
            $day = ($meta['mfei_day'][0]) ? $meta['mfei_day'][0] : '' ;
            $start = ($meta['mfei_start'][0]) ? $meta['mfei_start'][0] : '' ;
            $stop = ($meta['mfei_stop'][0]) ? $meta['mfei_stop'][0] : '' ;

            $output .= '<tr>';
            $output .= '<td width="160" style="max-width:160px; padding:15px 0;" valign="top">';
            $output .= '<h2 style="font-size:.9em; color:#666; margin-top:3px;">' . esc_html( $start ) . ' &mdash; ' . esc_html( $stop ) . '</h2>';
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<h3 style="margin-top:0;">' . get_the_title( $sched_post->ID ) . '</h3>';
            if ( isset( $description ) && ! empty( $json->presenter_name ) ) {
                $names = $json->presenter_name;
                $names_output = '';
                foreach ( $names as $name ) {
                    $names_output .= ', ' . $name;
                }
                $output .= '<h5 style="margin:5px 0 0; color:#444;">' . substr($names_output, 2) . '</h5>';
            }
            if ( $public_description == 'set' && !empty($json->public_description)) {
                $output .= Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) ) ;
            }
            $output .= '<tr><td colspan="2"><div style="border-bottom:2px solid #ccc;"></div></td></tr>';
            $output .= '</td>';
            $output .= '</tr>';
            // $output .= '<tr>';
            // $output .= '<td width="150" valign="top">';
            // $output .= '<h5>' . esc_html( $day ) . '</h5>';
            // $output .= '<p>' . esc_html( $start ) . ' &mdash; ' . esc_html( $stop ) . '</p>';
            // $output .= '</td>';
            // $output .= '<td>';
            // $output .= '<h3><a href="' . get_permalink( $sched_post->ID) . '">' . get_the_title( $sched_post->ID ) . '</a></h3>';
            // if ( !empty( $json->presenter_name ) ) {
            //     $names = $json->presenter_name;
            //     $names_output = '';
            //     foreach ( $names as $name ) {
            //         $names_output .= ', ' . $name;
            //     }
            //     $output .= '<h4>' . substr($names_output, 2) . '</h4>';
            // }
            // if (!empty($json->public_description)) {
            //     $content_clean = str_replace('u2014', "&#8212;", $json->public_description );
                
            //     $output .= Markdown( wp_kses_post( $content_clean ) ) ;
            // }
            // $output .= '</td>';
            // $output .= '</tr>';
        endwhile;
        $output .= '</table>';
        wp_reset_postdata();
    } else {
        $output = '<h1>oops! You need to enter the day!</h1><p>Please use http://makerfaire.com/stage-schedule/?location=' . $location . '&day=DAY-HERE to display the day you want</p>';
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
        <title>Stage Signage - <?php echo $location; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <style>
            body { font-family: 'Benton Sans', Helvetica, sans-serif; }
            a { text-decoration:none; color:#000; }
            h1, h2, h3, h4 { margin:5px 0 0; }
        </style>
    </head>
    <body>
        <h1 style="font-size:2.2em; margin:31px 0 0; max-width:75%;"><?php echo $location; ?></h1>
        <?php if ( ! empty( $term->description ) ) {
            echo '<div style="font-weight:normal; margin-top:-15px; margin-left:5px;">' . Markdown( $term->description ) . '</div>';
        } ?>
        <h2 style="position:absolute; top:16px; right:30px;"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" style="width:200px;" alt="" ></h2>
        <p></p>
        <p></p>
        <p></p>
        <?php echo get_schedule_list( $location, $public_description, $day ); ?>
    </body>
</html>
