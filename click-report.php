<?php
/*
    Plugin Name: Clube do Valor - Relatório de cliques
    Description: Gera relatório de cliques mais recentes do botão via WPCLI
    Author: Lucas Milanez
    Version: 0.1
*/

if ( !defined( 'CDV_HIT_TABLE' ) ) {
    define('CDV_HIT_TABLE', 'cdv_click_button_hits');
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'click-button-report', 'cdv_click_button_report' );
}

function cdv_click_button_report( $args, $assoc_args ) {
    global $wpdb;

    $table = $wpdb->prefix . CDV_HIT_TABLE;

    try {
		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table'" ) != $table ) {
			throw new Exception( 'Tabela com registro dos cliques não foi encontrada', 0 );
		} else {
            $limit = ( !empty($assoc_args['limit']) ) ? $assoc_args['limit'] : 10;

			$results = $wpdb->get_results("SELECT * FROM $table ORDER BY datetime DESC LIMIT $limit", ARRAY_A);

            if ( empty($results)) {
                throw new Exception( 'Nenhum registro encontrado.', 1 );
            } else {
                WP_CLI::log( 'Exibindo os ' . $limit . ' cliques mais recentes:' );
                WP_CLI\Utils\format_items( 'table', $results, [ 'id', 'datetime' ] );
            }
		}
	} catch (Exception $e) {
		WP_CLI::error( $e->getMessage() );
	}

    exit();
}
