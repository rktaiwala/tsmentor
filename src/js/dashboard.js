"use strict";
! function(c, d) {
    c(function() {
        var a = c(".ts-dashboard-tabs"),
            e = a.find(".ts-dashboard-tabs__nav"),
            i = a.find(".ts-dashboard-tabs__content"),
            //s = c("#toplevel_page_happy-addons").find(".wp-submenu"),
            t = (e.on("click", ".ts-dashboard-tabs__nav-item", function(a) {
                var e = c(a.currentTarget),
                    t = a.currentTarget.hash,
                    n = "#tab-content-" + t.substring(1),
                    n = i.find(n);
                if (e.is(".nav-item-is--link")) return !0;
                a.preventDefault(), e.addClass("tab--is-active").siblings().removeClass("tab--is-active"), n.addClass("tab--is-active").siblings().removeClass("tab--is-active"), window.location.hash = t, s.find("a").filter(function(a, e) {
                    return t === e.hash
                }).parent().addClass("current").siblings().removeClass("current")
            }), window.location.hash && (e.find('a[href="' + window.location.hash + '"]').click(), s.find("a").filter(function(a, e) {
                return window.location.hash === e.hash
            }).parent().addClass("current").siblings().removeClass("current")), s.on("click", "a", function(a) {
                return !a.currentTarget.hash || (a.preventDefault(), window.location.hash = a.currentTarget.hash, c(a.currentTarget).parent().addClass("current").siblings().removeClass("current"), void e.find('a[href="' + a.currentTarget.hash + '"]').click())
            })),
            o = t.find(".ts-dashboard-widgets"),
            n = t.find(".ts-dashboard-btn--save");
        
    })
}(jQuery, window.HappyDashboard);