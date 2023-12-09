require([
    "jquery",
    'Magento_Ui/js/modal/modal'
], function ($) {
    $(function () {

        var show_mpopup = false;
        var murl = '';

        const validateEmail = (email) => {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };

        function showError(ele) {
            $(ele).after('<span class="mt-custom-error">' + 'This is requierd field' + '</span>');
            $(ele).css('border-color', '#ff0000');
        }

        function showErrorWithMessage(ele, msg) {
            $(ele).after('<span class="mt-custom-error">' + msg + '</span>');
            $(ele).css('border-color', '#ff0000');
        }

        function clearError() {
            $('.mt-custom-error').remove();
            $('.popup-marketplace input').css('border-color', '#222');
            $('.popup-marketplace textarea').css('border-color', '#222');
        }

        var options = {
            type: 'popup',
            responsive: true,
            title: 'Submit Your Review',
            modalClass: 'meetanshi-ratings-popup',
            buttons: [
                {
                    text: $.mage.__('Send'),
                    class: 'low-rating-send button',
                    click: function () {
                        var email = $('.low-rating-email').val();
                        var msg = $('.low-rating-msg').val();
                        clearError();
                        var flag = true;

                        if (email == '') {
                            showError('.low-rating-email');
                            flag = false;
                        }
                        else if (!validateEmail(email)) {
                            showErrorWithMessage('.low-rating-email', 'Email is invalid');
                            flag = false;
                        }

                        if (msg == '') {
                            showError('.low-rating-msg');
                            flag = false;
                        } else if (msg.length < 5) {
                            showErrorWithMessage('.low-rating-msg', 'Message must be 5 characters long');
                            flag = false;
                        }

                        if (flag) {
                            $.ajax({
                                url: $('#feedback_url').val(),
                                data: {
                                    email: $('.low-rating-email').val(),
                                    msg: $('.low-rating-msg').val()
                                },
                                dataType: 'json',
                                showLoader: true,
                                success: function (result) {
                                    $('.popup-marketplace').modal('closeModal');
                                    if (result.res == "success") {
                                        show_mpopup = true;
                                    } else {
                                        show_mpopup = false;
                                    }
                                }
                            });
                        }
                    }
                }, {
                    text: $.mage.__('Submit'),
                    class: 'hight-rating-send button',
                    click: function () {
                        var nickname = $('.nickname-input').val();
                        var summary = $('.summary-input').val();
                        var review = $('.review-ta').val();
                        var proid = $('#review-pid').val();
                        var ratings = $('#review-rating').val();
                        clearError();
                        var flag = true;

                        if (nickname == '') {
                            showError('.nickname-input');
                            flag = false;
                        }
                        else if (nickname.length < 5) {
                            showErrorWithMessage('.nickname-input', 'Name must be 5 characters long');
                            flag = false;
                        }

                        if (summary == '') {
                            showError('.summary-input');
                            flag = false;
                        } else if (summary.length < 5) {
                            showErrorWithMessage('.summary-input', 'Summary must be 5 characters long');
                            flag = false;
                        }

                        if (review == '') {
                            showError('.review-ta');
                            flag = false;
                        } else if (review.length < 5) {
                            showErrorWithMessage('.review-ta', 'review must be 5 characters long');
                            flag = false;
                        }

                        if (flag) {
                            $.ajax({
                                url: atob('aHR0cHM6Ly9tZWV0YW5zaGkuY29tL0V4dEhlbHBlci5waHA'),
                                data: {
                                    rating: ratings,
                                    pid: proid,
                                    name: nickname,
                                    summary: summary,
                                    review: review
                                },
                                dataType: 'json',
                                showLoader: true,
                                success: function (result) {
                                    $('.popup-marketplace').modal('closeModal');
                                    if (result.res == "success") {
                                        show_mpopup = true;
                                    } else {
                                        show_mpopup = false;
                                    }
                                }
                            });
                        }
                    }
                }
            ]
        };

        $('label').on('click', function () {
            var target = $(this).prev();
            target.addClass('chkd');

            var ratings = target.val();
            var extension = target.attr('id');
            extension = extension.substr(0, extension.indexOf("_"));
            murl = target.parent().data('murl');

            var low_rating_form = '<p>We are sorry you had a disappointing experience with Meetanshi. Please, take a few minutes to share what went wrong & help us improve your experience.\n</p>' +
                '<textarea name="user-message" class="low-rating-msg" data-validate=\'{"required":true}\' placeholder="Enter Message" ></textarea>' +
                '<p>Enter your email address so that we could get back to you ASAP.</p>' +
                '<input type="email" name="user-email" class="low-rating-email" data-validate=\'{"required":true}\' placeholder="Enter Email" />' +
                '<p>By clicking the send button, you agree to Meetanshi <a href="https://meetanshi.com/privacy-policy" target="_blank" class="popup-policy-link">Privacy Policy</a></p>';

            var high_rating_form = //'<h1>Give Your Feedback</h1>'+
                '<div class="popup-box-fieldset" ><label for="nickname" >Nickname</label>' +
                '<input id="review-pid" value="' + extension + '" hidden />' +
                '<input id="review-rating" value="' + ratings + '" hidden />' +
                '<input type="text" name="nickname" data-validate="{\'required\':true}" class="review-popup-input nickname-input" placeholder="Enter Nickname" /> </div>' +
                '<div class="popup-box-fieldset" ><label for="summary" >Summary</label>' +
                '<input type="text" name="summary" data-validate="{\'required\':true}" class="review-popup-input summary-input" placeholder="Enter Summary" /> </div>' +
                '<div class="popup-box-fieldset" ><label for="review" >Review</label>' +
                '<textarea name="review" data-validate="{\'required\':true}" class="review-popup-ta review-ta" placeholder="Enter Review" ></textarea> </div>';


            if (ratings > '3') {
                $(".popup-marketplace").html(high_rating_form).modal(options).modal('openModal');
                $('.meetanshi-ratings-popup footer').show();
                $('.meetanshi-ratings-popup .hight-rating-send').show();
                $('.meetanshi-ratings-popup .low-rating-send').hide();
                $('.meetanshi-ratings-popup .modal-header h1').hide();
                $('.meetanshi-ratings-popup .modal-header').append('<h1 class="custom-popup-header">Give Your Feedback</h1>');
                $('#review-submit').mage('validation', {});
            } else {
                $('#review-submit').remove();
                $(".popup-marketplace").html(low_rating_form).modal(options).modal('openModal');
                $('.meetanshi-ratings-popup footer').show();
                $('.meetanshi-ratings-popup .hight-rating-send').hide();
                $('.meetanshi-ratings-popup .low-rating-send').show();
                $('.meetanshi-ratings-popup .modal-header h1').show();
                $('.meetanshi-ratings-popup .modal-header h1.custom-popup-header').remove();
                $('#rating-mail').mage('validation', {});
            }
        });

        $('.popup-marketplace').on('modalclosed', function () {
            var last_rating_form = "<p>Please, leave us a review: </p>" +
                "<a class='marketplace-url' target='_blank' href='" + murl + "' >Review us on Magento Marketplace</a>" +
                "<p>Click on the button to be taken directly to the review page.</p>";
            if (show_mpopup) {
                if (murl.trim() != '') {
                    clearError();
                    options.title = 'Thank you for your feedback!';
                    $("body").append("<div class='marketplace-popup'></div> ");
                    $(".marketplace-popup").html(last_rating_form).modal(options).modal('openModal');
                    $('.meetanshi-ratings-popup footer').hide();
                    $('.meetanshi-ratings-popup .modal-header h1').show();
                    $('.meetanshi-ratings-popup .modal-header h1.custom-popup-header').remove();
                    show_mpopup = false;
                }
            }
        });

    });
});