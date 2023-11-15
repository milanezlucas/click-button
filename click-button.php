<?php
/*
    Plugin Name: Clube do Valor - Botão
    Description: Shortcode para adicionar botão com contador de cliques
    Author: Lucas Milanez
    Version: 0.1
*/

if ( !defined( 'CDV_HIT_TABLE' ) ) {
    define('CDV_HIT_TABLE', 'cdv_click_button_hits');
}

register_activation_hook( __FILE__, 'cdv_click_button_activation' );
add_shortcode( 'click_button', 'cdv_click_button_shortcode' );
add_action('wp_ajax_cdv_click_button_send_hit', 'cdv_click_button_send_hit');
add_action('wp_ajax_nopriv_cdv_click_button_send_hit', 'cdv_click_button_send_hit');

function cdv_click_button_activation() {
	global $wpdb;

	$table = $wpdb->prefix . CDV_HIT_TABLE;
	$charset = $wpdb->get_charset_collate();

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table'" ) != $table ) {
		$sql = "CREATE TABLE $table (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			datetime datetime NOT NULL,
			PRIMARY KEY  (id)
		) $charset;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}

function cdv_click_button_shortcode() {
	$html = '<button class="click-button">Registrar Clique</button>';

	cdv_click_button_enqueue();

	return $html;
}

function cdv_click_button_enqueue() {
	wp_enqueue_script('cdv_click_button', plugin_dir_url( __FILE__ ) . '/assets/js/click-button.js', ['jquery'], false, true, ['strategy' => 'async']);

	wp_localize_script( 'cdv_click_button', 'cdv_vars', [
		'ajax' => admin_url( 'admin-ajax.php' )
	]);
}

function cdv_click_button_send_hit() {
	global $wpdb;

	try {
		if ( !$wpdb->insert( $wpdb->prefix . CDV_HIT_TABLE, [ 'datetime' => current_time('mysql') ] ) ) {
			throw new Exception( 'Não foi possível contabilizar o clique', 0) ;
		} else {
			wp_send_json_success( [ 'message' => 'Registro adicionado com sucesso!' ], 200 );
		}
	} catch (Exception $e) {
		wp_send_json_error([
			'message' => $e->getMessage(),
			'code' => $e->getCode(),
		], 400);
	}

	exit();
}
