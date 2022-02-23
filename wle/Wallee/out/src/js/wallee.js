(function ($) {
    window.Wallee = {
        handler: null,
        methodConfigurationId: null,
        running: false,
        loaded: false,
        initCalls: 0,
        initMaxCalls: 10,

        initialized: function () {
            $('#Wallee-iframe-spinner').hide();
            $('#Wallee-iframe-container').show();
            $('#orderConfirmAgbBottom  button[type="submit"]').removeAttr('disabled');
            $('#orderConfirmAgbBottom  button[type="submit"]').click(function (event) {
            	event.preventDefault();
                Wallee.handler.validate();
                $('#orderConfirmAgbBottom  button[type="submit"]').attr('disabled', 'disabled');
                return false;
            });
            this.loaded = true;
            $('[name=Wallee-iframe-loaded').attr('value', 'true');
        },
        
        fallback: function() {
        	$('#Wallee-payment-information').toggle();
        	$('#orderConfirmAgbBottom  button[type="submit"]').removeAttr('disabled');
        },
        
        heightChanged: function () {
            const self = this;
            setTimeout(function () {
                if(self.loaded && $('#Wallee-iframe-container > iframe').height() == 0) {
                    $('#Wallee-iframe-container').parent().parent().hide();
                }
            }, 500);
        },
        
        getAgbParameter: function() {
            var agb = $('#checkAgbTop');
            if(!agb.length) {
                agb = $('#checkAgbBottom');
            }
            if(agb.length && agb[0].checked) {
                return '&ord_agb=1';
            }
            return '';
        },

        submit: function () {
            if (Wallee.running) {
                return;
            }
            Wallee.running = true;
            var params = '&stoken=' + $('input[name=stoken]').val();
            params += '&sDeliveryAddressMD5=' + $('input[name=sDeliveryAddressMD5]').val();
            params += '&challenge=' + $('input[name=challenge]').val();
            params += this.getAgbParameter(),
            $.getJSON('index.php?cl=order&fnc=wleConfirm' + params, '', function (data, status, jqXHR) {
                if (data.status) {
                    Wallee.handler.submit();
                }
                else {
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
        	this.initCalls++;
            if (typeof window.IframeCheckoutHandler === 'undefined') {
            	if(this.initCalls < this.initMaxCalls) {
	                setTimeout(function () {
	                    Wallee.init(methodConfigurationId);
	                }, 500);
            	} else {
            		this.fallback();
            	}
            } else {
                Wallee.methodConfigurationId = methodConfigurationId;
                Wallee.handler = window
                    .IframeCheckoutHandler(methodConfigurationId);
                Wallee.handler.setInitializeCallback(this.initialized);
                Wallee.handler.setValidationCallback(this.validated);
                Wallee.handler.setHeightChangeCallback(this.heightChanged);
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