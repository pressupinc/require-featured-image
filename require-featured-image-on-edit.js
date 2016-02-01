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

	function featuredImageTooSmall(){
		$img = $('#postimagediv').find('img');
		var regex = /-\d+[Xx]\d+\./g;
		var input = $img[0].src;
		var pathToImage = input.replace(regex, ".");

		var featuredImage = new Image();
		featuredImage.src = pathToImage;

		featuredImage.onload = function() {
		    if ((featuredImage.width < objectL10n.width) || (featuredImage.height < objectL10n.height)
					&& publishButtonIsPublishText() ){
		    	return disableTooSmallAndWarn();
		    }
		    else{
		    	return clearWarningAndEnablePublish();
		    }
		};
	}

    function detectWarnFeaturedImage() {
		if (postTypeSupportsFeaturedImage()) {
			if (lacksFeaturedImage() && publishButtonIsPublishText()) {
				disablePublishAndWarn();
			} else {
				featuredImageTooSmall();
			}
		}
	}


	detectWarnFeaturedImage();
	setInterval(detectWarnFeaturedImage, 3000);
});
