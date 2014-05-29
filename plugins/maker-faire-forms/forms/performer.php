<div class="wrapper hide">
<script>

	jQuery(function($)
	{
		$('input[name=data\\[s1\\]\\[compensation_type\\]]').click(function() {
			$('.dp-amount').hide();

			if($(this).val() == '$ amount')
				$('.dp-amount').show();
		});


        if ( $('form.ms-ie8-below').length === 1 ) {
            $('form.mf-form').remove();
        }
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
    <input id="form_type" name="form" type="hidden" value="performer" />
    <input name="maker_faire" type="hidden" value="<?php echo esc_attr($this->form['maker_faire']); ?>" />
    <input id="step" name="step" type="hidden" value="1" />
    <input id="id" name="id" type="hidden" value="<?php echo esc_attr($this->form['id']); ?>" />
    <input id="uid" name="uid" type="hidden" value="<?php echo esc_attr($this->form['uid']); ?>" />
	<input name="action" type="hidden" value="mfform_step" />

    <!--STEP 1-->
    <div class="step" id="step1">
        <h1>Step 1 of 4: Performer Details</h1>
        <div class="info">* Indicates a required field.</div>
        <hr />

        <div class="input">
            <label>Performer, Band, or Group Name *</label>
            <?php $this->text( 'data[s1][performer_name]' ); ?>
        </div>

        <div class="input">
            <label>Tell us about your performance *</label>
            <div class="info">For the Maker Faire team, describe what your performance is like. If you are a band, include what type of music and where you normally play. This information will not be made public.</div>
            <?php $this->textarea('data[s1][private_description]'); ?>
        </div>

		<h2>Public Performer Info:</h2>
		<div class="info">This information will be public and appear on our website and mobile app.</div>
        <div class="input">
            <label>Short Performer Description *</label>
            <div class="info">We need a short concise description for the website and mobile app. Response limited to 225 characters or less.</div>
            <?php $this->textarea('data[s1][public_description]', array('maxlength'=>225, 'class'=>'mf-shorter-field')); ?>
        </div>

        <div class="input">
            <label>Performer Photo *</label>
            <div class="info">File must be at least 500px wide or larger. PNG, JPG or GIF formats only</div>
            <?php $this->file('data[s1][performer_photo]', 'performer_photo'); ?>
        </div>

		<div class="input">
            <label>Performer Website</label>
            <div class="info">Example: http://www.mygreatband.com/</div>
            <?php $this->text('data[s1][performer_website]'); ?>
        </div>

        <div class="input">
            <label>Performer Video</label>
            <div class="info">Example: http://www.youtube.com/watch?v=RD_JpGgUFQQ</div>
            <?php $this->text('data[s1][performer_video]'); ?>
        </div>

		<h2>Performance Schedule Preference</h2>
		<div>At Maker Faire, we have music and stage performances all weekend! We will do our best to create a balanced schedule, so that there are great acts all day long. Thanks for being flexible about your performance time.
		<br /><br /><em><strong>Maker Faire Hours</strong>
		<br />Saturday, September 20: 10am - 7pm
		<br />Sunday, September 21: 10am - 6pm</em><br /><br /></div>

		<div class="input">
            <label>Which day(s) can you perform? Please pick the option that fits you best. *</label>
            <?php $this->radio('data[s1][performance_time]', array('Saturday Only', 'Sunday Only', 'Either Saturday or Sunday; We\'re flexible but prefer to play only once.', 'Both Saturday and Sunday; We\'d love to play both days if there\'s space and time in the schedule.', 'All Weekend! We have our own separate setup and would like to play all weekend, if possible.')); ?>
        </div>

        <div class="input">
            <label>List any scheduling comments, preferences or conflicts.</label>
            <?php $this->text('data[s1][schedule_comments]'); ?>
        </div>

		<h2>Setup and Equipment Requests</h2>
		<div class="info">We have experienced crew, basic audio support and power at each of our Maker Faire stages. Please include your input list, additional equipment details and any special requests in the box below. If possible, we appreciate you bringing everything you need.</div>

		<div class="input">
            <label>Equipment and Input List</label>
			<div class="info">Please list the equipment you will be bringing and the inputs you need to be able to perform.</div>
            <?php $this->textarea('data[s1][equipment]'); ?>
        </div>

		<div class="input">
            <label>How many performers will be on stage? *</label>
            <?php $this->text('data[s1][performer_count]', array('maxlength'=>3, 'class'=>'mf-extra-extra-small')); ?>
        </div>

		<div class="input">
            <label>Compensation Request</label>
			<div class="info">Our performance budget is extremely limited as Maker Faire is not a music festival. Maker Faire provides publicity, large crowds and excellent opportunities for networking and just having fun. We cannot give you what you might normally make in a club or music festival, but we may be able to help defray some of your costs with a small stipend for your performance. We can also offer you complimentary tickets so you can enjoy the Faire with your family and friends. Below, please let us know what kind of compensation you would like to receive for playing the event, both monetary and number of guest tickets.</div>
            <?php $this->radio('data[s1][compensation_type]', array('Thanks for the opportunity to play! We are happy to play without financial compensation.', 'We will play for guest tickets only.', '$ amount')); ?>
        </div>

		<div class="input dp-amount <?php echo esc_attr((strpos($this->form['data[s1][compensation_type]'], '$') !== false ? '' : 'h')); ?>">
            <label>Compensation Amount *</label>
            $<?php $this->text('data[s1][compensation]', array('maxlength'=>5, 'class'=>'mf-extra-extra-small')); ?>
        </div>

		<div class="input">
            <label>Ticket Request *</label>
			<div class="info">Total should include performers and guests.</div>
            <?php $this->text('data[s1][guest_tickets]', array('maxlength'=>3, 'class'=>'mf-extra-extra-small')); ?>
        </div>

    </div>
    <!--STEP 1 END-->

	<!--STEP 2-->
    <div class="step" id="step2">
        <h1>Step 2 of 4: Contact Information</h1>
        <div class="info">* Indicates a required field.</div>
        <hr />
        <div class="info">The Performer Information below is specific to your Maker Faire Application. Changes you make will not affect your Maker Profile.</div>
		<div class="input">
            <label>Contact Name</label>
            <input type="text" class="default-name" name="data[s2][name]" value="<?php echo esc_attr($this->form['data[s2][name]']); ?>" />
        </div>

        <div class="input">
            <label>Contact Email</label>
            <input type="text" class="default-email" name="data[s2][email]" value="<?php echo esc_attr($this->form['data[s2][email]']); ?>" />
        </div>

		<div class="input">
            <label>Contact Phone Number *</label>
            <?php $this->text('data[s2][phone1]', array('class'=>'mf-extra-short')); ?> <?php $this->select('data[s2][phone1_type]', array('mobile'=>'Mobile', 'home'=>'Home', 'work'=>'Work', 'other'=>'Other')); ?>
        </div>

        <div class="input">
            <label>Second Phone Number</label>
            <?php $this->text('data[s2][phone2]', array('class'=>'mf-extra-short')); ?> <?php $this->select('data[s2][phone2_type]', array('mobile'=>'Mobile', 'home'=>'Home', 'work'=>'Work', 'other'=>'Other')); ?>
        </div>

		<div class="input">
            <label>Onsite Phone Number *</label>
			<div class="info">Please provide a mobile phone number so that we are able to reach the performer onsite during the event if the need arises. This number will only be used by Maker Faire staff.</div>
            <?php $this->text('data[s2][onsite_phone]', array('class'=>'mf-extra-short')); ?>
        </div>

        <?php include('address.php'); ?>


	</div>
    <!--STEP 2 END-->

    <!--STEP 3-->
    <div class="step" id="step3">
        <h1>Step 3 of 4: Additional Details</h1>
        <div class="info">* Indicates a required field.</div>
        <hr />

		<h2>Topics</h2>
		<h3>To help people find your performance on our website and at Maker Faire, please select a maximum of 5 topics below which apply to your project.</h3>

        <?php include('tags.php'); ?>

		<div class="input">
            <label>If you are accepted, will this be your first time participating in Maker Faire?</label>
            <?php $this->radio('data[s3][first_makerfaire]', array('Yes', 'No')); ?>
        </div>

		<label>In addition to your performance, if you're interested in having a related all-weekend exhibit, you can apply for an exhibit space.</label>

		<div class="input">
            <label>Have you already or will you submit an application for a related exhibit?</label>
            <div class="info">If yes, please fill out the exhibit application in addition to submitting this one, and indicate in that form that you have also applied to perform on stage.</div>
			<?php $this->radio('data[s3][exhibit]', array('Yes', 'No')); ?>
        </div>

		<div class="input">
            <label>How will you help promote your appearance?</label>
            <?php $this->textarea('data[s3][promotion]'); ?>
        </div>

		<div class="input">
            <label>Is there anything else you would like to tell us?</label>
            <?php $this->textarea('data[s3][additional_info]'); ?>
        </div>

	</div>
    <!--STEP 3 END-->

    <!--STEP 4-->
    <div class="step" id="step4">
        <h1>Step 4 of 4: Review and Submit</h1>
        <hr />
        <p style="font-weight:bold">Please review your application for accuracy. Click the 'Edit Application' button or the numbered red steps above to make any changes. Your application is not complete until you click the "Submit Application" button below.</p>
        <p>You can update your application anytime until the application deadline. You'll hear from us shortly afterwards. If we accept your application, we'll do our best to accommodate all your requests but can't guarantee it. Details will be confirmed in a follow-up letter after acceptance.</p>
	</div>
    <!--STEP 4 END-->

    <!--STEP 5-->
    <div class="step" id="step5">
        <h1 style="color:red">Thank you!</h1>
        <hr />
        <p>Thanks for your interest in participating in Maker Faire.</p>
        <p style="font-weight:bold;">Important: Add makers@makerfaire.com to your email contact list.</p>
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