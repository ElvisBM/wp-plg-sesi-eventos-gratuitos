<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       elvisbmartins.com.br
 * @since      1.0.0
 *
 * @package    Sesi_Eventos_Gratuitos
 * @subpackage Sesi_Eventos_Gratuitos/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sesi_Eventos_Gratuitos
 * @subpackage Sesi_Eventos_Gratuitos/includes
 * @author     Elvis B. Martins <elvisbmartins@gmail.com>
 */
class Sesi_Eventos_Gratuitos_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sesi-eventos-gratuitos',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
