<?php
/**
 * Plugin Name: Easy Digital Downloads Slack Integration
 * Description: Send notifications of new order to a Slack channel.
 * Author: DesignWall
 * Author URI: https://www.designwall.com
 * Version: 1.0.0
 * Plugin URI: https://www.designwall.com/wordpress/dwqa-extensions/dwqa-slack/
 * License: GNU GPLv2+
 */

if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'EDD_Slack_Integration' ) ) :

class EDD_Slack_Integration {
	public function __construct() {

	}

	public static function instance() {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self();
			$instance->setup_actions();
		}

		return $instance;
	}

	private function setup_actions() {
		add_filter( 'edd_settings_tabs', array( $this, 'add_tab' ) );
		add_filter( 'edd_settings_sections', array( $this, 'add_section' ) );
		add_filter( 'edd_registered_settings', array( $this, 'add_fields' ) );
	}

	public function add_tab( $tabs ) {
		if ( !isset( $tabs['integration'] ) ) {
			$tabs['integration'] = __( 'Integration', 'edd-slack' );
		}

		return $tabs;
	}

	public function add_section( $sections ) {
		$sections['integration']['slack'] = __( 'Slack', 'edd-slack' );

		return $sections;
	}

	public function add_fields( $fields ) {
		$fields['integration']['slack'] = array(
			'slack_settings' => array(
				'id' => 'slack_settings',
				'name' => '<h3>'. __( 'Slack', 'edd-slack' ) .'</h3>',
				'type' => 'header'
			),
			'api_key' => array(
				'id' => 'api_key',
				'name' => __( 'API Key', 'edd-slack' ),
				'type' => 'text',
				'desc' => sprintf( "<br>Go to your <a target=\"_blank\" href=\"%s\">Slack Account's API / Token Settings</a> and copy the token provided. If there is no token yet, you'll need to press the \"Create Token\" button in the Authentication section. You may need to refresh after save to see your rooms.", 'https://api.slack.com/docs/oauth-test-tokens' )
			),
			'notification_event' => array(
				'id' => 'notification_event',
				'name' => '<h3>' . __( 'Notification Event', 'edd-slack' ) . '</h3>',
				'type' => 'header'
			),
			'notification_new_order' => array(
				'id' => 'notification_new_order',
				'name' => __( 'New Order', 'edd-slack' ),
				'type' => 'checkbox',
				'desc' => __( 'Enable', 'edd-slack' )
			),
			'notification_new_order_message' => array(
				'id' => 'notification_new_order_message',
				'name' => null,
				'type' => 'textarea',
				'desc' => '<strong>' .__( 'Tags:', 'edd-slack' ) . '</strong> {order_id} | {order_items} | {order_total} | {order_link} | {username}'
			),
		);

		return $fields;
	}

	public function get_option( $key, $default = null ) {
		$options = get_option( 'edd_options', array() );

		$value = $default;
		if ( isset( $options[ $key ] ) ) {
			$value = $options[ $key ];
		}

		return apply_filters( 'edd_slack_get_option', $value, $key, $default );
	}

	public function http_post( $request_data ) {
		$url = 'https://slack.com/api/chat.postMessage';
		
		if ( function_exists( 'wp_remote_post' ) ) {

		} else {

		}
	}
}

$GLOBALS['edd_slack_integration'] = EDD_Slack_Integration::instance();

endif;