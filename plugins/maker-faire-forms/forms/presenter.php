<div class="wrapper hide">
    <script>

    // Count how many presenters we have listed
    num = <?php echo intval(count($this->form['data[s2][presenter_name]'])); ?>;

    jQuery(function($) {
        $('input[name=data\\[s3\\]\\[asked_by_maker\\]]').click(function() {
            if($(this).val() == 'Y') {
                $('.dp-maker-ask').show();
            } else {
                $('.dp-maker-ask').hide();
            }
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
            $('.presenter-photo, .presenter-bio > div', new_maker).remove();

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
    <input id="form_type" name="form" type="hidden" value="presenter" />
    <input name="maker_faire" type="hidden" value="<?php echo esc_attr($this->form['maker_faire']); ?>" />
    <input id="step" name="step" type="hidden" value="1" />
    <input id="id" name="id" type="hidden" value="<?php echo esc_attr($this->form['id']); ?>" />
    <input id="uid" name="uid" type="hidden" value="<?php echo esc_attr($this->form['uid']); ?>" />
    <input name="action" type="hidden" value="mfform_step" />

    <!--STEP 1-->
    <div class="step" id="step1">
        <h1>Step 1 of 4: Presentation Application</h1>
        <div class="info">* Indicates a required field.</div>
        <hr />

        <div class="input">
            <label>Presentation Type *</label>
            <?php $this->radio('data[s1][presentation_type]', array('Presentation', 'Panel Presentation')); ?>
        </div>

        <!-- <div class="input">
            <label>Tell us all about your presentation *</label>
            <div class="info">For the Maker Faire team, explain what your presentation is about. This information will not be made public. Be as descriptive as possible.</div>
            <?php $this->textarea('data[s1][private_description]'); ?>
        </div> -->

        <div class="input">
            <label>Length of Presentation</label>
            <div class="info">Select all options that apply.</div>
            <?php $this->checkbox('data[s1][length_presentation]', array( '12 minutes', '25 minutes', '45 minutes (available only for some panel presentations)' ) ); ?>
        </div>

        <div class="input">
            <label>Presentation Schedule Availability</label>
            <div class="info">Your flexibility is greatly appreciated.</div>
            <?php $this->radio('data[s1][availability]', array('Either Saturday or Sunday', 'Saturday only', 'Sunday only')); ?>
        </div>

        <div class="input">
            <label>Special Requests (Equipment or Scheduling)</label>
            <?php $this->textarea('data[s1][special_requests]'); ?>
        </div>

        <h2>Public Presentation Info</h2>
        <div class="info">This information will be public and appear on our website and in publications.</div>

        <div class="input">
            <label>Title of Presentation *</label>
            <div class="info">Provide a name for your presentation.</div>
            <?php $this->text( 'data[s1][presentation_name]' ); ?>
        </div>

        <div class="input">
            <label>Short Presentation Description *</label>
            <div class="info">Response limited to 250 characters or less.</div>
            <?php $this->textarea( 'data[s1][short_description]', array( 'maxlength'=>250 ) ); ?>
        </div>

        <div class="input">
            <label>Long Presentation Description *</label>
            <div class="info">Can also be the same as Short Presentation Description. Response limited to 650 characters or less.</div>
            <?php $this->textarea( 'data[s1][long_description]', array( 'maxlength'=>650 ) ); ?>
        </div>

        <div class="input">
            <label>Presentation Photo *</label>
            <div class="info">File must be at least 500px wide or larger. PNG, JPG or GIF formats only</div>
            <?php $this->file( 'data[s1][presentation_photo]', 'presentation_photo' ); ?>
        </div>

        <div class="input">
            <label>Presentation Website</label>
            <div class="info">Related content. For example: http://www.mygreatpresentation.com/</div>
            <?php $this->text( 'data[s1][presentation_website]' ); ?>
        </div>

        <div class="input">
            <label>Presentation Video</label>
            <div class="info">Related content. For example: http://www.youtube.com/watch?v=RD_JpGgUFQQ</div>
            <?php $this->text( 'data[s1][video]' ); ?>
         </div>

    </div>
    <!--STEP 1 END-->

    <!--STEP 2-->
    <div class="step" id="step2">
        <h1>Step 2 of 4: Primary Contact &amp; Presenter Information</h1>
        <div class="info">* Indicates a required field.</div>
        <div class="info">The Contact Information below is specific to your Maker Faire Application. Changes you make will not affect your Maker Profile.</div>

        <h2 style="margin-bottom:0px;">Primary Contact Information</h2>
        <h3 style="margin-bottom:20px;">The Contact is the primary logistical contact for the Maker Faire production and editorial team.</h3>

        <div class="input">
            <label>Contact Name *</label>
            <h3 class="default-name"></h3>
            <input type="text" class="default-name" name="data[s2][name]" value="<?php echo esc_attr( $this->form['data[s2][name]'] ); ?>" />
        </div>

        <div class="input">
            <label>Contact Email *</label>
            <div class="info">This is the email address we will send all acceptance and logistical email to - please make sure you type it in carefully.</div>
            <input type="text" class="default-email" name="data[s2][email]" value="<?php echo esc_attr( $this->form['data[s2][email]'] ); ?>" />
        </div>

        <div class="input">
            <label>Contact Phone Number *</label>
            <div class="info">Please provide the best contact number for questions we may have during the planning process.</div>
            <?php $this->text( 'data[s2][phone1]', array( 'class'=>'mf-extra-short' ) ); ?> <?php //$this->select( 'data[s2][phone1_type]', array( 'mobile' => 'Mobile', 'home' => 'Home', 'work' => 'Work', 'other' => 'Other' ) ); ?>
        </div>

        <!-- <div class="input">
            <label>Onsite Phone Number *</label>
            <div class="info">Please provide a mobile phone number so that we are able to reach the presenter onsite during the event if the need arises. <strong><u>This number will only be used by Maker Faire staff</strong></u>.</div>
            <?php // ->text( 'data[s2][phone2]', array( 'class'=>'mf-extra-short' ) ); ?>
        </div> -->

        <?php include('address.php'); ?>


        <div id="m-maker">
            <h2 style="margin-bottom:0px;">Presenter(s) Information</h2>
            <div class="info">Names, bio, title, organization, and photo <u>ONLY</u> will appear on the Maker Faire website and mobile app.</div>
            <div id="m-maker-inner">

                <?php for ( $i=0; $i < count( $this->form['data[s2][presenter_name]'] ); $i++ ) : ?>

                    <div class="maker">

                        <?php if ( $i ) : ?>
                            <div class="del">[x] delete</div>
                        <?php endif; ?>

                        <div class="input">
                            <label>Presenter Name *</label>
                            <input type="text" class="default-name" name="data[s2][presenter_name][<?php echo esc_attr( ( $i + 1 ) ); ?>]" value="<?php echo esc_attr( $this->form['data[s2][presenter_name]'][ $i ] ); ?>" />
                        </div>

                        <div class="input">
                            <label>Presenter Email *</label>
                            <input type="text" class="default-email" name="data[s2][presenter_email][<?php echo esc_attr( ( $i + 1 ) ); ?>]" value="<?php echo esc_attr( $this->form['data[s2][presenter_email]'][ $i ] ); ?>" />
                        </div>

                         <div class="input">
                            <label>Organization/Company</label>
                            <input type="text" name="data[s2][presenter_org][<?php echo esc_attr( ( $i + 1 ) ); ?>]" value="<?php echo esc_attr( $this->form['data[s2][presenter_org]'][ $i ] ); ?>" />
                        </div>

                        <div class="input">
                            <label>Job Title</label>
                            <input type="text" name="data[s2][presenter_title][<?php echo esc_attr( ( $i + 1 ) ); ?>]" value="<?php echo esc_attr( $this->form['data[s2][presenter_title]'][ $i ] ); ?>" />
                        </div>

                        <div class="input presenter-bio">
                            <label>Presenter Bio *</label>
                            <?php if ( $i == 0 ) : ?>
                                <div class="info">This bio will appear on your exhibit sign and on our website. Limited to 200 characters. If you have listed more than one presenter, we will link to the maker accounts you've listed and display each of their personal bios.</div>
                            <?php endif; ?>
                            <textarea name="data[s2][presenter_bio][<?php echo esc_attr( ( $i + 1 ) ); ?>]" maxlength="200" class="default-bio"><?php echo esc_textarea( $this->form['data[s2][presenter_bio]'][ $i ] ); ?></textarea>
                        </div>

                        <div class="input">
                            <label>Presenter Twitter Handle</label>
                            <div class="info">Enter your twitter username (e.g. @makerfaire).</div>
                             <input type="text" name="data[s2][presenter_twitter][<?php echo esc_attr( ( $i + 1 ) ); ?>]" value="<?php echo esc_attr( $this->form['data[s2][presenter_twitter]'][ $i ] ); ?>" />
                        </div>

                        <div class="input">
                            <label>Previous Presentation Experience</label>
                            <div class="info">Share a URL to a video of you giving this same or another presentation. Or list (events, schools, meetings, etc.) where you have presented previously.</div>
                             <input type="text" name="data[s2][presenter_previous][<?php echo esc_attr( ( $i + 1 ) ); ?>]" value="<?php echo esc_attr( $this->form['data[s2][presenter_previous]'][ $i ] ); ?>" />
                        </div>

                        <?php if ( $i == 0 ) : ?>

                            <div class="input presenter-photo">
                                <label>Presenter Photo *</label>
                                <div class="info">Headshot Preferred. File must be at least 500px wide or larger. PNG, JPG or GIF formats only.</div>
                                <?php $this->file( 'data[s2][presenter_photo]', 'presenter_photo' ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="input">
                            <label>Onsite Phone Number *</label>
                            <div class="info">Please provide a mobile phone number so that we are able to reach the presenter onsite during the event if the need arises. <strong><u>This number will only be used by Maker Faire staff</strong></u>.</div>
                            <input type="text" name="data[s2][presenter_onsite_phone][<?php echo esc_attr( ( $i + 1 ) ); ?>]" value="<?php echo esc_attr( $this->form['data[s2][presenter_onsite_phone]'][ $i ] ); ?>" />
                        </div>

                    </div>

                <?php endfor; ?>

            </div>
            <div id="add-maker">+ Add Presenter</div>
        </div>

    </div>
    <!--STEP 2 END-->

    <!--STEP 3-->
    <div class="step" id="step3">
        <h1>Step 3 of 4: Additional Details</h1>
        <div class="info">* Indicates a required field.</div>
        <hr />

        <div class="input">
            <label>If you were asked to present by a member of MAKE or the Maker Faire team, who was it?</label>
            <?php $this->text('data[s3][maker_ask]'); ?>
        </div>

        <div class="input">
            <label>Will this be your first time participating in Maker Faire?</label>
            <?php $this->radio('data[s3][first_makerfaire]', array('Yes', 'No')); ?>
        </div>

        <div class="input">
            <label>Have you already or will you submit an application for a related exhibit?</label>
            <h3>In addition to your presentation, if you're interested in having a related all-weekend exhibit, you can apply for an exhibit space.</h3>
            <div class="info">If yes, please fill out the exhibit application in addition to submitting this one, and indicate in that form that you have also applied for a presenter slot.</div>
            <?php $this->radio('data[s3][exhibit]', array('Yes', 'No')); ?>
        </div>

        <h2>Topics</h2>
        <h3>To help people find your presentation on our website and at Maker Faire, please select a maximum of 5 topics below which apply to your project.</h3>
        <?php include('tags.php'); ?>

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
        <p style="font-weight:bold;">Please review your application for accuracy and click the numbered red steps above to make any changes. Your application is not complete until you click the "Submit Application" button below.</p>
        <p>You can update your application anytime until the application deadline. You'll hear from us shortly afterwards. If we accept your presentation, we'll do our best to accommodate all your requests but can't guarantee it. Presentation details will be confirmed in a follow-up letter after acceptance.</p>
        <p style="font-weight:bold;">After clicking the final red “Submit Application” button, a “Thank you” page will appear and an email will be sent to the contact email you provided in Step 2.</p>
    </div>
    <!--STEP 4 END-->

    <!--STEP 5-->
    <div class="step" id="step5">
        <h1 style="color:red">Thank you!</h1>
        <hr />
        <p>Thanks for your interest in participating in Maker Faire.</p>
        <p>Your application has been received. We're emailing you a confirmation right now.</p>
        <p>If you don't receive it:</p>
        <ul>
            <li>Check your spam folder and add makers@makerfaire.com to your contact list.</li>
            <li>All future communications will be directed to the email address you provided. You can review your application to make sure that you typed in the correct email address by selecting "Your Account" in the header above.</li>
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