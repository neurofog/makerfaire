// JavaScript Document
var step = 1;

jQuery(function($) {

	$('.overwrite').click(function() {
		overwrite_file($(this));
	});

	// Limit the number of Topics an applicant can select
	$('.topics input[type="checkbox"]').click(function() {
		if($('.topics input[type="checkbox"]').filter(':checked').length > 5) {
			$(this).removeAttr('checked');
			alert('Please select no more than 5 topics');
		}
	});


	$('.mf-edit-app').click(function(){
		$('.mf-breadcrumbs div:first-of-type').click();
	});

	function overwrite_file(el) {
		n = $(el).attr('id');
		$(el).parent().append('<input name="'+n+'" type="file" />');

		$('img, a, input[type=hidden]', $(el).parent()).remove();
		$(el).remove();
	}

	$('.mf-form, .mf-login').ajaxForm({
		dataType:  'json',
		success: function(r, s, xhr, $form) {

			$('.ajax-loader').hide();
			$('.mf-form input[type=submit]').show();
			$('.mf-err, .message').remove();
			$('input[type=text], input[type=password], select, textarea').css('border', '1px solid #CCC');
			$('.mf-frm-err-top').remove();

			if(r.status == 'ERROR') {
				err = '<h3 class="mf-frm-err-top">Whoops! You left a required field blank or need to correct some information. Please scroll down and correct the fields marked in red.<ul>';

				for(i in r.errors) {
					for(j in r.errors[i]) {
						if(typeof r.errors[i][j] == 'object') {
							for(k in r.errors[i][j]) {
								n = '[name=data\\['+i+'\\]\\['+j+'\\]\\['+(parseInt(k) + 1)+'\\]]';
								e = r.errors[i][j][k];
								err += '<li>'+k.replace('_', ' ').toUpperCase()+' : '+e+'</li>';

								$('input'+n+', select'+n+', textarea'+n).css('border', '3px solid #EC1C23');
								$('<div class="mf-err">'+e+'</div>').insertAfter($('label', $('input'+n+', select'+n+', textarea'+n).closest('.input')));
							}
						} else {
							n = '[name=data\\['+i+'\\]\\['+j+'\\]]';

							if(j == 'presentation_photo' || j == 'performer_photo' || j == 'project_photo' || j == 'maker_photo' || j == 'group_photo' ||  j == 'presenter_photo' || j == 'm_maker_photo')
								n = '[name='+j+']';

							e = r.errors[i][j];

							err += '<li>'+j.replace('_', ' ').toUpperCase()+' : '+e+'</li>';

							$('input'+n+', select'+n+', textarea'+n).css('border', '3px solid #EC1C23');
							$('<div class="mf-err">'+e+'</div>').insertAfter($('label', $('input'+n+', select'+n+', textarea'+n).closest('.input')));
						}

					}
				}

				$('.mf-form').prepend(err+'</ul></h3>');
			} else {
				$('#id').val(r.id);

				for(i in r.files)
				{
					if(typeof r.files[i] == 'object')
					{
						for(j in r.files[i])
						{
							$('input[name='+i+'\\['+j+'\\]]').parent().append('<img src="'+r.thumbs[i][j]+'" style="max-width:600px" /><input type="hidden" name="data[s'+step+']['+i+']['+j+']" value="'+r.files[i][j]+'" /><div id="'+i+'['+j+']" class="info overwrite">Overwrite File</div>');

							$('input[name='+i+'\\['+j+'\\]]').remove();
						}
					}
					else
					{
						if(i == 'supporting_documents' || i == 'layout')
							$('input[name='+i+']').parent().append('<a href="'+r.files[i]+'" target="_blank">'+r.files[i]+'</a><input type="hidden" name="data[s'+step+']['+i+']" value="'+r.files[i]+'" />');
						else
							$('input[name='+i+']').parent().append('<img src="'+r.thumbs[i]+'" style="max-width:600px" /><input type="hidden" name="data[s'+step+']['+i+']" value="'+r.files[i]+'" /><input type="hidden" name="data[s'+step+']['+i+'_thumb]" value="'+r.thumbs[i]+'" />');

						$('input[name='+i+']').parent().append('<div id="'+i+'" class="info overwrite">Overwrite File</div>');
						$('input[name='+i+']').remove();
					}
				}

				$('.overwrite').click(function() { overwrite_file($(this));	});

				step++

				if(step == 5) {
					$('.step, .mf-breadcrumbs, .mf-form input[type=submit], .review, .mf-edit-app').hide();
					build_review();
					$('#step5').show();
					$(window).unbind('beforeunload');
				} else {
					enable_breadcrumb();
					$('.mf-breadcrumbs div:nth-of-type(' + step + ')').click();
				}
			}

			window.scrollTo(0, 0);
		}
	});


	// Load our loading screen when clicking the continue button
	$('.mf-form input[type=submit]').click(function() {
		$(this).hide();
		$('.ajax-loader').show();
	});

	// Show our loading screen when clicking the "Submit Application" button
	$('.mf-form input[type=submit].save').click(function() {
		$(this).hide();
		$('.ajax-loader').show();
	});



	enable_breadcrumb();
	$('.mf-breadcrumbs div:nth-of-type('+step+')').click();

	function enable_breadcrumb()
	{
		$('.mf-breadcrumbs div:nth-of-type('+step+')').click(function()
		{
			step = $(this).index() + 1;

			$('.step').hide();
			$('#step'+step).show();
			$('#step').val(step);

			build_review();

			if($(this).index() + 1 == 4)
			{
				$('.review, .mf-edit-app').show();
				$('.mf-form input[type=submit]').val('Submit Application');
			}
			else
			{
				$('.review, .mf-edit-app').hide();
				$('.mf-form input[type=submit]').val('Continue');
			}

			window.scrollTo(0, 0);

		}).addClass('active');
	}

	function build_review()
	{
		html = '';
		$('.input').each(function()
		{
			lbl = $('label', this).html();
			$('input, select, textarea', $(this)).each(function() {

				if(($(this).attr('type') != 'radio' && $(this).attr('type') != 'checkbox') || $(this).is(':checked'))
				{
					val  = $(this).val();
					val  = val.replace("\n", "<br />","g");
					n    = $(this).attr('name');
					mlbl = lbl;

					skip = (n.indexOf('photo') > -1 && n.indexOf('thumb') == -1);

					if(!skip)
					{
						if(lbl.indexOf('Photo') > -1)
							val = '<img src="'+val+'" style="max-width:600px" />';

						if(lbl == 'Address *')
							mlbl = $(this).next('div.info').html();
						else if(lbl == 'Contact Phone Number *' && n.indexOf('type') > -1)
							mlbl = 'Contact Phone Number Type *';
						else if(lbl == 'Second Phone Number' && n.indexOf('type') > -1)
							mlbl = 'Second Phone Number Type';

						html += '<h3>'+mlbl+'</h3><h4>'+(val == undefined ? 'N/A' : val)+'</h4>';
					}
				}
			});
		});

		$('.review .inner').html(html);
	}
});




