<div style="clear:both; height:20px;"></div>
<div class="tag-cluster">
    <h3><input name="cat[]" type="checkbox" value="electronics" <?php checked(in_array('electronics', $this->form['cats'])); ?> /> &nbsp; Electronics</h3>
     <?php 
	 	$cats = get_categories(array('hide_empty'=>false, 'parent'=>19));
	 	foreach($cats as $cat) : ?>
   			<div><input name="cat[]" type="checkbox" value="<?php echo esc_attr($cat->slug); ?>" <?php checked(in_array($cat->slug, $this->form['cats'])); ?> /> &nbsp; <?php echo esc_html($cat->name); ?></div>
    <?php endforeach; ?>
    
    <h3><input name="cat[]" type="checkbox" value="workshop" <?php checked(in_array('workshop', $this->form['cats'])); ?> /> &nbsp; Workshop</h3>
    <?php 
	 	$cats = get_categories(array('hide_empty'=>false, 'parent'=>24));
	 	foreach($cats as $cat) : ?>
   			<div><input name="cat[]" type="checkbox" value="<?php echo esc_attr($cat->slug); ?>" <?php checked(in_array($cat->slug, $this->form['cats'])); ?> /> &nbsp; <?php echo esc_html($cat->name); ?></div>
    <?php endforeach; ?>
    
    <h3><input name="cat[]" type="checkbox" value="craft" <?php checked(in_array('craft', $this->form['cats'])); ?> /> &nbsp; Craft</h3>
    <?php 
	 	$cats = get_categories(array('hide_empty'=>false, 'parent'=>29));
	 	foreach($cats as $cat) : ?>
   			<div><input name="cat[]" type="checkbox" value="<?php echo esc_attr($cat->slug); ?>" <?php checked(in_array($cat->slug, $this->form['cats'])); ?> /> &nbsp; <?php echo esc_html($cat->name); ?></div>
    <?php endforeach; ?>
    
    <h3><input name="cat[]" type="checkbox" value="science" <?php checked(in_array('science', $this->form['cats'])); ?> /> &nbsp; Science</h3>
    <?php 
	 	$cats = get_categories(array('hide_empty'=>false, 'parent'=>34));
	 	foreach($cats as $cat) : ?>
   			<div><input name="cat[]" type="checkbox" value="<?php echo esc_attr($cat->slug); ?>" <?php checked(in_array($cat->slug, $this->form['cats'])); ?> /> &nbsp; <?php echo esc_html($cat->name); ?></div>
    <?php endforeach; ?>

	<h3><input name="cat[]" type="checkbox" value="home" <?php checked(in_array('home', $this->form['cats'])); ?> /> &nbsp; Home</h3>
    <?php 
	 	$cats = get_categories(array('hide_empty'=>false, 'parent'=>37));
	 	foreach($cats as $cat) : ?>
   			<div><input name="cat[]" type="checkbox" value="<?php echo esc_attr($cat->slug); ?>" <?php checked(in_array($cat->slug, $this->form['cats'])); ?> /> &nbsp; <?php echo esc_html($cat->name); ?></div>
    <?php endforeach; ?>
    
    <h3><input name="cat[]" type="checkbox" value="art-design" <?php checked(in_array('art-design', $this->form['cats'])); ?> /> &nbsp; Art & Design</h3>
    <?php 
	 	$cats = get_categories(array('hide_empty'=>false, 'parent'=>43));
	 	foreach($cats as $cat) : ?>
   			<div><input name="cat[]" type="checkbox" value="<?php echo esc_attr($cat->slug); ?>" <?php checked(in_array($cat->slug, $this->form['cats'])); ?> /> &nbsp; <?php echo esc_html($cat->name); ?></div>
    <?php endforeach; ?>

    <h3><input name="cat[]" type="checkbox" value="pro" <?php checked(in_array('pro', $this->form['cats'])); ?> /> &nbsp; Pro</h3>
    <?php 
	 	$cats = get_categories(array('hide_empty'=>false, 'parent'=>45));
	 	foreach($cats as $cat) : ?>
   			<div><input name="cat[]" type="checkbox" value="<?php echo esc_attr($cat->slug); ?>" <?php checked(in_array($cat->slug, $this->form['cats'])); ?> /> &nbsp; <?php echo esc_html($cat->name); ?></div>
    <?php endforeach; ?>
</div>

<div class="tag-cluster">
    <?php 
		$tags = get_tags(array('hide_empty'=>false));
		foreach ($tags as $tag) : ?>
    	<div><input name="tag[]" type="checkbox" value="<?php echo esc_attr($tag->slug); ?>" <?php checked(in_array($tag->slug, $this->form['tags'])); ?> /> &nbsp; <?php echo esc_html($tag->name); ?></div>
    <?php endforeach; ?>
</div>


<div class="clear" style="height:30px;"></div>