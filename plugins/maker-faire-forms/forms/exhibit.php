<script>

	num = <?php echo esc_js(count($this->form['data[s2][m_maker_name]'])); ?>;

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
		
		$('input[name=data\\[s3\\]\\[org_type\\]]').click(function() {
			if($(this).val() == 'Non-profit' || $(this).val() == 'Cause or mission-based organization')											   
				$('.dp-nfp').show();
			else
				$('.dp-nfp').hide();
				
			if($(this).val() == 'Established company or commercial entity')
				$('.dp-company').show();
			else
				$('.dp-company').hide();
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
			
			num++;
			
			m = $('#m-maker-inner .maker:first-of-type').clone();
			$('input, textarea', m).val('');
			
			$('input, textarea', m).each(function() {
				n = $(this).attr('name');
				n = n.replace(/\[[0-9]\]/g, '['+num+']');
				$(this).attr('name', n);
			});
			
			$('.input', m).each(function() {
				if($(this).index() > 1)
					$(this).remove();
			});
			
			$(m).prepend('<div class="del">[x] delete</div>');
			$('#m-maker-inner').append(m);
			$('.maker .del').click(function() {$(this).parent().remove();});
		});
		
	});
</script>

<div class="mf-breadcrumbs">
	<div>1</div>
    <div>2</div>
    <div>3</div>
    <div>4</div>
</div>

