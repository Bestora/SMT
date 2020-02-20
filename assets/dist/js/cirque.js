;(function ($, window, undefined) {
    var pluginName = 'cirque',
        document = window.document,
        defaults = {
            value: 0,
            radius: 60,
            total: 100,
            label: 'percent',
            lineWidth: 10,
            arcColor: '#0066CC',
            trackColor: '#EEEEEE',
            trackFill: 'transparent',
            animate: true,
            speed: 50
        };

    function supports_canvas() {
        return !!document.createElement('canvas').getContext;
    }

    function Cirque(element, options) {
        this.element = element;
        this.options = $.extend({}, defaults, options, $(this.element).data());
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Cirque.prototype.init = function () {
        if (!supports_canvas()) {
            return false;
        }
        var container, canvas, track, value, canvasId, valueDisplay;

        container = this.makeContainer();
        canvas = this.makeCanvas();
        track = this.makeTrack();

        this.arcContext = canvas.get(0).getContext("2d");
        this.trackContext = track.get(0).getContext("2d");
        this.drawTrack();

        value = this.makeValue();

        if (this.options.animate) {
            this.start();
        } else {
            this.drawArc(deg((this.options.value / this.options.total) * 360));
        }
    };

    Cirque.prototype.start = function () {
        var count = 1;
        var that = this;

        var decimal = this.options.value / this.options.total;
        var step = decimal / 50;

        var interval = setInterval(function () {

            if (count > 50 - 2) {
                clearInterval(interval);
            }

            count++;

            endAngle = deg((step * count) * 360);
            that.drawArc(endAngle);
        }, that.options.speed);
    };

    Cirque.prototype.drawArc = function (endAngle) {
        this.arcContext.clearRect(0, 0, this.options.radius * 2, this.options.radius * 2);
        this.arcContext.beginPath();
        this.arcContext.strokeStyle = this.options.arcColor;
        this.arcContext.arc(this.options.radius, this.options.radius, this.options.radius - this.options.lineWidth, deg(0), endAngle);
        this.arcContext.lineWidth = this.options.lineWidth;
        this.arcContext.stroke();
    };


    $.fn['cirque'] = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Cirque(this, options));
            }
        });
    };

    Cirque.prototype.drawTrack = function () {
        this.trackContext.beginPath();
        this.trackContext.strokeStyle = this.options.trackColor;
        this.trackContext.arc(this.options.radius, this.options.radius, this.options.radius - this.options.lineWidth, 0, 360);
        this.trackContext.lineWidth = this.options.lineWidth;
        this.trackContext.fillStyle = this.options.trackFill;
        this.trackContext.fill();
        this.trackContext.stroke();
    };

    function deg(deg) {
        return (Math.PI / 180) * deg - (Math.PI / 180) * 90;
    }

    Cirque.prototype.makeValue = function () {
        var value, valueDisplay, labelClass;

        if (this.options.label == 'percent') {
            value = Math.round(((this.options.value / this.options.total) * 100) * Math.pow(10, 2)) / Math.pow(10, 2);
            valueDisplay = value + '%';
            labelClass = 'percent';
        } else {
            value = this.options.value;
            valueDisplay = value + '/' + this.options.total;
            labelClass = 'ratio';
        }

        return $('<div>', {'class': 'cirque-label'})
            .appendTo(this.element)
            .html(valueDisplay)
            .addClass(labelClass)
            .css({'width': this.options.radius * 2})
            .css({'height': this.options.radius * 2})
            .css({'line-height': this.options.radius * 2 + 'px'});
    };

    Cirque.prototype.makeCanvas = function () {
        return $('<canvas/>', {})
            .appendTo(this.element)
            .attr('width', this.options.radius * 2)
            .attr('height', this.options.radius * 2)
            .addClass('cirque-fill');
    };

    Cirque.prototype.makeTrack = function () {
        return $('<canvas/>', {})
            .appendTo(this.element)
            .attr('width', this.options.radius * 2)
            .attr('height', this.options.radius * 2)
            .addClass('cirque-track');
    };

    Cirque.prototype.makeContainer = function () {
        return $(this.element).addClass('cirque-container')
            .css({'width': this.options.radius * 2})
            .css({'height': this.options.radius * 2});
    }
}(jQuery, window));


$(function () {
    Application.init();
});

var Application = function () {
    var validationRules = getValidationRules();
    return {init: init, validationRules: validationRules};

    function init() {
        enableBackToTop();
        enableLightbox();
        enableCirque();
        enableEnhancedAccordion();

        $('.ui-tooltip').tooltip();
        $('.ui-popover').popover();
    }

    function enableCirque() {
        if ($.fn.lightbox) {
            $('.ui-lightbox').lightbox();
        }
    }

    function enableLightbox() {
        if ($.fn.cirque) {
            $('.ui-cirque').cirque({});
        }
    }

    function enableBackToTop() {
        var backToTop = $('<a>', {id: 'back-to-top', href: '#top'});
        var icon = $('<i>', {class: 'icon-chevron-up'});

        backToTop.appendTo('body');
        icon.appendTo(backToTop);
        backToTop.hide();

        $(window).scroll(function () {
            if ($(this).scrollTop() > 150) {
                backToTop.fadeIn();
            } else {
                backToTop.fadeOut();
            }
        });

        backToTop.click(function (e) {
            e.preventDefault();
            $('body, html').animate({
                scrollTop: 0
            }, 600);
        });
    }

    function enableEnhancedAccordion() {
        $('.accordion-toggle').on('click', function (e) {
            $(e.target).parent().parent().parent().addClass('open');
        });

        $('.accordion-toggle').on('click', function (e) {
            $(this).parents('.panel').siblings().removeClass('open');
        });
    }

    function getValidationRules() {
        var custom = {
            focusCleanup: false,
            wrapper: 'div',
            errorElement: 'span',

            highlight: function (element) {
                $(element).parents('.form-group').removeClass('success').addClass('error');
            },

            success: function (element) {
                $(element).parents('.form-group').removeClass('error').addClass('success');
                $(element).parents('.form-group:not(:has(.clean))').find('div:last').before('<div class="clean"></div>');
            },

            errorPlacement: function (error, element) {
                error.prependTo(element.parents('.form-group'));
            }
        };

        return custom;
    }
}();

