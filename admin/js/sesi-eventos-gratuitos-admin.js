(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 jQuery(document).ready( function($) {

		  $('#btn_get_event_sesi').click(function(){

				$("#btn_get_event_sesi").prepend('<img id="loade" src="../wp-content/plugins/sesi-eventos-gratuitos/admin/js/loaded.gif" />'); 		
		        $("#btn_get_event_sesi").addClass("buscando");
		        
		        var data = {
		            action: 'sesi_eventos_gratuitos',
		        };

		        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		        $.post(ajaxurl, data, function(response) {

		        	if( response == 1 ){
		        		alert("Base de evento do SESI atualizado, não há novos eventos!");
		        	}else{
		        		alert("Eventos do SESI atualizado, " + response + " novos eventos");
		        	}

		        	$("#btn_get_event_sesi > img").remove();
		        	$("#btn_get_event_sesi").removeClass("buscando");

		        });

		      
		    });


	});

})( jQuery );
