<?php get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<?php
				$faire = ( isset( $_GET['faire'] ) && ! empty( $_GET['faire'] ) ) ? sanitize_title( $_GET['faire'] ) : MF_CURRENT_FAIRE;

				echo do_shortcode( '[mf_schedule_by_location location_id="' . get_the_ID() . '" faire="' . $faire . '"]' );
			?>

		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>

</div><!--Container-->

<?php get_footer(); ?>