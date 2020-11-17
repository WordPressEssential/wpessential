<?php

namespace WPEssential\Plugins;

use WPEssential\Plugins\Theme\Setup;
use WPEssential\Plugins\Utility\BuildersInit;
use WPEssential\Plugins\Utility\RegisterPostStatus;
use WPEssential\Plugins\Utility\Requesting;
use WPEssential\Plugins\Utility\RegisterAssets;
use WPEssential\Plugins\Utility\Enqueue;
use WPEssential\Plugins\Utility\RestApi;

final class Loader
{
	/**
	 * The set the editor for shortcodes page builders.
	 *
	 * @var string
	 */
	public static string $editor;

	/**
	 * Set the callback to be used for determining the editor type for shortcodes page builders.
	 *
	 * @param $callback
	 * @return void
	 */
	public static function editor ( $callback )
	{
		self::$editor = $callback;
	}

	public static function constructor ()
	{
		self::load_files();
		self::autoload();
		self::start();

		add_action( 'plugins_loaded', [ __CLASS__, 'on_plugins_loaded' ], - 1 );
		add_action( 'plugins_loaded', [ __CLASS__, 'autoload' ], 100 );
		add_action( 'init', [ __CLASS__, 'init' ], 1000 );
	}

	/**
	 * When WP has loaded all plugins, trigger the `woocommerce_loaded` hook.
	 *
	 * This ensures `woocommerce_loaded` is called only after all other plugins
	 * are loaded, to avoid issues caused by plugin directory naming changing
	 * the load order. See #21524 for details.
	 *
	 * @since 1.0.0
	 */
	public static function on_plugins_loaded ()
	{
		do_action( 'wpessential_loaded' );
	}

	public static function autoload ()
	{
		$theme_name = wp_get_theme();
		$theme_name = str_replace( [ ' ', '_', '-' ], '', $theme_name->get( 'Name' ) );
		$psr        = [
			'WPEssential\\Plugins\\'              => WPE_DIR . 'inc/',
			"WPEssential\\Theme\\{$theme_name}\\" => get_template_directory() . '/inc/',
		];

		$class_loader = new Libraries\ClassLoader;

		foreach ( $psr as $prefix => $paths ) {
			$class_loader->addNamespace( $prefix, $paths );
		}

		$class_loader->register();

	}

	public static function load_files ()
	{
		require_once WPE_DIR . 'inc/functions.php';
		require_once WPE_DIR . 'inc/Libraries/ClassLoader.php';
		require_once WPE_DIR . 'inc/query-functions.php';
		require_once WPE_DIR . 'inc/template-functions.php';
	}

	public static function start ()
	{
		Requesting::constructor();
		RegisterAssets::constructor();
		Enqueue::constructor();
		Setup::constructor();
		//RestApi::constructor();
	}

	public static function init ()
	{
		do_action( 'wpessential_init' );
		load_plugin_textdomain( 'wpessential', false, WPE_DIR . '/language' );
		RegisterPostStatus::constructor();
		BuildersInit::constructor();
	}

	public static function options ()
	{
		return get_option( WPE_SETTINGS, [] );
	}

	public static function options_update ( array $data )
	{
		$options = wp_parse_args( $data, self::options() );
		$boolean = update_option( WPE_SETTINGS, $options );
		return $boolean;
	}
}