<form action="/wp-admin/admin-ajax.php" method="post" class="mf-form">
	
    <input name="form" type="hidden" value="exhibit" />
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
            <div class="info">Provide a short, catchy name for your project. Response limited to 30 characters</div>
            <?php $this->text('data[s1][project_name]', array('maxlength'=>30, 'class'=>'mf-shorter-field')); ?>
        </div>
        
        <div class="input">
            <label>Tell us about your project *</label>
            <div class="info">For the Maker Faire team, explain what your project is and describe what you will actually be bringing to Maker Faire. This information will not be made public. Be as descriptive as possible.</div>
            <?php $this->textarea('data[s1][private_description]', array('class'=>'mf-extra-tall')); ?>
        </div>
        
        <h2>Public Project Info:</h2>
		<div class="info">This information will be public and will appear on your exhibit sign, our website and our mobile app.</div>

		<div class="input">
            <label>Short Project Description *</label>
            <div class="info">We need a short, concise description. Limited to 225 characters.</div>
             <?php $this->textarea('data[s1][public_description]', array('maxlength'=>230, 'class'=>'mf-shorter-field')); ?>
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
            <div class="info">Including food in your exhibit may require a Health Permit and fees. Details will be emailed to you after acceptance.</div>
            <?php $this->radio('data[s1][food]', array('Yes', 'No')); ?>
        </div>
				
        <div class="input dp-food <?php echo esc_attr((strpos($this->form['data[s1][food]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>Describe what type of food and any details.</label>
            <?php $this->textarea('data[s1][food_details]'); ?>
        </div>
		
		<div class="input">
            <label>Will you be selling or marketing a product at Maker Faire?</label>
            <?php $this->radio('data[s1][sales]', array('Yes', 'No')); ?>
        </div>
            
        <div class="input dp-sales <?php echo esc_attr((strpos($this->form['data[s1][sales]'], 'Yes') !== false ? '' : 'h')); ?>">
        <div class="info">If you would like to sell or market your own creations at Maker Faire, you are a "Commercial Maker" and must pay a fee of $325, due May 1. All Commercial Maker spaces are tabletop or 10'x10' spaces and include 1 table and 2 chairs. Additional tables, chairs, and power can be purchased after acceptance during the payment process. Please continue to fill out this form.<br /><br />Established companies and commercial entities do not qualify as Commercial Makers. We have great opportunities available at Maker Faire for companies. Do not fill out this form, please contact <a href="mailto:sales@makerfaire.com">sales@makerfaire.com</a>.</div>
            <label>What product will you be selling or marketing?</label>
            <div class="info">Describe and list the price range of your product(s).</div>
            <?php $this->textarea('data[s1][sales_details]'); ?>
        </div> 
		
		<div class="input">
            <label>Space Size Request * </label>                     
            <div><input name="data[s1][booth_size]" type="radio" value="Mobile" <?php checked($this->form['data[s1][booth_size]'] == 'Mobile'); ?> /> My exhibit is mobile (no fixed exhibit space needed)</div>
            <div><input name="data[s1][booth_size]" type="radio" value="Tabletop" <?php checked($this->form['data[s1][booth_size]'] == 'Tabletop'); ?> /> Tabletop</div>
			<div><input name="data[s1][booth_size]" type="radio" value="10x10" <?php checked($this->form['data[s1][booth_size]'] == '10x10'); ?> /> 10' x 10'</div>
			<div id="size-10x20"><input name="data[s1][booth_size]" type="radio" value="10x20" <?php checked($this->form['data[s1][booth_size]'] == '10x20'); ?> /> 10' x 20'</div>
			<div id="size-other"><input name="data[s1][booth_size]" type="radio" value="Other" <?php checked($this->form['data[s1][booth_size]'] == 'Other'); ?> /> Other - Tell us your space size request below</div>
            <div class="info dp-sales h">Makers who are selling or marketing products are considered Commercial Makers and can only have a mobile, tabletop or 10x10 space for the standard $325 fee. 10x20 spaces or larger are allowed through our sales team. Email sales@makerfaire.com.</div>
        </div>
		
		<div class="input dp-size <?php echo esc_attr((strpos($this->form['data[s1][booth_size]'], 'Other') !== false ? '' : 'h')); ?>">
            <label>Special Space Requirements *</label>
            <?php $this->textarea('data[s1][booth_size_details]'); ?>
        </div>
		
		<div class="input">
            <label>Tables and Chairs * </label>          
            <div class="info">Exhibits are typically allocated 1 table and 2 chairs.</div>
            <?php $this->radio('data[s1][tables_chairs]', array('None'=>'No tables or chairs needed', 'Standard'=>'1 table and 2 chairs', 'Special'=>'More than 1 table and 2 chairs. Specify your request below')); ?>
        </div>
		
		<div class="input">
            <label>Additional table and chair or special setup requests</label>
			<div class="info">Special requests are not guaranteed by acceptance. You will receive confirmation in advance of the faire.</div>
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
        </div>
		
		<div class="input">
            <label>Placement Request</label>
			<div class="info">Is there an exhibit or group you are affiliated with or a subject area you would like to be placed with at Maker Faire?</div>
            <?php $this->textarea('data[s1][placement]'); ?>
        </div>
		
		<div class="input">
            <label>Location *</label>    
            <?php $this->radio('data[s1][booth_location]', array('Inside', 'Outside', 'Either')); ?>      
        </div>
		
		<div class="input">
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
		
		<h2>Electrical Requirements</h2>
		<div class="input">
            <label>Does your exhibit require an external power source? *</label>
            <?php $this->radio('data[s1][power]', array('Yes', 'No')); ?>
        </div>
		
		<div class="input dp-power <?php echo esc_attr((strpos($this->form['data[s1][power]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>What are you powering?</label>
            <?php $this->textarea('data[s1][what_are_you_powering]'); ?>
        </div>
		
		<div class="input dp-power <?php echo esc_attr((strpos($this->form['data[s1][power]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>How much amperage do you need?</label>
			<div class="info">To ensure you have adequate power onsite, it's essential we know the amount you need in advance.<br />To find the total amperage you require, find the amperage listing on the back of each piece of equipment you plan to use onsite and add up the amps from each item.  <br />
			&nbsp;- All options below are for a 110v circuit (normal US house circuit.) <br />
			&nbsp;- If you require a 220v circuit, explain your requirements in the comment box provided.
            </div>
            <?php $this->radio('data[s1][amps]', array('5 amp circuit (0-500 watts, 110V)', '10 amp circuit (501-1000 watts, 110V)', '15 amp circuit (1001-1500 watts, 110V)', '20 amp circuit (1501-2000 watts, 110V)', 'My exhibit requires power, but I need help determining my total power amperage', 'Special power requirements noted below')); ?>
        </div>
		
		<div class="input dp-power <?php echo esc_attr((strpos($this->form['data[s1][power]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>Special requirements: total amperage and any additional details</label>
            <?php $this->textarea('data[s1][amps_details]'); ?>
        </div>
		
		<div class="input">
            <label>Internet Requirement *</label>   
            <?php $this->radio('data[s1][internet]', array('No internet access needed', 'It would be nice to have WiFi internet access', 'My exhibit must have WiFi internet access to work')); ?>       
        </div>
		
		<h2>Radio Frequencies</h2>
		<div class="input">
            <label>Does your exhibit use or disrupt radio frequencies? *</label>
            <?php $this->radio('data[s1][radio]', array('Yes', 'No')); ?>
        </div>
		
		<div class="input dp-radio <?php echo esc_attr((strpos($this->form['data[s1][radio]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>My exhibit uses: (check all that apply)</label>    
            <?php $this->checkbox('data[s1][radio_frequency]', array('Remote Control (enter frequency band below)', 'Amateur radio or CB', 'ZigBee on 900 MHz', 'ZigBee on 2.4 GHz', 'Telepathy', 'Bluetooth', 'WiFi Internet access', 'My own local WiFi cloud on 2.4 GHz', 'My own local WiFi cloud on 5 GHz', 'Something else on 900 MHz', 'Something else on 2.4 GHz', 'Something else on 5 GHz', 'Something with an antenna, but I have no idea what')); ?>      
        </div>
		
		<div class="input dp-radio <?php echo esc_attr((strpos($this->form['data[s1][radio]'], 'Yes') !== false ? '' : 'h')); ?>">
            <label>Describe additional details of your RF use</label>
            <?php $this->textarea('data[s1][radio_details]'); ?>
        </div>
		
		<h2>Safety</h2>
		<div class="input">
            <label>Does your exhibit contain fire (any size flame), chemicals, or other dangerous materials or tools (propane, welders, etc)?</label>
            <?php $this->radio('data[s1][fire]', array('Yes', 'No')); ?>
        </div>
		
		<div class="input">
            <label>Do you have a hands-on activity or interactive exhibit, including using tools of any kind, riding (bikes, go carts, swings, etc), climbing, etc?</label>
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
                    <h3 class="default-name"></h3>
                    <input type="hidden" class="default-name" name="data[s2][name]" value="<?php echo esc_attr($this->form['data[s2][name]']); ?>" />
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
                         <?php $this->textarea('data[s2][maker_bio]', array('maxlength'=>200, 'class'=>'mf-shorter-field default-bio')); ?>
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
                            <?php if($i == 0) : ?>
                            <div class="input">
                                <label>Maker Bio *</label>
                                <div class="info">This bio will appear on the Maker Faire website and mobile app. Limited to 200 characters. If you have listed more than one maker, we will link to the maker accounts you've listed above and display each of their personal bios.</div>
                                <textarea name="data[s2][m_maker_bio][<?php echo esc_attr(($i + 1)); ?>]" maxlength="200" class="mf-shorter-field default-bio"><?php echo esc_html($this->form['data[s2][m_maker_bio]'][$i]); ?></textarea>
                            </div>				
                            <div class="input">
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
                	<label>A Group or Association</label>
                    <div class="info">This name, bio and photo will appear on the Maker Faire website and mobile app.</div>
                    <div class="input">
                        <label>Group Name *</label>
                        <?php $this->text('data[s2][group_name]'); ?>
                    </div> 
                    
                    <div class="input">
                        <label>Group Bio *</label>
                        <div class="info">Limited to 200 characters or less.</div>
                        <?php $this->textarea('data[s2][group_bio]', array('maxlength'=>200, 'class'=>'mf-shorter-field')); ?>
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
                </div>
				<h2>Private Contact Information (for Maker staff use only)</h2>
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
		
		<div class="input">
            <label>Are you a: *</label>
            <?php $this->radio('data[s3][org_type]', array('Non-profit', 'Cause or mission-based organization', 'Established company or commercial entity', 'None of the above')); ?>
        </div>
        
		<!-- If non-profit or cause/mission -->
		<div class="input dp-nfp <?php echo esc_attr((strpos($this->form['data[s1][booth_size]'], 'profit') !== false || strpos($this->form['data[s1][booth_size]'], 'mission') !== false ? '' : 'h')); ?>">
            <label>If your organization is a large non-profit or cause or mission-based organization, please tell us more about why you want to come to Maker Faire.</label>
            <div class="info">Large non-profits and cause/mission based organizations can qualify for special reduced rates to participate in Maker Faire. Complete the rest of this form and someone from the Maker Faire team will contact you with details.</div>
            <?php $this->textarea('data[s3][large_non_profit]'); ?>
        </div>
        
		<!-- If company -->
		<div class="dp-company <?php echo esc_attr((strpos($this->form['data[s1][booth_size]'], 'company') !== false ? '' : 'h')); ?>">Established companies and commercial entities do not qualify for free exhibit space, which is what this application form is for. We have great opportunities available at Maker Faire for companies, please contact <a href="mailto:sales@makerfaire.com">sales@makerfaire.com</a>. Do not complete the rest of this form.</div>
		
		<div class="input">
			<label>Optional: Upload additional supporting documents.</label>
            <div class="info">Upload anything else related to your exhibit you'd like to share with us.</div>
            <?php $this->file('data[s3][supporting_documents]', 'supporting_documents'); ?>
		</div>
		
		<h2>Topics</h2>
        <div>To help people find your exhibit on our website and at Maker Faire, please select all of the topics below which apply to your project.</div>
        <?php include('tags.php'); ?>
		
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
            <label>If you are accepted, will this be your first time participating in Maker Faire?</label>
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
        <p style="font-weight:bold">Please review your application for accuracy and click the numbered red steps above to make any changes. Your application is not complete until you click the "Submit Application" button below.</p>
        <p style="font-weight:bold">Click on the section numbers above to return to your application and edit.</p>
        <p>You can update your application anytime until the application deadline. You'll hear from us shortly afterwards. If we accept your exhibit, we'll do our best to accommodate all your requests but can't guarantee it. Exhibit details will be confirmed in a follow-up letter after acceptance.</p><p>Acceptance indicates we have accepted the concept of your exhibit; however, it does not guarantee that we can accommodate all your requests.</p> 
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
		<p>Stay tuned for more communication about participating in Maker Faire!</p> 
	</div>
    <!--STEP 6 END-->
	<div class="review" style="display:none">
    <input type="button" class="mf-edit-app" value="Edit Application" /><input type="submit" value="Continue" />
    <h1 style="margin:20px 0">Your Application:</h1>
    <div class="inner"></div>
    </div>
	<input type="button" class="mf-edit-app" value="Edit Application" /><input type="submit" value="Continue" /><br />
    <div class="info">If you experience problems with this form, email <a href="mailto:webmaster@makezine.com">webmaster@makezine.com</a>.</div>
</form>