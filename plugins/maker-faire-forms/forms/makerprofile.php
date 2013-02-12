<div class="mf-editforms">
    <div style="float:left; margin-right:10px;">
	<img class="maker-image" src="<?php echo esc_url(get_template_directory_uri().'/plugins/maker-faire-forms/assets/i/default-profile-image.jpg'); ?>" />
	</div>
    <div style="float:left">
    <h2 class="maker-name"><span></span> <span></span></h2>
	<div class="bio"></div><br />
    <a href="#" onclick="gigya.accounts.showScreenSet({screenSet:'MakerFaire-Profile', onAfterSubmit:mf_update_profile});" />Edit Profile</a>
    </div>
    <div class="clear"></div><br /><br />
	<input type="button" value="Apply for Maker Faire" onclick="document.location = '/bayarea-2013-callformakers';" />
    <h1 style="margin-top:30px;">Edit Your Maker Faire Applications</h1>
    <hr />
    <?php foreach($forms as $type=>$set) : ?>
    <div id="exhibit">
        <h3><strong><?php echo esc_html(strtoupper($type));?> APPLICATIONS</strong></h3>
        <ul>
        <?php foreach($set as $f) : ?>
        <li><a href="<?php echo esc_url('/'.$type.'?id='.$f->ID);?>"><?php echo esc_html($f->ID.' - '.$f->post_title.' ('.($f->post_status == 'mf_pending' ? 'pending' : 'submitted').')');?></a></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endforeach; ?>
</div>