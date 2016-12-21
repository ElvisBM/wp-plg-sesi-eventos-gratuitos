<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              elvisbmartins.com.br
 * @since             1.0.0
 * @package           Sesi_Eventos_Gratuitos
 *
 * @wordpress-plugin
 * Plugin Name:       Sesi Eventos Gratuitos
 * Plugin URI:        www.pegadacultural.com.br
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Elvis B. Martins
 * Author URI:        elvisbmartins.com.br
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sesi-eventos-gratuitos
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sesi-eventos-gratuitos-activator.php
 */
function activate_sesi_eventos_gratuitos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sesi-eventos-gratuitos-activator.php';
	Sesi_Eventos_Gratuitos_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sesi-eventos-gratuitos-deactivator.php
 */
function deactivate_sesi_eventos_gratuitos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sesi-eventos-gratuitos-deactivator.php';
	Sesi_Eventos_Gratuitos_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sesi_eventos_gratuitos' );
register_deactivation_hook( __FILE__, 'deactivate_sesi_eventos_gratuitos' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sesi-eventos-gratuitos.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sesi_eventos_gratuitos() {

	$plugin = new Sesi_Eventos_Gratuitos();
	$plugin->run();

}
run_sesi_eventos_gratuitos();
