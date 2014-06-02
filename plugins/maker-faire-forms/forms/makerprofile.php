<div class="mf-editforms hide">
    <div style="float:left; margin-right:10px;">
	   <img class="maker-image" src="<?php echo esc_url(get_template_directory_uri().'/plugins/maker-faire-forms/assets/i/default-profile-image.jpg'); ?>" />
	</div>
    <div style="float:left; width:500px">
        <h2 class="maker-name"></h2>
        <a href="#" onclick="gigya.accounts.showScreenSet({screenSet:'MakerFaire-Profile'});" />Edit Profile</a>
    </div>

	<p><a href="<?php echo esc_url( home_url( '/new-york-2014/call-for-makers/' ) ); ?>"><input type="button" value="Apply for Maker Faire" /></a></p>

    <div class="loading">
        <p><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ajax-loader.gif" alt=""> Loading Applications...</p>
    </div>


    <div class="no-applications" style="display:none;">
        <h3>You currently have no new applications! <a href="<?php echo esc_url( home_url( '/new-york-2014/call-for-makers/' ) ); ?>">Apply today!</a></h3>
    </div>


    <div id="current-faire" style="display:none;">
    	<h3 style="margin-top:30px;">Current Applications</h3>
        <hr style="border:0;height:0;border-top:1px solid rgba(0, 0, 0, 0.1);border-bottom:1px solid rgba(255, 255, 255, 0.3);" />

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


    <div id="previous-faire" style="display:none;">
        <hr style="border:0;height:1px;background:#333;background-image:-webkit-linear-gradient(left, #ccc, #333, #ccc);background-image:-moz-linear-gradient(left, #ccc, #333, #ccc);background-image:-ms-linear-gradient(left, #ccc, #333, #ccc);background-image:-o-linear-gradient(left, #ccc, #333, #ccc);">

        <h3>Previous Applications</h3>
        <hr style="border:0;height:0;border-top:1px solid rgba(0, 0, 0, 0.1);border-bottom:1px solid rgba(255, 255, 255, 0.3);" />

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

</div>