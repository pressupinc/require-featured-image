jQuery(document).ready(function($) {

	function postTypeSupportsFeaturedImage() {
		return $.find('#postimagediv').length !== 0;
	}

	function lacksFeaturedImage() {
		return $('#postimagediv').find('img').length === 0;
	}

	function publishButtonIsPublishText() {
		return $('#publish').attr('name') === 'publish';
	}

	function disablePublishAndWarn() {
		createMessageAreaIfNeeded();
		$('#nofeature-message').addClass("error")
			.html('<p>'+objectL10n.jsWarningHtml+'</p>');
		$('#publish').attr('disabled','disabled');
	}

	function clearWarningAndEnablePublish() {
		$('#nofeature-message').remove();
		$('#publish').removeAttr('disabled');
	}

	function createMessageAreaIfNeeded() {
		if ($('body').find("#nofeature-message").length === 0) {
			$('#post').before('<div id="nofeature-message"></div>');
	    }
	}

	function disableTooSmallAndWarn() {
			createMessageAreaIfNeeded();
			$('#nofeature-message').addClass("error")
				.html('<p>'+objectL10n.jsSmallHtml+'</p>');
			$('#publish').attr('disabled','disabled');
	}

	function checkSize(){
		$img = $('#postimagediv').find('img');
		var regex = /-\d+[Xx]\d+\./g;
		input = $img[0].src;
		var pathToImage = input.replace(regex, ".");

		var tempImage1 = new Image();
		tempImage1.src = pathToImage;

		tempImage1.onload = function() {
		    if ((tempImage1.width < objectL10n.width) && (tempImage1.height < objectL10n.height) ){
		    	disableTooSmallAndWarn();
		    }
		    else{
		    	clearWarningAndEnablePublish();
		    }
		};
	}

    function detectWarnFeaturedImage() {
		if (postTypeSupportsFeaturedImage()) {
			if (lacksFeaturedImage() && publishButtonIsPublishText()) {
				disablePublishAndWarn();
			} else {
				checkSize();
			}
		}
	}


	detectWarnFeaturedImage();
	setInterval(detectWarnFeaturedImage, 3000);
});
