"use strict";
! function(s) {
    s(window).on("elementor:init", function() {
        var e = elementor.modules.controls.BaseData.extend({
            isControlReady: !1,
            prepareQueryArgs: function() {
                var n = this,
                    s = n.model.get("lazy_args");
                return (s = !_.isObject(s) ? {} : s).widget_props && _.isObject(s.widget_props) && _.each(s.widget_props, function(e, t) {
                    s[t] = n.container.settings.get(e)
                }), s
            },
            sorter:function(data){return data.sort(t.customSort);},
            customSort:function(a,b){
                if (a.text < b.text) {
                    return -1;
                }
                if (a.text > b.text) {
                    return 1;
                }
                return 0;
            },
            getQueryArgs: function() {
                var e = s.extend({}, this.prepareQueryArgs());
                return delete e.widget_props, e
            },
            getTitlesByIDs: function() {
                var n = this,
                    e = this.getControlValue();
                !e || e.length < 1 || (_.isArray(e) || (e = [e]), e = {
                    nonce: ts_lazy.nonce,
                    action: ts_lazy.action,
                    ids: e
                }, s.ajax({
                    url: ts_lazy.ajax_url,
                    type: "POST",
                    data: s.extend({}, e, this.getQueryArgs()),
                    before: n.addControlSpinner(),
                    success: function(e) {
                        e.success || console.log("something went wrong!", e.data);
                        var t = {};
                        n.isControlReady = !0, _.each(e.data, function(e) {
                            t[e.id] = e.text
                        }), n.model.set("options", t), n.render()
                    }
                }))
            },
            addControlSpinner: function() {
                this.ui.select.prop("disabled", !0), this.$el.find(".elementor-control-title").after('<span class="elementor-control-spinner">&nbsp;<i class="eicon-spinner eicon-animation-spin"></i>&nbsp;</span>')
            },
            onReady: function() {
                var t = this;
                this.ui.select.select2({
                    placeholder: t.model.get("placeholder") ? t.model.get("placeholder") : "Type & search",
                    minimumInputLength: t.model.get("mininput") ? t.model.get("mininput") : 1,
                    allowClear: !0,
                    sorter: t.sorter,
                    ajax: {
                        url: ts_lazy.ajax_url,
                        dataType: "json",
                        method: "post",
                        delay: 250,
                        data: function(e) {
                            e = {
                                nonce: ts_lazy.nonce,
                                action: ts_lazy.action,
                                search_term: e.term
                            };
                            return s.extend({}, e, t.getQueryArgs())
                        },
                        processResults: function(e) {
                            return e.success && e.data ? {
                                results: e.data
                            } : (console.log("something went wrong!", e.data), {
                                results: [{
                                    id: -1,
                                    text: "No results found",
                                    disabled: !0
                                }]
                            })
                        },
                        cache: !0
                    }
                }), this.isControlReady || this.getTitlesByIDs()
                this.ui.select.on('select2:select', function (e) {
                       //Append selected element to the end of the list, otherwise it follows the same order as the dropdown
                       var element = e.params.data.element;
                       var $element = $(element);
                       $(this).append($element);
                       $(this).trigger("change");
                });
            },
            onBeforeDestroy: function() {
                this.ui.select.data("select2") && this.ui.select.select2("destroy"), this.$el.remove()
            }
        });
        elementor.addControlView("ts-lazy-select", e)
    })
}(jQuery);