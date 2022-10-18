class TSCatWidgetHandler extends elementorModules.frontend.handlers.Base {
    
    getDefaultSettings() {
        return {
            selectors: {
                wrapper: '.ts-ctx-list-wrapper',
                container: '.ts-ctx-list-container',
                item: '.ts-ctx-item',
            },
        };
    }
    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {
            $wrapper: this.$element.find( selectors.wrapper ),
            $container: this.$element.find( selectors.container ),
            $item: this.$element.find( selectors.item ),
        };
    }
    
    onInit() {
		if ( this.isActive( this.getSettings() ) ) {
			elementorModules.ViewModule.prototype.onInit.apply( this, arguments );
            let ele_cont='.elementor-element-'+this.getID();
            this.adjustHeight();
            const swiper = new Swiper(ele_cont +" .ts-ctx-list-container" , {
              // Navigation arrows
                slidesPerView: 3,
                spaceBetween: 20,
              navigation: {
                nextEl: ele_cont+' .ts-button-next',
                prevEl: ele_cont+' .ts-button-prev',
              },

            });
		}
	}
    adjustHeight(){
        let ele_cont='.elementor-element-'+this.getID();
        this.elements.$wrapper.height(Math.max(this.elements.$container.outerHeight(),this.elements.$item.outerHeight())+30);
        if(jQuery(ele_cont +" .ts-ctx-list-container").hasClass('profile')) return true;
        var maxHeight = Math.max.apply(null, this.elements.$item.map(function ()
                        {
                            return jQuery(this).height();
                        }).get());
        this.elements.$item.each(function(){jQuery(this).height(maxHeight)})
        console.log(maxHeight);
    }
	/**
	 * On Element Change
	 *
	 * Runs every time a control value is changed by the user in the editor.
	 *
	 * @param {string} propertyName - The ID of the control that was changed.
	 */
	isActive( settings ) {
        return settings.$element.find('.ts-ctx-list-wrapper').hasClass('slider');
   }	

}

/**
 * Register JS Handler for the Test Widget
 *
 * When Elementor frontend was initiated, and the widget is ready, register the widet
 * JS handler.
 */
jQuery( window ).on( 'elementor/frontend/init', () => {
    
  elementorFrontend.elementsHandler.attachHandler( 'ts_cat', TSCatWidgetHandler,'classic' );
  elementorFrontend.elementsHandler.attachHandler( 'ts_cat', TSCatWidgetHandler,'profile' );
  // Add our handler to the my-elementor Widget (this is the slug we get from get_name() in PHP)
  //elementorFrontend.hooks.addAction( 'frontend/element_ready/ts_cat.default', addHandler );
 } );