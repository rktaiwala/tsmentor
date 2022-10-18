class TSTBHandler extends elementorModules.frontend.handlers.Base {
    
    getDefaultSettings() {
        return {
            selectors: {
                header: '.ts-tb-header',
                headerItem: '.ts-tb-header a',
            },
        };
    }
    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {
            $header: this.$element.find( selectors.header ),
            $headerItem: this.$element.find( selectors.headerItem ),
        };
    }
    bindEvents() {
        console.log(this.elements);
        this.elements.$headerItem.on( 'click', this.onHeaderItemClicked.bind( this ) );
    }
    onHeaderItemClicked( event ) {
        event.preventDefault();
        let hrf=jQuery(event.currentTarget).attr('href');
        var target = jQuery(hrf);
        if (target.length) {
            jQuery('html,body').animate({
                scrollTop: target.offset().top-jQuery('div[data-elementor-type="header"]').height()
            }, 1000);
            return false;
        }
        
        
    }
    

	/**
	 * On Element Change
	 *
	 * Runs every time a control value is changed by the user in the editor.
	 *
	 * @param {string} propertyName - The ID of the control that was changed.
	 */
	

}

/**
 * Register JS Handler for the Test Widget
 *
 * When Elementor frontend was initiated, and the widget is ready, register the widet
 * JS handler.
 */
jQuery( window ).on( 'elementor/frontend/init', () => {
    
  elementorFrontend.elementsHandler.attachHandler( 'ts_tb', TSTBHandler );
  
 } );