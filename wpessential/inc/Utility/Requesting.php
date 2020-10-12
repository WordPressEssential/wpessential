<?php

namespace WPEssential\Plugins\Utility;

use WPEssential\Plugins\Helper\Help;
use WPEssential\Plugins\Helper\AuthGuard;

final class Requesting
{
	use Help, AuthGuard;

	public static function constructor ()
	{
		add_action( 'wp_ajax_nopriv_auth', [ __CLASS__, 'login' ] );
		add_action( 'wp_ajax_auth', [ __CLASS__, 'login' ] );
		//add_action( 'wp_ajax_settings_args', [ __CLASS__, 'settings_args' ] );

		add_action( 'wp_ajax_theme_options', [ '\\WPEssential\\Plugins\\Utility\\ThemeOptionsInit', 'options' ] );
		add_action( 'wp_ajax_save_options', [ '\\WPEssential\\Plugins\\Utility\\ThemeOptionsInit', 'save' ] );

		add_action( 'wp_ajax_plugin_options', [ '\\WPEssential\\Plugins\\Utility\\PluginOptionsInit', 'options' ] );
		add_action( 'wp_ajax_plugin_save_options', [ '\\WPEssential\\Plugins\\Utility\\PluginOptionsInit', 'save' ] );

		add_action( 'wp_ajax_get_image_from_url', [ __CLASS__, 'get_image_from_url' ] );
	}

	public static function login ()
	{
		wpe_ajax_authorized();

		$data                    = [];
		$data[ 'user_login' ]    = sanitize_text_field( wpe_array_get( $_POST, 'user_login' ) );
		$data[ 'user_password' ] = sanitize_text_field( wpe_array_get( $_POST, 'user_password' ) );
		self::authorized( $data );
	}

	public static function registrar ()
	{

	}

	/*public static function settings_args ()
	{
		wpe_ajax_authorized();

		$settings = apply_filters( 'wpe/settings/args', [] );
		wp_send_json_success( $settings );
	}*/

	public static function get_image_from_url ()
	{
		wpe_ajax_authorized();

		$image_url = sanitize_text_field( wpe_array_get( $_POST, 'user' ) );
		wpe_error( self::get_image_from_url() );
		return;
	}
}