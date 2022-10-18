"use strict";
! function(c, d) {
    c(function() {
        var a = c(".ts-dashboard-tabs"),
            e = a.find(".ts-dashboard-tabs__nav"),
            i = a.find(".ts-dashboard-tabs__content"),
            s = c("#toplevel_page_ts-addons").find(".wp-submenu"),
            t = (e.on("click", ".ts-dashboard-tabs__nav-item", function(a) {
                var e = c(a.currentTarget),
                    t = c(a.currentTarget).find('a')[0].hash,
                    n = "#tab-content-" + t.substring(1),
                    n = i.find(n);
                if (e.is(".nav-item-is--link")) return !0;
                a.preventDefault(), e.addClass("tab--is-active").siblings().removeClass("tab--is-active"), n.addClass("tab--is-active").siblings().removeClass("tab--is-active"), window.location.hash = t
            }), window.location.hash && (e.find('a[href="' + window.location.hash + '"]').click()), s.on("click", "a", function(a) {
                return !a.currentTarget.hash || (a.preventDefault(), window.location.hash = a.currentTarget.hash, c(a.currentTarget).parent().addClass("current").siblings().removeClass("current"), void e.find('a[href="' + a.currentTarget.hash + '"]').click())
            })),
            o = t.find(".ts-dashboard-widgets"),
            n = t.find(".ts-dashboard-btn--save");
        
    })
}(jQuery, window.HappyDashboard);