(function ($) {
    window.Wallee = {
        handler: null,
        methodConfigurationId: null,
        running: false,

        initialized: function () {
            $('#orderConfirmAgbBottom  button[type="submit"]').removeAttr('disabled');
            $('#Wallee-iframe-spinner').hide();
            $('#orderConfirmAgbBottom  button[type="submit"]').click(function (event) {
                Wallee.handler.validate();
                $('#orderConfirmAgbBottom  button[type="submit"]').attr('disabled', 'disabled');
            });
        },

        submit: function () {
            if (Wallee.running) {
                return;
            }
            Wallee.running = true;
            var params = '&stoken=' + $('input[name=stoken]').val();
            params += '&sDeliveryAddressMD5=' + $('input[name=sDeliveryAddressMD5]').val();
            params += '&challenge=' + $('input[name=challenge]').val();
            $.getJSON('index.php?cl=order&fnc=wleConfirm' + params, '', function (data, status, jqXHR) {
                if (data.status) {
                    Wallee.handler.submit();
                } else {
                    Wallee.addError(data.message);
                    $('#orderConfirmAgbBottom  button[type="submit"]').removeAttr('disabled');
                }
                Wallee.running = false;
            }).fail((function(jqXHR, textStatus, errorThrown) {
                alert("Something went wrong: " + errorThrown);
            }));
        },

        validated: function (result) {
            if (result.success) {
                Wallee.submit();
            } else {
                if (result.errors) {
                    for (var i = 0; i < result.errors.length; i++) {
                        Wallee.addError(result.errors[i]);
                    }
                }
                $('#orderConfirmAgbBottom  button[type="submit"]').removeAttr('disabled');
            }
        },

        init: function (methodConfigurationId) {
            if (typeof window.IframeCheckoutHandler === 'undefined') {
                setTimeout(function () {
                    Wallee.init(methodConfigurationId);
                }, 500);
            } else {
                Wallee.methodConfigurationId = methodConfigurationId;
                Wallee.handler = window
                    .IframeCheckoutHandler(methodConfigurationId);
                Wallee.handler.setInitializeCallback(this.initialized);
                Wallee.handler.setValidationCallback(this.validated);
                Wallee.handler.create('Wallee-iframe-container');
            }
        },

        addError: function (message) {
            $('#Wallee-iframe-container').find('div.error').remove();
            $('#Wallee-iframe-container').prepend($("<div class='status error corners'><p style='padding-left:3em;'>" + message + "</p></div>"));
            $('html, body').animate({
                scrollTop: $('#Wallee-iframe-container').find('div.error').offset().top
            }, 200);
        }
    }
})(jQuery);