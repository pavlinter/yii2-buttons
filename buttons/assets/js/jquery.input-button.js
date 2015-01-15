(function($) {

    var InputButton = function (element, options) {
        var self = this;
        self.$el = $(element);
        self.init(options);
    }

    InputButton.prototype = {
        constructor: InputButton,
        init: function (options) {
            var self = this, $el = self.$el;
            $el.on("click.inputButton", function(e){
                var $inp = $("#" + options.inputId), $form = $(options.formSelector);
                $inp.remove();
                if(options.inputValue !== null){
                    $inp = $(options.inputTemplate);
                    $form.append($inp);
                    $inp.val(options.inputValue);
                    var event = $.Event("change.inputButton");
                    $inp.trigger(event, [self, options]);
                    if(event.result !== false) {
                        $form.submit();
                        return false;
                    }
                } else {
                    $form.submit();
                }
                return false;
            });
        },
        destroy: function () {
            var self = this, $el = self.$element;
            $el.off('.inputButton').removeData('inputButton');
        }
    };

    $.fn.inputButton = function (option) {
        var args = Array.apply(null, arguments);
        args.shift();
        return this.each(function () {
            var $this = $(this),
                data = $this.data("inputButton"),
                options = typeof option === "object" && option;

            if (!data) {
                $this.data("inputButton", (data = new InputButton(this, $.extend({}, $.fn.inputButton.defaults, options, $(this).data()))));
            }

            if (typeof option === "string") {
                data[option].apply(data, args);
            }
        });
    };

    $.fn.inputButton.defaults = {};

})(jQuery);