<div class="wrapper hide">
<script>

	// Count how many presenters we have listed
	num = <?php echo intval(count($this->form['data[s2][m_maker_name]'])); ?>;

	jQuery(function($)
	{
		$('input[name=data\\[s1\\]\\[food\\]]').click(function() {
			if($(this).val() == 'Yes')
				$('.dp-food').show();
			else
				$('.dp-food').hide();
		});

		$('input[name=data\\[s1\\]\\[sales\\]]').click(function() {
			if($(this).val() == 'Yes')
			{
				$('#size-10x20, #size-other').hide();
				$('.dp-sales').show();
			}
			else
			{
				$('#size-10x20, #size-other').show();
				$('.dp-sales').hide();
			}
		});

		$('input[name=data\\[s1\\]\\[crowdsource_funding\\]]').click(function() {
			if($(this).val() == 'Yes')
				$('.dp-cf').show();
			else
				$('.dp-cf').hide();
		});

		$('input[name=data\\[s1\\]\\[booth_size\\]]').click(function() {
			if($(this).val() == 'Other')
				$('.dp-size').show();
			else
				$('.dp-size').hide();
		});

		$('input[name=data\\[s1\\]\\[power\\]]').click(function() {
			if($(this).val() == 'Yes')
				$('.dp-power').show();
			else
				$('.dp-power').hide();
		});

		$('input[name=data\\[s1\\]\\[radio\\]]').click(function() {
			if($(this).val() == 'Yes')
				$('.dp-radio').show();
			else
				$('.dp-radio').hide();
		});

		$('input[name=data\\[s1\\]\\[fire\\]], input[name=data\\[s1\\]\\[hands_on\\]]').click(function() {
			if($('input[name=data\\[s1\\]\\[fire\\]]:checked').val() == 'Yes' || $('input[name=data\\[s1\\]\\[hands_on\\]]:checked').val() == 'Yes')
				$('.dp-safety').show();
			else
				$('.dp-safety').hide();
		});

		$('input[name=data\\[s1\\]\\[org_type\\]]').click(function() {
			if($(this).val() == 'Non-profit' || $(this).val() == 'Cause or mission-based organization')
				$('.dp-nfp').show();
			else
				$('.dp-nfp').hide();

			if($(this).val() == 'Established company or commercial entity')
				$('.dp-company').show();
			else
				$('.dp-company').hide();
		});

		$('input[name=data\\[s1\\]\\[booth_location\\]]').click(function() {
			if( $(this).val() === 'Either' || $(this).val() === 'Outside' )
				$('.dp-location').show();
			else
				$('.dp-location').hide();
		});

		$('input[name=data\\[s2\\]\\[maker\\]]').click(function() {

			$('#single-maker, #m-maker, #group-maker').hide();

			if($(this).val() == 'One maker')
				$('#single-maker').show();
			else if($(this).val() == 'A list of makers')
				$('#m-maker').show();
			else
				$('#group-maker').show();
		});

		$('#add-maker').click(function() {

            // increase our number yo
            num++;

            new_maker = $('#m-maker-inner > .maker:first').clone();

            // Clear the values for our cloned maker
            $('input, textarea', new_maker).val('');

            // Replace the array key for the new maker with a higher number
            $('input, textarea', new_maker).each(function() {
                name = $(this).attr('name');
                name = name.replace(/\[[0-9]\]/g, '[' + num + ']');

                $(this).attr('name', name);
            });

            // Remove all the extra fields if an image is already present
            $('.maker-photo', new_maker).remove();

            // After all of that, let's add our new maker
            $('#m-maker-inner').append(new_maker);

            // Add our delete button
            $(new_maker).prepend('<div class="del">[x] delete</div>');

            // Delete our maker if we click the button, this is needed for the newly created elements
            $('.maker .del').click(function() {
                $(this).parent().remove();
            });
        });

        // Delete our maker if we click the button
        $('.maker .del').click(function() {
            $(this).parent().remove();
        });

	});
</script>

