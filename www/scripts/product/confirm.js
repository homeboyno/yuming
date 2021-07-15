/* ========================================================================
 * Aurora: Confirm.js v0.1.0
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */

+ function($) {
    'use strict';

    function Confirm(element, options) {
        this.options = $.extend({}, Confirm.DEFAULTS, options)
        this.element = element
        this.$modal = $('\
            <div class="modal confirm fade" tabindex="-1" role="dialog"> \
                <div class="modal-dialog" role="document"> \
                    <div class="modal-content"> \
                        <div class="modal-body"> \
                        </div> \
                        <div class="modal-footer"> \
                            <button cancel></button> \
                            <button confirm></button> \
                        </div> \
                    </div> \
                </div> \
            </div> \
        ')

        this.init()
    }

    Confirm.VERSION = '0.1.0'

    Confirm.DEFAULTS = {
        title: '确认',
        cancel_text: '取消',
        confirm_text: '确认'
    }

    Confirm.prototype.init = function() {
        var that = this

        this.$modal.find('.modal-body').append("<h4 title>" + this.options.title + "</h4>")
        if (this.options.tips) {
            this.$modal.find('.modal-body').append("<p tips>" + this.options.tips + "</p>")
        }
        if (this.options.extra) {
            this.$modal.find('.modal-body').append(this.options.extra)
        }
        this.$modal.find('[confirm]').text(this.options.confirm_text)
            .on('click.aurora.confirm', function() {
                if (that.options.confirm) {
                    that.options.confirm()
                }
                that.$modal.modal('hide')
            })
        this.$modal.find('[cancel]').text(this.options.cancel_text)
            .on('click.aurora.cancel', function() {
                if (that.options.cancel) {
                    that.options.cancel()
                }
                that.$modal.modal('hide')
            })
        this.$modal.on('hidden.bs.modal', function() {
            if (that.options.cancel) {
                that.options.cancel()
            }
        })

        $(that.element).on('click.aurora.confirm', function() {
            that.show()
        })
    }

    Confirm.prototype.show = function() {
        $('body').append(this.$modal)
        this.$modal.modal('show')
    }

    function Plugin(option) {
        return this.each(function() {
            var $this = $(this)
            var data = $this.data('aurora.confirm')
            var options = $.extend({}, Confirm.DEFAULTS, $this.data(), typeof option == 'object' && option)

            if (!data) $this.data('aurora.confirm', (data = new Confirm(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    var old = $.fn.confirm

    $.fn.confirm = Plugin
    $.fn.confirm.Constructor = Confirm

    // CONFIRM NO CONFLICT
    // ====================
    $.fn.confirm.noConflict = function() {
        $.fn.confirm = old
        return this
    }
}(jQuery);
