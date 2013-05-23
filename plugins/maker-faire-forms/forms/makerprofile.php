<div class="mf-editforms">
    <div style="float:left; margin-right:10px;">
	<img class="maker-image" src="<?php echo esc_url(get_template_directory_uri().'/plugins/maker-faire-forms/assets/i/default-profile-image.jpg'); ?>" />
	</div>
    <div style="float:left; width:500px">
    <h2 class="maker-name"><span></span> <span></span></h2>
	<div class="bio"></div><br />
    <a href="#" onclick="gigya.accounts.showScreenSet({screenSet:'MakerFaire-Profile', onAfterSubmit:mf_update_profile});" />Edit Profile</a>
    </div>
    <div class="clear"></div><br /><br />
	<input type="button" value="Apply for Maker Faire" onclick="document.location = '/bayarea-2013-callformakers';" />
	
    <h3 style="margin-top:30px;">The deadline for Maker entries has passed.</h3>
	<p>You can still apply. We will consider your entry as a last-minute addition.</p>

	<p>If you do not receive an acceptance letter by May 1st, we were not able to find space for your exhibit. We will do our best to notify you before then.</p>
	
	<p>To make changes to your current application(s), use the change forms in the <a href="http://makerfaire.com/bayarea-2013-makertoolkit/">Maker Toolkit</a> under "Helpful Forms".</p>
	<h3 style="margin-top:30px;">Your Current Applications</h3>
    <hr />

    <div id="exhibit">
        <h3 style="font-size:13px"><strong>EXHIBIT APPLICATIONS</strong></h3>
        <ul></ul>
    </div>
	
    <div id="presenter">
        <h3 style="font-size:13px"><strong>PRESENTER APPLICATIONS</strong></h3>
        <ul></ul>
    </div>
    
    <div id="performer">
        <h3 style="font-size:13px"><strong>PERFORMER APPLICATIONS</strong></h3>
        <ul></ul>
    </div>
    
</div>