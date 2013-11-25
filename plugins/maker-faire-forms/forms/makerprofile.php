<div class="mf-editforms">
    <div style="float:left; margin-right:10px;">
	   <img class="maker-image" src="<?php echo esc_url(get_template_directory_uri().'/plugins/maker-faire-forms/assets/i/default-profile-image.jpg'); ?>" />
	</div>
    <div style="float:left; width:500px">
        <h2 class="maker-name"></h2>
        <a href="#" onclick="gigya.accounts.showScreenSet({screenSet:'Profile-web'});" />Edit Profile</a>
    </div>
    <div class="clear"></div><br /><br />
    
	<a href="<?php echo esc_url( home_url( '/newyork-2013-call-for-makers/' ) ); ?>"><input type="button" value="Apply for Maker Faire" /></a>
	
    
	<h3 style="margin-top:30px;">Your Current Applications</h3>
    <hr />

    <div id="exhibit">
        <h3 style="font-size:13px"><strong>EXHIBIT APPLICATIONS</strong></h3>
        <div class="loading"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ajax-loader.gif" alt=""> Loading Applications...</div>
        <ul></ul>
    </div>
	
    <div id="presenter">
        <h3 style="font-size:13px"><strong>PRESENTER APPLICATIONS</strong></h3>
        <div class="loading"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ajax-loader.gif" alt=""> Loading Applications...</div>
        <ul></ul>
    </div>
    
    <div id="performer">
        <h3 style="font-size:13px"><strong>PERFORMER APPLICATIONS</strong></h3>
        <div class="loading"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ajax-loader.gif" alt=""> Loading Applications...</div>
        <ul></ul>
    </div>
    
</div>