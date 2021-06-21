<?php

namespace WPEssential\Plugins\Theme;

use WPEssential\Plugins\Utility\OptionsPannel;
use WPEssential\Plugins\Utility\Tgm;

final class Setup
{
	private static $theme_space;

	public static function constructor ()
	{
		add_action(
			'wpe_setup_theme',
			function ()
			{
				add_action(
					'after_setup_theme',
					function ()
					{
						self::constants();
						add_action( 'wp_body_open', 'wpe_header_template', 10 );
						self::theme_clases();
						self::register();
						add_action( 'wp_footer', 'wpe_footer_template', 0 );
					},
					2000
				);
			},
			1000
		);
	}

	public static function constants ()
	{
		$theme_info        = wpe_theme_info();
		self::$theme_space = $theme_info->NameSpace;
		$theme_constant    = apply_filters( 'wpe/theme/constants', [
			"{$theme_info->UcwordsNameHyphen}_T_VER"      => $theme_info->Version,
			"{$theme_info->UcwordsNameHyphen}_T_DIR"      => get_template_directory() . '/',
			"{$theme_info->UcwordsNameHyphen}_T_FILE_DIR" => get_theme_file_path() . '/',
			"{$theme_info->UcwordsNameHyphen}_T_URI"      => get_template_directory_uri() . '/',
			"{$theme_info->UcwordsNameHyphen}_T_FILE_URI" => get_theme_file_uri() . '/'
		] );

		$theme_constant = apply_filters( 'wpe/theme_constant', $theme_constant );

		$theme_constant = array_filter( $theme_constant );
		if ( $theme_constant && is_array( $theme_constant ) ) {
			foreach ( $theme_constant as $constant => $key ) {
				wpe_maybe_define_constant( $constant, $key );
			}
		}
	}

	public static function theme_clases ()
	{
		$theme_space  = self::$theme_space;
		$theme_loader = "\\WPEssential\\Theme\\$theme_space\\Loader";
		if ( class_exists( $theme_loader ) ) {
			$theme_loader::constructor();
		}
	}

	public static function register ()
	{
		do_action( 'wpe_before_theme_setup' );
		Support::constructor();
		Images::constructor();
		Sidebars::constructor();
		Editor::constructor();
		Menus::constructor();
		if ( defined( 'WPE_TGM' ) && true === WPE_TGM ) {
			Tgm::constructor();
		}
		OptionsPannel::constructor();
		Widgets::constructor();
	}
}
