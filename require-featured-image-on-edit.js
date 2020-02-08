jQuery(document).ready(function($) {

    function isGutenberg() {
        return ($('.block-editor-writing-flow').length > 0);
    }

    function checkImageReturnWarningMessageOrEmpty() {
        if (isGutenberg()) {
            var $img = $('.editor-post-featured-image').find('img');
        } else {
            var $img = $('#postimagediv').find('img');
        }
        if ($img.length === 0) {
            return passedFromServer.jsWarningHtml;
        }
        if (featuredImageIsTooSmall()) {
            return passedFromServer.jsSmallHtml;
        } else if (featuredImageIsTooLarge()) {
			return passedFromServer.jsLargeHtml;
		}
        return '';
    }

    // Contains three test "failures" at page load
    var isTooSmallTrials = [ true, true, true ];

    function featuredImageIsTooSmall() {
        // A weird polling issue in Chrome made this necessary
        if (isGutenberg()) {
            var $img = $('.editor-post-featured-image').find('img');
        } else {
            var $img = $('#postimagediv').find('img');
        }
        // pop one off, if needed
        if( isTooSmallTrials.length > 2 ) {
            isTooSmallTrials.shift();
        }
        isTooSmallTrials.push( passedImageIsTooSmall($img) );

        var imageIsTooSmallCount = isTooSmallTrials.reduce(function (a, b) {
            return a + b;
        }, 0);

        return (imageIsTooSmallCount > 2);
    }

    function passedImageIsTooSmall($img) {
        var input = $img[0].src;
        var pathToImage = input.replace(/-\d+[Xx]\d+\./g, ".");
        var featuredImage = new Image();
        featuredImage.src = pathToImage;

        return featuredImage.width < passedFromServer.minWidth || featuredImage.height < passedFromServer.minHeight;
    }

	// Contains three test "failures" at page load
	var isTooLargeTrials = [ true, true, true ];
	function featuredImageIsTooLarge() {
		// A weird polling issue in Chrome made this necessary
		if (isGutenberg()) {
			var $img = $('.editor-post-featured-image').find('img');
		} else {
			var $img = $('#postimagediv').find('img');
		}
		// pop one off, if needed
		if( isTooLargeTrials.length > 2 ) {
			isTooLargeTrials.shift();
		}
		isTooLargeTrials.push( passedImageIsTooLarge($img) );

		var imageIsTooLargeCount = isTooLargeTrials.reduce(function (a, b) {
			return a + b;
		}, 0);

		return (imageIsTooLargeCount > 2);
	}

	function passedImageIsTooLarge($img) {
		var input = $img[0].src;
		var pathToImage = input.replace(/-\d+[Xx]\d+\./g, ".");
		var featuredImage = new Image();
		featuredImage.src = pathToImage;

		//Check to ensure that if only one of the parameters has been set then it doesn't auto-fail the image
		if (passedFromServer.maxWidth === "0" && passedFromServer.maxHeight === "0") {
			return false;
		} else if (passedFromServer.maxWidth === "0") {
			return featuredImage.height > passedFromServer.maxHeight;
		} else if (passedFromServer.maxHeight === "0") {
			return featuredImage.width > passedFromServer.maxWidth;
		}

		return featuredImage.width > passedFromServer.maxWidth || featuredImage.height > passedFromServer.maxHeight;
	}

    function disablePublishAndWarn(message) {
        createMessageAreaIfNeeded();
        $('#nofeature-message').addClass("error")
            .html('<p>'+message+'</p>');
        if (isGutenberg()) {
			if (isNewGutenbergArticle()) {
				$('.editor-post-publish-panel__toggle').attr('disabled', 'disabled');
			} else {
				$('.editor-post-publish-button').attr('aria-disabled', true);
			}
        } else {
            $('#publish').attr('disabled','disabled');
        }
    }

    function clearWarningAndEnablePublish() {
        $('#nofeature-message').remove();
        if (isGutenberg()) {
			if (isNewGutenbergArticle()) {
				$('.editor-post-publish-panel__toggle').removeAttr('disabled');
			} else {
				$('.editor-post-publish-button').attr('aria-disabled', true);
			};
		} else {
            $('#publish').removeAttr('disabled');
        }
    }

    function isNewGutenbergArticle(){
		return $('.editor-post-publish-panel__toggle').length;
	}

    function createMessageAreaIfNeeded() {
        if ($('body').find("#nofeature-message").length === 0) {
            if (isGutenberg()) {
                $('.components-notice-list').append('<div id="nofeature-message"></div>');
            } else {
                $('#post').before('<div id="nofeature-message"></div>');
            }
        }
    }

    function detectWarnFeaturedImage() {
        if (checkImageReturnWarningMessageOrEmpty()) {
            disablePublishAndWarn(checkImageReturnWarningMessageOrEmpty());
        } else {
            clearWarningAndEnablePublish();
        }
    }

    detectWarnFeaturedImage();
    setInterval(detectWarnFeaturedImage, 800);

});
