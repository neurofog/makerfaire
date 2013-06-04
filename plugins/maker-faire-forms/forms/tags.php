<div style="clear:both; height:20px;"></div>
<ul class="columns">
	<?php
		$terms = get_terms( array( 'category', 'post_tag' ), array('hide_empty' => 0, ) );
		if (!empty($terms)) {
			foreach ($terms as $idx => $term) {
				if ( $term->taxonomy == 'post_tag' ) { ?>
					<label class="checkbox"><input name="tag[]" type="checkbox" value="<?php echo esc_attr($term->slug); ?>" <?php checked( in_array( $term->slug, $this->form['tags'] ) ); ?> /> <?php echo esc_html($term->name); ?></label>
				<?php } else { ?>
					<label class="checkbox"><input name="cat[]" type="checkbox" value="<?php echo esc_attr($term->slug); ?>" <?php checked( in_array( $term->slug, $this->form['cats'] ) ); ?> /> <?php echo esc_html($term->name); ?></label>
				<?php } ?>
			<?php }
		}
	?>
</ul>

<div class="clear" style="height:30px;"></div>