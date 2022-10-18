"use strict";
! function($) {
    $('.ts-filter-main-container .ts-filter-title').click(function(e) {
        e.preventDefault();
        let $this = $(this);
        if ($this.next().hasClass('show')) {
            $this.next().removeClass('show');
            $this.next().slideUp(350);
        } else {
            $this.next().toggleClass('show');
            $this.next().slideToggle(350);
        }
    });
    jQuery('.ts-filter-taxonomy-header').on('click',function(e){
        //jQuery('').find('.ts-filter-taxonomy-header').removeClass('');
        jQuery(this).toggleClass('ts-filter-open');
        jQuery(this).next().slideToggle('slow');
    })
}(jQuery);