<!--[if lt IE 9]>
	<div class="ms-error">
		<p>This form does not support IE8 and lower. Please upgrade to a new version of <a href="http://windows.microsoft.com/ie" target="_blank">Internet Explorer</a> or use <a href="http://www.google.com/chrome" target="_blank">Google Chrome</a>, <a href="http://www.firefox.com/" target="_blank">Mozilla Firefox</a>, <a href="http://www.apple.com/safari/" target="_blank">Safari</a> or <a href="http://www.opera.com/" target="_blank">Opera</a> to fill out your application.</p>
	</div>
	<div class="ms-ie8-below">
<![endif]-->
<div class="mf-breadcrumbs">
	<div>1</div>
    <div>2</div>
    <div>3</div>
    <div>4</div>
</div>

<h1 class="mf-not-loggedin-header hide-if-js"><?php _e('You Must Have JavaScript Enabled and Be Logged In to Complete This Application.');?></h1>
<form action="/wp-admin/admin-ajax.php" method="post" class="mf-form hide-if-no-js">
	<?php wp_nonce_field('mf_nonce', 'mf_submit_nonce'); ?>
    <input id="form_type" name="form" type="hidden" value="exhibit" />
    <input name="maker_faire" type="hidden" value="<?php echo esc_attr($this->form['maker_faire']); ?>" />
    <input id="step" name="step" type="hidden" value="1" />
    <input id="id" name="id" type="hidden" value="<?php echo esc_attr($this->form['id']); ?>" />
    <input id="uid" name="uid" type="hidden" value="<?php echo esc_attr($this->form['uid']); ?>" />
	<input name="action" type="hidden" value="mfform_step" />

    <!--STEP 1-->
    <div class="step" id="step1">
        <h1>Step 1 of 4: Project Details</h1>
        <div class="info">* Indicates a required field.</div>
        <hr />

        <div class="input">
            <label>Project Name *</label>
            <div class="info">Provide a short, catchy name for your project. Response limited to 50 characters</div>
            <?php $this->text( 'data[s1][project_name]', array( 'maxlength'=>50 ) ); ?>
        </div>

        <div class="input">
            <label>Tell us about your project *</label>
            <div class="info">For the Maker Faire team, explain what your project is and describe what you will actually be bringing to Maker Faire. This information will <u>not</u> be made public. Be as descriptive as possible.</div>
            <?php $this->textarea('data[s1][private_description]', array('class'=>'mf-extra-tall')); ?>
        </div>

        <h2>Public Project Info:</h2>
		<div class="info">This information will be public and will appear on your exhibit sign, our website and our mobile app.</div>

		<div class="input">
            <label>Short Project Description *</label>
            <div class="info">We need a short, concise description. Limited to 225 characters.</div>
             <?php $this->textarea('data[s1][public_description]', array('maxlength'=>225)); ?>
        </div>

        <div class="input">
            <label>Project Photo *</label>
            <div class="info">File must be at least 500px wide or larger. PNG, JPG or GIF formats only.</div>
            <?php $this->file('data[s1][project_photo]', 'project_photo'); ?>
        </div>

		<div class="input">
            <label>Project Website</label>
            <div class="info">Example: http://www.mygreatproject.com/</div>
            <?php $this->text('data[s1][project_website]'); ?>
        </div>

        <div class="input">
            <label>Project Video</label>
            <div class="info">Example: http://www.youtube.com/watch?v=RD_JpGgUFQQ</div>
            <?php $this->text('data[s1][project_video]'); ?>
         </div>

		<div class="input">
            <label>Will you be giving away, selling, or sampling food (packaged or unpackaged) at Maker Faire? *</label>
            <div class="info">Including food in your exhibit may require a Health Permit. Details will be emailed to you after acceptance.</div>
            <?php $this->radio('data[s1][food]', array('Yes', 'No')); ?>
        </div>

        <div class="input dp-food <?php echo esc_attr((strpos($this->form['data[s1][food]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>Describe what type of food and any details.</label>
            <?php $this->textarea('data[s1][food_details]'); ?>
        </div>

        <div class="input">
            <label>Are you a: *</label>
            <?php $this->radio('data[s1][org_type]', array('Non-profit', 'Cause or mission-based organization', 'Established company or commercial entity', 'None of the above')); ?>
        </div>

        <!-- If non-profit or cause/mission -->
		<div class="input dp-nfp <?php echo esc_attr((strpos($this->form['data[s1][booth_size]'], 'profit') !== false || strpos($this->form['data[s1][booth_size]'], 'mission') !== false ? '' : 'h')); ?>">
            <label>If your organization is a large non-profit or cause or mission-based organization, please tell us more about why you want to come to Maker Faire.</label>
            <div class="info">Large non-profits and cause/mission based organizations qualify for reduced exhibit rates based on their organization’s annual budget. Please list your annual budget below, complete the rest of this form, and the Maker Faire team will contact you with details. This statement does not apply to makerspaces or hackerspaces, which receive free exhibit space at Maker Faire.</div>
            <?php $this->textarea('data[s1][large_non_profit]'); ?>
        </div>

		<!-- If company -->
		<div class="dp-company <?php echo esc_attr((strpos($this->form['data[s1][booth_size]'], 'company') !== false ? '' : 'h')); ?>">Established companies and commercial entities do not qualify for free exhibit space, which is what this application form is for. We have great opportunities available at Maker Faire for companies, please visit <a href="http://makerfaire.com/sponsors/">our sponsors page</a>. Please do not complete the rest of this form.</div>

		<div class="input">
            <label>Will you be selling or marketing a product at Maker Faire?</label>
            <?php $this->radio('data[s1][sales]', array('Yes', 'No')); ?>
        </div>
        <div class="input dp-sales <?php echo esc_attr((strpos($this->form['data[s1][sales]'], 'Yes') !== false ? '' : 'h')); ?>">
        	<div class="info">
                <p>If you would like to sell or market your own creations at Maker Faire, you are a “Commercial Maker”. Due to high demand, we have a limited amount of Commercial Maker space available. If accepted, a Commercial Maker Fee of $425 is due on September 5.</p>
                <p>All Commercial Maker spaces are tabletop or 10x10 spaces and include 1 table and 2 chairs. Additional tables, chairs and power can be purchased after acceptance during the payment process. Please continue to fill out this form.</p>
                <p>Established companies do not qualify as Commercial Makers. We have great opportunities available at Maker Faire for companies. Do not fill out this form, please visit <a href="http://makerfaire.com/sponsors/">our sponsors page</a>.</p></div>
            <label>What product will you be selling or marketing?</label>
            <div class="info">Describe and list the price range of your product(s).</div>
            <?php $this->textarea('data[s1][sales_details]'); ?>
        </div>

        <div class="input">
        	<label>At Maker Faire, will you solicit any crowdfunding (Kickstarter, Indiegogo, etc?)</label>
        	<?php $this->radio( 'data[s1][crowdsource_funding]', array( 'Yes', 'No' ) ); ?>
        </div>

		<div class="input dp-cf <?php echo esc_attr( ( strpos( $this->form['data[s1][solicit]'], 'Yes' ) !== false ? '' : 'h' ) ); ?>">
			<label>Please provide a link to your campaign, tell us more about how you plan to promote at Maker Faire, and provide the launch date or campaign window.</label>
			<?php $this->textarea( 'data[s1][cf_details]' ); ?>
		</div>

		<div class="input">
            <label>Space Size Request * </label>
            <div><input name="data[s1][booth_size]" type="radio" value="Mobile" <?php checked($this->form['data[s1][booth_size]'] == 'Mobile'); ?> /> My exhibit is mobile (no fixed exhibit space needed)</div>
            <div><input name="data[s1][booth_size]" type="radio" value="Tabletop" <?php checked($this->form['data[s1][booth_size]'] == 'Tabletop'); ?> /> Tabletop</div>
			<div><input name="data[s1][booth_size]" type="radio" value="10x10" <?php checked($this->form['data[s1][booth_size]'] == '10x10'); ?> /> 10' x 10'</div>
			<div id="size-10x20"><input name="data[s1][booth_size]" type="radio" value="10x20" <?php checked($this->form['data[s1][booth_size]'] == '10x20'); ?> /> 10' x 20'</div>
			<div id="size-other"><input name="data[s1][booth_size]" type="radio" value="Other" <?php checked($this->form['data[s1][booth_size]'] == 'Other'); ?> /> Other - Tell us your space size request below</div>
            <div class="info dp-sales h">Makers who are selling or marketing products are considered Commercial Makers and can only have a mobile, tabletop or 10x10 space for the standard $425 fee. 10x20 spaces or larger are available for sponsors of Maker Faire. Please visit <a href="http://makerfaire.com/sponsors/">our sponsors page</a> for more information.</div>
        </div>

		<div class="input dp-size <?php echo esc_attr((strpos($this->form['data[s1][booth_size]'], 'Other') !== false ? '' : 'h')); ?>">
            <label>Space Requirements *</label>
            <div class="info">Tell us the dimensions of your required space.</div>
            <?php $this->textarea('data[s1][booth_size_details]'); ?>
        </div>

		<div class="input">
            <label>Tables and Chairs *</label>
            <div class="info">Exhibits are typically allocated 1 table and 2 chairs.</div>
            <?php $this->radio('data[s1][tables_chairs]', array('None'=>'No tables or chairs needed', 'Standard'=>'1 table and 2 chairs', 'Special'=>'More than 1 table and 2 chairs. Specify your request below')); ?>
        </div>

		<div class="input">
            <label>Special setup requests and additional table and chair needs</label>
			<div class="info">If you require additional tables or chairs, list total quantities below.</div>
            <?php $this->textarea('data[s1][tables_chairs_details]'); ?>
        </div>

		<div class="input">
            <label>Layout</label>
            <div class="info">Layouts are optional but can be helpful in our planning. To upload later, submit your application now, then login to your maker account and edit your application to upload your layout.</div>
            <?php $this->file('data[s1][layout]', 'layout'); ?>
		</div>

		<div class="input">
            <label>Do you have a hands-on activity for attendees?</label>
            <?php $this->radio('data[s1][activity]', array('Yes', 'No')); ?>
            <div class="info">If yes, please include a description of your hands-on activity in answer to the second question above, “Tell us about your project”.</div>
        </div>

		<div class="input">
            <label>Placement Request</label>
			<div class="info">Is there an exhibit or group you are affiliated with or a subject area you would like to be placed with at Maker Faire?</div>
            <?php $this->textarea('data[s1][placement]'); ?>
        </div>

		<div class="input">
            <label>Location *</label>
            <div class="info">Most exhibits requesting inside space will be placed outside under large tents. Inside spaces are very limited and not uniformly shaped.</div>
            <?php $this->radio('data[s1][booth_location]', array('Inside', 'Outside', 'Either')); ?>
        </div>

		<div class="input dp-location <?php echo esc_attr((strpos($this->form['data[s1][booth_location]'], 'Inside') !== false ? '' : 'h')); ?>">
            <label>For outdoor exhibits, please mark all options that could work for you.</label>
            <?php $this->checkbox('data[s1][booth_options]', array('With other Makers under a large tent', 'Open air', 'I can bring a tent/canopy with weights', 'Asphalt', 'Grass')); ?>
        </div>

		<div class="input">
            <label>Lighting *</label>
            <?php $this->radio('data[s1][lighting]', array('Normal', 'Dark')); ?>
        </div>

		<div class="input">
            <label>Noise *</label>
            <?php $this->radio('data[s1][noise]', array('Normal - does not interfere with normal conversation', 'Amplified - adjustable level of amplification', 'Repetitive or potentially annoying sound', 'Loud!')); ?>
        </div>

		<div class="input">
            <label>Electrical Requirements *</label>
            <div class="info">Does your exhibit require an external power source?</div>
            <?php $this->radio('data[s1][power]', array('Yes', 'No')); ?>
        </div>

		<div class="input dp-power <?php echo esc_attr((strpos($this->form['data[s1][power]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>What are you powering?</label>
            <?php $this->textarea('data[s1][what_are_you_powering]'); ?>
        </div>

		<div class="input dp-power <?php echo esc_attr((strpos($this->form['data[s1][power]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>How much amperage do you need?</label>
			<div class="info">To ensure you have adequate power onsite, it's essential we know the amount you need in advance.<br />To find the total amperage you require, find the amperage listing on the back of each piece of equipment you plan to use onsite and add up the amps from each item.  <br />
			&nbsp;- All options below are for a 120V circuit (normal US house circuit.) <br />
			&nbsp;- If you require a 208V or 240V circuit, explain your requirements in the comment box provided.
            </div>
            <?php $this->radio('data[s1][amps]', array('5 amp circuit (0-500 watts, 120V)', '10 amp circuit (501-1000 watts, 120V)', '15 amp circuit (1001-1500 watts, 120V)', '20 amp circuit (1501-2000 watts, 120V)', 'My exhibit requires power, but I need help determining my total power amperage', 'Special power requirements noted below')); ?>
        </div>

		<div class="input dp-power <?php echo esc_attr((strpos($this->form['data[s1][power]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>Special requirements: total amperage and any additional details</label>
            <?php $this->textarea('data[s1][amps_details]'); ?>
        </div>

		<div class="input">
            <label>Internet Requirement *</label>
            <?php $this->radio('data[s1][internet]', array('No internet access needed', 'It would be nice to have WiFi internet access', 'My exhibit must have WiFi internet access to work')); ?>
        </div>

		<div class="input">
            <label>Radio Frequencies *</label>
            <div class="info">Does your exhibit use or disrupt radio frequencies?</div>
            <?php $this->radio('data[s1][radio]', array('Yes', 'No')); ?>
        </div>

		<div class="input dp-radio <?php echo esc_attr((strpos($this->form['data[s1][radio]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>My exhibit uses: (check all that apply)</label>
            <?php $this->checkbox('data[s1][radio_frequency]', array('Remote Control (enter frequency band below)', 'Robots', 'Drones', 'Amateur radio or CB', 'ZigBee on 900 MHz', 'ZigBee on 2.4 GHz', 'Telepathy', 'Bluetooth', 'WiFi Internet access', 'My own local WiFi cloud on 2.4 GHz', 'My own local WiFi cloud on 5 GHz (discouraged)', 'I would use a private WiFi cloud if you provided one', 'Something else on 900 MHz', 'Something else on 2.4 GHz', 'Something else on 5 GHz (discouraged, please explain below)', 'Something with an antenna, but I have no idea what')); ?>
        </div>

		<div class="input dp-radio <?php echo esc_attr((strpos($this->form['data[s1][radio]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>Describe additional details of your RF use</label>
            <?php $this->textarea('data[s1][radio_details]'); ?>
        </div>

		<h2>Safety</h2>
		<div class="info"></div>

		<div class="input">
            <label>Does your exhibit contain fire (any size flame), chemicals, or other dangerous materials or tools (propane, welders, etc)?</label>
            <?php $this->radio('data[s1][fire]', array('Yes', 'No')); ?>
        </div>

		<div class="input">
            <label>Do you have an interactive exhibit, including using tools of any kind, riding (bikes, go carts, swings, etc), climbing, etc?</label>
            <?php $this->radio('data[s1][hands_on]', array('Yes', 'No')); ?>
        </div>

        <div class="input dp-safety <?php echo esc_attr(($this->form['data[s1][fire]'] == 'Yes' || $this->form['data[s1][hands_on]'] == 'Yes'  ? '' : 'h')); ?>">
            <label>Describe any fire or safety issues</label>
            <?php $this->textarea('data[s1][safety_details]'); ?>
        </div>

    </div>
    <!--STEP 1 END-->

	<!--STEP 2-->
    <div class="step" id="step2">
        <h1>Step 2 of 4: Maker Information</h1>
        <div class="info">* Indicates a required field.</div>
        <hr />
        <div class="information">
            <div class="info">The Maker Information below is specific to your Maker Faire Application. Changes you make will not affect your Maker Profile.</div>
			<div class="information-inner">
                <div class="input">
                    <label>Contact Name</label>
                    <input type="text" class="default-name" name="data[s2][name]" value="<?php echo esc_attr($this->form['data[s2][name]']); ?>" />
                </div>

                <div class="input">
					<label>Contact Email *</label>
                    <div class="info">This is the email address we will send all acceptance and logistical email to - please make sure you type it in carefully.</div>
                    <?php $this->text('data[s2][email]', array('class'=>'default-email')); ?>
				</div>
				<div class="input">
					<label>Who would you like listed as the maker of the project? *</label>
                    <?php $this->radio('data[s2][maker]', array('One maker', 'A list of makers','A group or association' )); ?>
				</div>

				<!-- OPTION 1 - SINGLE MAKER -->
                <div id="single-maker" class="<?php echo esc_attr((strpos($this->form['data[s2][maker]'], 'One') !== false ? '' : 'h')); ?>">
                	<label>One Maker</label>
                    <div class="info">This name, bio and photo will appear on your exhibit sign and on our website.</div>
                    <div class="input">
                        <label>Maker Name *</label>
                        <?php $this->text('data[s2][maker_name]', array('class'=>'default-name')); ?>
                    </div>
                    <div class="input">
                        <label>Maker Email *</label>
                        <?php $this->text('data[s2][maker_email]', array('class'=>'default-email')); ?>
                    </div>
                    <div class="input">
                        <label>Maker Bio *</label>
                        <div class="info">Limited to 200 characters or less.</div>
                         <?php $this->textarea('data[s2][maker_bio]', array('maxlength'=>200, 'class'=>'default-bio')); ?>
                    </div>
                    <div class="input">
                        <label>Maker Twitter Handle</label>
                        <div class="info">Enter your twitter username (e.g. @makerfaire).</div>
                        <?php $this->text( 'data[s2][maker_twitter]' ); ?>
                    </div>
                    <div class="input">
                        <label>Maker Photo *</label>
                        <div class="info">File must be at least 500px wide or larger. PNG, JPG or GIF formats only.</div>
                        <?php $this->file('data[s2][maker_photo]', 'maker_photo'); ?>
                    </div>

				</div>
				<!-- OPTION TWO: MAKER TEAM -->
                <div id="m-maker" class="<?php echo esc_attr((strpos($this->form['data[s2][maker]'], 'list') !== false ? '' : 'h')); ?>">
                	<label>A List of Makers</label>
                    <div class="info">These names, bio and photo will appear on the Maker Faire website and mobile app.</div>
                    <div id="m-maker-inner">
                    	<?php for($i=0; $i < count($this->form['data[s2][m_maker_name]']); $i++ ) : ?>
	                    	<div class="maker">
	                        	<?php if($i) : ?><div class="del">[x] delete</div><?php endif; ?>
	                            <div class="input">
	                                <label>Maker Name *</label>
	                                <input type="text" class="default-name"  name="data[s2][m_maker_name][<?php echo esc_attr(($i + 1)); ?>]" value="<?php echo esc_attr($this->form['data[s2][m_maker_name]'][$i]); ?>" />
	                            </div>
	                            <div class="input">
	                                <label>Maker Email *</label>
	                                <input type="text" class="default-email"  name="data[s2][m_maker_email][<?php echo esc_attr(($i + 1)); ?>]" value="<?php echo esc_attr($this->form['data[s2][m_maker_email]'][$i]); ?>" />
	                            </div>
	                            <div class="input">
	                                <label>Maker Bio *</label>
	                                <div class="info">This bio will appear on the Maker Faire website and mobile app. Limited to 200 characters.</div>
	                                <textarea name="data[s2][m_maker_bio][<?php echo esc_attr(($i + 1)); ?>]" maxlength="200" class="default-bio"><?php echo esc_html($this->form['data[s2][m_maker_bio]'][$i]); ?></textarea>
	                            </div>
	                            <div class="input">
			                        <label>Maker Twitter Handle</label>
			                        <div class="info">Enter your twitter username (e.g. @makerfaire).</div>
			                        <input type="text" name="data[s2][m_maker_twitter][<?php echo esc_attr(($i + 1)); ?>]" value="<?php echo esc_attr($this->form['data[s2][m_maker_twitter]'][$i]); ?>" />
			                    </div>
	                            <?php if($i == 0) : ?>
		                            <div class="input maker-photo">
		                                <label>Maker Photo *</label>
		                                <div class="info">File must be at least 500px wide or larger. PNG, JPG or GIF formats only.</div>
		                                <?php $this->file('data[s2][m_maker_photo]', 'm_maker_photo'); ?>
		                            </div>
	                            <?php endif; ?>
	                        </div>
                        <?php endfor; ?>
                    </div>
                    <div id="add-maker">+ Add Maker</div>
				</div>

				<!-- We need to have the option to create multiple makers -->

				<!-- OPTION THREE: GROUP/ASSOCIATION -->
                <div id="group-maker" class="<?php echo esc_attr((strpos($this->form['data[s2][maker]'], 'group') !== false ? '' : 'h')); ?>">
                	<h2>A Group or Association</h2>
                    <div class="info">This name, bio and photo will appear on the Maker Faire website and mobile app.</div>
                    <div class="input">
                        <label>Group Name *</label>
                        <?php $this->text('data[s2][group_name]'); ?>
                    </div>

                    <div class="input">
                        <label>Group Bio *</label>
                        <div class="info">Limited to 200 characters or less.</div>
                        <?php $this->textarea('data[s2][group_bio]', array('maxlength'=>200)); ?>
                    </div>

                    <div class="input">
                        <label>Group Photo *</label>
                        <div class="info">File must be at least 500px wide or larger. PNG, JPG or GIF formats only.</div>
                        <?php $this->file('data[s2][group_photo]', 'group_photo'); ?>
                    </div>

                    <div class="input">
                        <label>Group Website</label>
                        <div class="info">Example: http://www.groupwebsite.com/</div>
                        <?php $this->text('data[s2][group_website]'); ?>
                    </div>

                    <div class="input">
                        <label>Group Twitter Handle</label>
                        <div class="info">Enter your groups twitter username (e.g. @makerfaire).</div>
                        <?php $this->text( 'data[s2][group_twitter]' ); ?>
                    </div>
                </div>
				<h2 style="margin-bottom:20px;">Private Contact Information <small>(for Maker staff use only)</small></h2>
                <div class="input">
                    <label>Contact Phone Number *</label>
                    <?php $this->text('data[s2][phone1]', array('class'=>'mf-extra-short')); ?> <?php $this->select('data[s2][phone1_type]', array('mobile'=>'Mobile', 'home'=>'Home', 'work'=>'Work', 'other'=>'Other')); ?>
                </div>

                <div class="input">
                    <label>Second Phone Number</label>
                    <?php $this->text('data[s2][phone2]', array('class'=>'mf-extra-short')); ?> <?php $this->select('data[s2][phone2_type]', array('mobile'=>'Mobile', 'home'=>'Home', 'work'=>'Work', 'other'=>'Other')); ?>
                </div>

                <?php include('address.php'); ?>

            </div>
		</div>
	</div>
    <!--STEP 2 END-->

    <!--STEP 3-->
    <div class="step" id="step3">
        <h1>Step 3 of 4: Additional Details</h1>
        <hr />

		<h2>Topics</h2>
        <h3>To help people find your exhibit on our website and at Maker Faire, please select a maximum of 5 topics below which apply to your project.</h3>
        <?php include('tags.php'); ?>

        <div class="input">
			<label>Optional: Upload additional supporting documents.</label>
            <div class="info">Upload anything else related to your exhibit you'd like to share with us.</div>
            <?php $this->file('data[s3][supporting_documents]', 'supporting_documents'); ?>
		</div>

		<div class="input">
            <label>Reference(s)</label>
            <div class="info">Who is familiar with you, your exhibit or other things you have made? Were you referred to Maker Faire or asked to fill out this application? If so, who referred you?</div>
			 <?php $this->textarea('data[s3][references]'); ?>
        </div>

		<div class="input">
			<label>Are there other organizations or makers you recommend we contact about participating in Maker Faire?</label>
            <?php $this->text('data[s3][referrals]'); ?>
		</div>

		<div class="input">
			<label>How did you hear about Maker Faire?</label>
            <?php $this->text('data[s3][hear_about]'); ?>
		</div>

		<div class="input">
            <label>If you are accepted, will this be your first time participating in Maker Faire? *</label>
            <?php $this->radio('data[s3][first_time]', array('Yes', 'No')); ?>
        </div>

		<div class="input">
			<label>Is there anything else you would like to tell us?</label>
            <?php $this->textarea('data[s3][anything_else]'); ?>
		</div>

	</div>
    <!--STEP 3 END-->

    <!--STEP 4-->
    <div class="step" id="step4">
        <h1>Step 4 of 4: Review and Submit</h1>
        <hr />
        <p style="font-weight:bold">Review your application below.</p>
        <p style="font-weight:bold">To return to your application and edit click on the section numbers above. DO NOT hit the back button on your browser.</p>
        <p style="font-weight:bold">Your application is not complete until you click the “Submit Application” button below.</p>
        <p>After submitting your application, you can update it anytime until the application deadline.</p>
        <p>Entries are reviewed after the application deadline. If we accept your exhibit, we have accepted your concept. Acceptance does not guarantee that we can accommodate all of your requests. What we can provide will be confirmed in a follow-up letter before the event.</p>
	</div>
    <!--STEP 4 END-->

    <!--STEP 5-->
    <div class="step" id="step5">
        <h1 style="color:red">Thank you!</h1>
        <hr />
        <p>Thanks for your interest in participating in Maker Faire.</p>
        <p style="font-weight:bold;">Important: Add makers@makerfaire.com to your contact list.</p>
        <p>We will be sending all updates from that address, and adding us will prevent our messages from getting caught in spam.</p>
		<p>Your application has been received. We're emailing you a confirmation right now.</p>
        <p>If you don't receive the confirmation:</p>
        <ul>
        	<li>Check your spam folder.</li>
        	<li>Add makers@makerfaire.com to your contact list.</li>
            <li>Check to be sure you entered the correct address in your entry form. All future communications will be directed to the email address you provided. To check, select "Your Account" in the header above and click on the link to your application. The contact email you provided is in Step 2.</li>
        </ul>
		<p>Stay tuned for more information about participating in Maker Faire!</p>
		<p><a class="btn btn-large" href="<?php echo home_url(); ?>/makerprofile/">Preview your Profile</a></p>
	</div>
    <!--STEP 6 END-->
	<div class="review" style="display:none; position:relative;">
        <input type="button" class="mf-edit-app" value="Edit Application" />
        <div class="ajax-loader save" style="display:none; position:absolute; left:112px; top:0;">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ajax-loader.gif" alt="Loading..."> Saving Application...
        </div>
        <input type="submit" class="submitt-app" value="Submit Application" />
        <h1 style="margin:20px 0">Your Application:</h1>
        <div class="inner"></div>
    </div>
    <div class="ajax-loader" style="display:none;">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ajax-loader.gif" alt="Loading..."> Loading Next Step...
    </div>
    <input type="button" class="mf-edit-app" value="Edit Application" /><input type="submit" value="Continue" /><br />
    <div class="info">
        If you experience problems with this form, email <a href="mailto:webmaster@makerfaire.com">webmaster@makerfaire.com</a>.
    </div>
</form>

<!--[if lt IE 9]>
	</div>
<![endif]-->
</div>
