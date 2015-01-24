jQuery(document).ready(function($) {

	function postTypeSupportsFeaturedImage() {
		return $.find('#postimagediv').length !== 0;
	}

	function hasFeaturedImage() {
		return $('#postimagediv').find('img').length === 0;
	}

	function publishButtonIsPublishText() {
		return $('#publish').attr('value') === 'Publish';
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
			$('h2').after('<div id="nofeature-message"></div>');
	    }
	}

    function detectWarnFeaturedImage() {
		if (postTypeSupportsFeaturedImage()) {
			if (hasFeaturedImage() && publishButtonIsPublishText()) {
				disablePublishAndWarn();
			} else {
				clearWarningAndEnablePublish();
			}
		}
	}

	detectWarnFeaturedImage();
	setInterval(detectWarnFeaturedImage, 3000);
});