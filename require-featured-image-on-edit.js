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

        return featuredImage.width < passedFromServer.width || featuredImage.height < passedFromServer.height;
    }

    function disablePublishAndWarn(message) {
        createMessageAreaIfNeeded();
        $('#nofeature-message').addClass("error")
            .html('<p>'+message+'</p>');
        if (isGutenberg()) {
            $('.editor-post-publish-panel__toggle').attr('disabled', 'disabled');
        } else {
            $('#publish').attr('disabled','disabled');
        }
    }

    function clearWarningAndEnablePublish() {
        $('#nofeature-message').remove();
        if (isGutenberg()) {
            $('.editor-post-publish-panel__toggle').removeAttr('disabled');
        } else {
            $('#publish').removeAttr('disabled');
        }
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