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
    
    <p>The deadline for Maker entries has passed. However, there are several ways that you can still participate!:</p>

    <ol>
        <li>We will consider your entry as a last-minute addition. Apply late by clicking the red button below. If you do not receive an acceptance letter by September 1st, we were not able to find space for your exhibit. We will do our best to notify you before then.</li>
        <li>If you would like to volunteer your time and make an invaluable contribution to the success of Maker Faire, please sign up for our <a href="http://makerfaire.com/new-york-2013/maker-corps-program/">Maker Corps at Maker Faire Program</a>, which is a platform to enhance your skills and learn about the Maker Movement. You will have a behind-the-scenes experience, and help make the Greatest Show (and Tell) on Earth happen! Learn more at <a href="http://makerfaire.com/new-york-2013/maker-corps-program/">makerfaire.com</a>.</li>
        <li>Plan to come as an attendee, enjoy the show and support the Maker movement by <a href="http://makerfairenyc.eventbrite.com/">purchasing your tickets</a> early!</li>
        
    </ol>
    
	<input type="button" value="Apply for Maker Faire" onclick="document.location = '/newyork-2013-call-for-makers/';" />
	
    
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