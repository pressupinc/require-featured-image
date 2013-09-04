jQuery(document).ready(function($) {

    if ($('body').find("#nofeature-message").length===0) {
		$('h2').after('<div id="nofeature-message"></div>');
    }

	setInterval(detectWarnFeaturedImage, 5000);
	detectWarnFeaturedImage();

    function detectWarnFeaturedImage() {
		if ($.find('#postimagediv').length !== 0) {
			if ($('#postimagediv').find('img').length===0 ) {
				$('#nofeature-message').addClass("error").html('<p><strong>This post has no featured image.</strong> Please set one. You must set a featured image before publishing your post.</p>');
				$('#publish').attr('disabled','disabled');
			} else {
				$('#nofeature-message').remove();
				$('#publish').removeAttr('disabled');
			}
		}
	}

});