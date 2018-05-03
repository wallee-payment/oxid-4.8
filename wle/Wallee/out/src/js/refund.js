(function ($) {
    window.Refund = {
        emptyRefundMessage: 'Empty refund',

        change: function (e) {
            var idx = $(this).attr('name').match(/item\[(.*)\]\[.*\]/)[1];

            var priceElement = $('#completion-form input[name="item[' + idx + '][price]"]');
            var quantityElement = $('#completion-form input[name="item[' + idx + '][quantity]"]');

            var quantity = quantityElement.val() || 0;
            var restQuantity = quantityElement.attr('max') - quantity;

            var fullPrice = parseFloat(priceElement.attr('max')) + parseFloat(priceElement.attr('min'));
            var reduction = parseFloat(priceElement.val() || "0");

            var total = (restQuantity * reduction) + (quantity * fullPrice);

            $('#completion-form input[name="item[' + idx + '][total]"]').val(total.toFixed(2));

            Refund.calculateTotalTotal();
        },

        fullRefund: function () {
            $('#completion-form input[name$="[quantity]"]').each(function () {
                $(this).val($(this).attr('max'));
                $(this).change();
            });
        },

        submit: function (e) {
            var total = parseFloat($('#line-item-total').html());
            if (total === NaN || total == 0) {
                alert(Refund.emptyRefundMessage);
                e.preventDefault();
            }
        },

        calculateTotalTotal: function () {
            $('#line-item-total').html(0);
            var total = 0
            $('#completion-form input[type=text]').each(function () {
                if ($(this).attr('name').indexOf('total') !== -1) {
                    var val = parseFloat($(this).val());
                    if (val) {
                        total += val;
                    }
                }
            });
            $('#line-item-total').html((total || 0).toFixed(2));
        },

        reset: function () {
            $('#completion-form input[name$="[quantity]"]').each(function () {
                $(this).val($(this).attr('min'));
                $(this).change();
            });
        },

        init: function (message) {
            Refund.emptyRefundMessage = message;
            $("#completion-form input[type=number]").on("change", Refund.change);
            $("#full-refund").on("click", Refund.fullRefund);
            $("#completion-form").on("submit", Refund.submit);
            $("#completion-form").on("reset", Refund.reset);
            $("#completion-form input").each(function (idx, obj) {
                if (obj.max < obj.min) {
                    var newMax = obj.max;
                    obj.min = obj.max;
                    obj.max = newMax;
                }
            });
            Refund.calculateTotalTotal();
        }
    }
})(jQuery);