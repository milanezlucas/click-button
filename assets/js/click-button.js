(function( $ ) {
	'use strict';

    if ( $(document).find('.click-button').length ) {
        cdv_click_button();
    }

    function cdv_click_button() {
        $('.click-button').each(function () {
            $(this).click(function (e) { 
                e.preventDefault();
                
                cdv_send_hit($(this));
                if ( typeof dataLayer == 'object' ) {
                    dataLayer.push({
                        'event': 'click_button',
                    });
                }
            });
        });
    }

    function cdv_send_hit(button) {
        var buttonLabel = button.text();
        $.ajax({
            type: 'POST',
            url: cdv_vars.ajax,
            data: {
                action: 'cdv_click_button_send_hit',
            },
			beforeSend: function () {
		    	button.text('Registrando...');
			},
            success: function (rs) {
                button.text(rs.data.message);
                
                setTimeout(() => {
                    button.text(buttonLabel);
                }, 2000);
            },
            error: function (rs) {
                button.text(rs.data.message);
            }
		})
    }
})( jQuery );
