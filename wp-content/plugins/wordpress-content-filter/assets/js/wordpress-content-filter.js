/**
 * jQuery WordPress Content Filter
 * @author     ZuFusion
 */

(function ($) {
    "use strict";


    function WCF_Form(element, options) {

        this.$el = $(element);

        this.options = $.extend({
            scroll_top : 'yes',
            ajax_loader : '<div class="wcf-ajax-loading"></div>',
            ajax_complete: function () {
            }
        }, options);

        // Initialize the plugin instance
        this.init();

    }

    WCF_Form.prototype = {

        //
        // Initialize the plugin instance
        //
        init: function () {
            this.toggle_field();
            this.form_search();
        },

        toggle_field: function () {
            $('.wcf-arrow-field .wcf-label').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);

                $this.parent().find('.wcf-field-body').slideToggle(300, function () {
                    $this.toggleClass('wcf-closed');
                });
            });
        },

        //init date range
        init_date: function (form) {

            $('.range_date_wrapper', form).each(function () {
                var $this = $(this);
                var format_date = $this.data('format-date');
                var dateFrom = $('.date_from', $this);
                var dateTo = $('.date_to', $this);
                if (dateFrom.length > 0) {

                    dateFrom.datepicker({
                        defaultDate: "+1w",
                        changeMonth: false,
                        showOtherMonths: true,
                        dateFormat: format_date,
                        onClose: function (selectDate) {
                            dateTo.datepicker("option", "minDate", selectDate);
                        },
                        showOn: 'button',
                        buttonText: '<span class="dashicons dashicons-calendar-alt"></span>',
                        beforeShow: function (el, ob) {
                            ob.dpDiv.addClass('wcf-date-picker-skin');
                        }
                    });

                    dateTo.datepicker({
                        defaultDate: "+1w",
                        changeMonth: false,
                        showOtherMonths: true,
                        dateFormat: format_date,
                        onClose: function (selectDate) {
                            dateFrom.datepicker("option", "maxDate", selectDate);
                        },
                        showOn: 'button',
                        buttonText: '<span class="dashicons dashicons-calendar-alt"></span>',
                    });

                }
            });
        },

        // init range slider
        init_range_slider: function (form, auto_filter) {

            var _this = this;

            var slider_range = $(".slider-range", form);
            if (slider_range.length > 0) {

                slider_range.each(function () {
                    var $this = $(this),
                        parent = $this.parent(),
                        step = $this.data('step'),
                        emin = $(".range_min", parent),
                        emax = $(".range_max", parent),
                        spanFrom = $("span.range_from", parent.parent()),
                        spanTo = $("span.range_to", parent.parent()),
                        min = emin.data('min'),
                        max = emax.data('max'),
                        currentMin = parseInt(emin.val()),
                        currentMax = parseInt(emax.val());

                    $this.slider({
                        range: true,
                        step: step,
                        min: min,
                        max: max,
                        values: [currentMin, currentMax],
                        slide: function (event, ui) {
                            spanFrom.html(ui.values[0]);
                            spanTo.html(ui.values[1]);
                        },
                        stop: function (event, ui) {

                            emin.val(ui.values[0]);
                            emax.val(ui.values[1]);
                            _this.form_submit(form, auto_filter);

                        },
                        change: function (event, ui) {

                        }
                    });
                });
            }

        },

        init_checkbox: function (form, auto_filter) {

            var _this = this;

            $('.wcf-checkbox-all', form).on('click', function (e) {
                var $this = $(this),
                    parent = $this.closest('.wcf-field-checkbox');
                if ($this.is(':checked')) {
                    parent.find('.wcf-checkbox-item').prop('checked', true);
                } else {
                    parent.find('.wcf-checkbox-item').prop('checked', false);
                }

                _this.form_submit(form, auto_filter);

            });

            $('.wcf-field-checkbox, .wcf-field-checkbox_color', form).each(function () {
                var parent = $(this),
                    all_item = $('.wcf-checkbox-all', parent),
                    item = $('.wcf-checkbox-item', parent),
                    count_item = item.length;
                all_item.on('click', function (e) {

                    var $this = $(this);
                    if ($this.is(':checked')) {
                        item.prop('checked', true);
                    } else {
                        item.prop('checked', false);
                    }

                    _this.form_submit(form, auto_filter);

                });

                item.on('click', function () {

                    if (parent.find('.wcf-checkbox-item:checked').length == count_item) {
                        all_item.prop('checked', true);
                    } else {
                        all_item.prop('checked', false);
                    }

                    _this.form_submit(form, auto_filter);
                });
            })
        },

        form_search: function () {

            var _this = this;
            var $form = this.$el;
            var form_id = $form.data('form');
            var result_layout = $('#wcf-form-wrapper-' + form_id);
            var result_layout_length = result_layout.length;
            var auto = $form.data('auto');
            var pathname = window.location.pathname;
            var enable_ajax = $form.data('ajax');

            if (result_layout_length) {
                if (enable_ajax == 'ajax') {
                    var template_loop = result_layout.data('loop');
                    var columns = result_layout.data('columns');
                    _this.pagination_link(result_layout, form_id, template_loop, columns);
                }
            }

            if (auto == 'yes') {
                //default bind change event for some input type
                $('input[type="text"], input[type="radio"], select, textarea', $form).on('change', function () {
                    $form.submit();
                });
            }

            // process the form
            $form.on('submit', function (event) {

                if (result_layout_length == 0) {
                    // Not found result page then redirect to search.php
                } else {

                    if (enable_ajax == 'ajax') {
                        // stop the form from submitting the normal way and refreshing the page
                        event.preventDefault();

                        var template_loop = result_layout.data('loop');
                        var columns = result_layout.data('columns');

                        var form_data = $form.serialize();
                        window.history.pushState('', document.title, pathname + '?' + form_data);
                        //document.location.search = form_data;
                        result_layout.append(_this.options.ajax_loader);

                        $.post(wcf_variables.ajax_url, {
                            action: 'wcf_search_ajax',
                            wcf_ajax_nonce: wcf_variables.wcf_ajax_nonce,
                            pathname: pathname,
                            search: form_data,
                            form_id: form_id,
                            loop: template_loop,
                            result_columns: columns,
                        }, function (response) {
                            result_layout.animate(
                                {opacity: 0},
                                500,
                                function () {
                                    $(this).html(response).animate(
                                        {opacity: 1},
                                        500, function () {
                                            if (_this.options.scroll_top == 'yes') {
                                                _this.scroll_top();
                                            }
                                            _this.pagination_link(result_layout, form_id, template_loop, columns);
                                        }
                                    );
                                }
                            );

                        });

                    } else {
                        $form.attr('action', '');
                    }

                }

            });

            // init form fields
            _this.init_date($form);
            _this.init_checkbox($form, auto);
            _this.init_range_slider($form, auto);

        },
        // use
        ajax_call: function (wrapper, form_id, template_loop, columns) {
            wrapper.trigger("wcf_form_search_ajax_done", [wrapper, form_id, template_loop, columns]);
        },

        form_submit: function (form, auto_filter) {

            if (auto_filter == 'yes') {
                form.submit();
            }
        },

        pagination_link: function (wrapper, form_id, template_loop, columns) {
            var _this = this;
            $('.wcf-pagination a', wrapper).unbind().bind('click', function (e) {

                e.preventDefault();

                var page_number = $(this).data('page');
                var link = $(this).attr('href');
                var link_info = document.createElement("a");
                link_info.href = link;

                window.history.pushState('', document.title, link_info.pathname + link_info.search);
                wrapper.append(_this.options.ajax_loader);

                var pathname = window.location.pathname;
                var search = window.location.search;
                if (search != '') {
                    if (search.substring(0, 1) == "?") {
                        search = search.replace('?', '');
                    }
                }

                $.post(wcf_variables.ajax_url, {
                    action: 'wcf_search_ajax',
                    wcf_ajax_nonce: wcf_variables.wcf_ajax_nonce,
                    pathname: pathname,
                    search: search,
                    page_number: page_number,
                    form_id: form_id,
                    loop: template_loop,
                    result_columns: columns,
                }, function (response) {

                    wrapper.animate(
                        {opacity: 0},
                        500,
                        function () {
                            $(this).html(response).animate(
                                {opacity: 1},
                                500, function () {
                                    if (_this.options.scroll_top == 'yes') {
                                        _this.scroll_top();
                                    }
                                    _this.pagination_link(wrapper, form_id, template_loop, columns);
                                    _this.ajax_call(wrapper, form_id, template_loop, columns);
                                    if ($.isFunction(_this.options.ajax_complete)) {
                                        _this.options.ajax_complete.call(_this);
                                    }
                                }
                            );
                        }
                    );

                });

            });
        },

        scroll_top: function () {
            $("html, body").animate({scrollTop: 0}, 200);
        },

    };


    $.fn.WCFilter = function (options) {
        return this.each(function () {

            if (!$.data(this, 'plugin_wcfilter')) {
                $.data(this, 'plugin_wcfilter', new WCF_Form(this, options));
            }
        });
    };

    $(document).ready(function () {
        var options = {

            scroll_top: wcf_variables.scroll_top,
        };

        if (wcf_variables.ajax_loader !='') {
            options.ajax_loader = '<div class="wcf-ajax-loading" style="background-image: url('+wcf_variables.ajax_loader+');"></div>';
        }

        var WCF_Frontend = $('.wcf-form-search').WCFilter(options);
    });


})(jQuery);