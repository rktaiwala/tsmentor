class TSCryptoWidgetHandler extends elementorModules.frontend.handlers.Base {
    
    getDefaultSettings() {
        return {
            selectors: {
                button: '.ts-crypto-button',
                cryptoInput: '.ts-crypto-input',
                tokenInput: '.ts-token-input',
                errorContainer:'.ts-error-msg',
            },
            crytoValue:this.getElementSettings('crypto_token_value'),
        };
    }
    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {
            $button: this.$element.find( selectors.button ),
            $cryptoInput: this.$element.find( selectors.cryptoInput ),
            $tokenInput: this.$element.find( selectors.tokenInput ),
            $errorContainer: this.$element.find( selectors.errorContainer ),
        };
    }
    bindEvents() {
        console.log(this.elements);
        this.elements.$cryptoInput.on( 'keyup', this.onInputSelectorClick.bind( this ) );
        this.elements.$tokenInput.on( 'keyup', this.onInputSelectorClick.bind( this ) );
    }
    onInputSelectorClick( event ) {
        event.preventDefault();
        this.hideError();
        let error=false;
        let type='';
        if(event.currentTarget.dataset.hasOwnProperty('min')){
            if(Number(event.currentTarget.value)<event.currentTarget.dataset.min || Number(event.currentTarget.value)>event.currentTarget.dataset.max){
                error=true;
            }
            type='crypto';
        }else{
            type='token';
        }
        if((event.currentTarget.value=='')) error=true;
        if(error){
            this.showError('Please enter value within the range',this.$element.find(event.currentTarget));
            return false;
        }
        
        this.calculateTokenValue(type);
        // DO STUFF HERE
        console.log(event);
        
    }
    calculateTokenValue(type){
        let conv=this.getSettings( 'crytoValue' );
        let tkn=this.elements.$tokenInput.val();
        let cryp=this.elements.$cryptoInput.val();
        let chkMin=this.elements.$cryptoInput.data('min');
        let chkMax=this.elements.$cryptoInput.data('max');
        if(type=='crypto'){
            let token=Number(conv) * Number(cryp);
            this.elements.$tokenInput.val(token);
        }else{
            let rvrsCryp=Number(tkn)/Number(conv);
            if(rvrsCryp<Number(chkMin) || (rvrsCryp>Number(chkMax))){
                this.showError('Please enter value within the range',this.elements.$tokenInput);
                return false;
            }
            this.elements.$cryptoInput.val(rvrsCryp);
        }
        this.showButton();
    }
    addErrorClass(element){
        element.addClass('error');
    }
    removeErrorClass(){
        this.elements.$cryptoInput.removeClass('error');
        this.elements.$tokenInput.removeClass('error');
        
    }
    showError(msg,element){
        this.elements.$errorContainer.html(msg);
        this.elements.$errorContainer.css('display','block');
        this.addErrorClass(element);
        this.hideButton();
    }
    hideError(element){
        this.elements.$errorContainer.html('');
        this.removeErrorClass();
    }
    showButton(){
        this.elements.$button.show();
    }
    hideButton(){
        this.elements.$button.hide();
    }
	/**
	 * Update Test Widget Content
	 *
	 * Custom method used by test-widget that inserts the control value using JS.
	 */
	updateTestWidgetContent() {
		if ( ! this.contentWrapper ) {
			const widgetUniqueSelector = `div[data-id="${this.getID()}"] .test-widget`;
			this.contentWrapper = document.querySelector( widgetUniqueSelector );
		}

		this.contentWrapper.innerText = this.getElementSettings( 'some_number' );
	}

	/**
	 * On Init
	 *
	 * Runs when the widget is loaded and initialized in the frontend.
	 */
	onInit() {
		//this.updateTestWidgetContent();
        var self = this;
        this.initElements();
        this.bindEvents();
        this.hideButton();
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
    
  const addHandler = ( $element ) => {
      
    elementorFrontend.elementsHandler.addHandler( TSCryptoWidgetHandler, {
      $element,
    } );
  };
  // Add our handler to the my-elementor Widget (this is the slug we get from get_name() in PHP)
  elementorFrontend.hooks.addAction( 'frontend/element_ready/ts_bnb.default', addHandler );
 } );