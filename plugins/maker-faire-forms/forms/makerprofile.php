<div class="mf-editforms hide">
    <div style="float:left; margin-right:10px;">
	   <img class="maker-image" src="<?php echo esc_url(get_template_directory_uri().'/plugins/maker-faire-forms/assets/i/default-profile-image.jpg'); ?>" />
	</div>
    <div style="float:left; width:500px">
        <h2 class="maker-name"></h2>
        <a href="#" onclick="gigya.accounts.showScreenSet({screenSet:'MakerFaire-Profile'});" />Edit Profile</a>
    </div>

<div class="clear"></div><br /><br />
        <p><strong>The deadline for Maker entries has passed.</strong> However, there are several ways that you can still participate!:</p>

        <ol>
            <li><strong>We will consider your entry as a last-minute addition.</strong> Apply late by clicking the red button below. If you do not receive an acceptance letter by September 5, we were not able to find space for your exhibit. We will do our best to notify you before then.</li>
            <li>If you would like to volunteer your time and make an invaluable contribution to the success of Maker Faire, please sign up for our <a href="http://makerfaire.com/new-york-2014/traveler-program/">Maker Faire Traveler Program</a>, which is a platform to enhance your skills and learn about the Maker Movement. You will have a behind-the-scenes experience, and help make the Greatest Show (and Tell) on Earth happen! <a href="http://makerfaire.com/new-york-2014/traveler-program/">Learn more here</a>.</li>
            <li>Plan to come as an attendee, enjoy the show and support the Maker movement by <a href="https://makerfaireny2014.eventbrite.com/" target="_blank">purchasing your tickets early!</a></li>
        </ol>

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
