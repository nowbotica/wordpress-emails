/*
/* Emails JS
/*
*/
(function($){ $(function() {

	$('input#sendform').click( function(e) {

		e.preventDefault();
		var data = {
			to : $('input[name="email_to"]').val(),
			cc : $('input[name="email_cc"]').val(),
			subject : $('input[name="email_subject"]').val()
		}
		console.log(data)
		// $('#emails-builder').serialize()
		// data.emailHtml = '<a href="ecowelle.com">this is link</a>'

	    $.ajax({

	        url: ajaxUrl.ajaxUrl,
	        type: 'POST',
	        dataType: 'json',
	        data : {
				action : 'do_email',
				data   : data
			},
	        success: function(response) {
	            console.log('dsf',response)
	        },
	        error: function(errorThrown){
          		console.log(errorThrown);
      		}, 
	        beforeSubmit : function(arr, $form, options){
            	arr.push( { "name" : "nonce", "value" : ajaxUrl.nonce });
        	}

	    });
		console.log('clicked')
	});

}); })(jQuery);