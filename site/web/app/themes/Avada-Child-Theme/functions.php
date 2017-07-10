<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

function register_my_menu() {
  register_nav_menu('mobile-header-menu',__( 'Mobile Header Menu' ));
}
add_action( 'init', 'register_my_menu' );

if ( ! function_exists( 'avada_main_menu' ) ) {
	/**
	 * The main menu.
	 *
	 * @param bool $flyout_menu Whether we want the flyout menu or not.
	 */
	function avada_main_menu( $flyout_menu = false ) {

		$menu_class = 'fusion-menu';
		if ( 'v7' === Avada()->settings->get( 'header_layout' ) ) {
			$menu_class .= ' fusion-middle-logo-ul';
		}

		
		if (is_mobile())
		{
			$menu_var="mobile-header-menu";
		}
		else
		{
			$menu_var="main_navigation";
		}
		$main_menu_args = array(
			'theme_location'  => $menu_var,
			'depth'           => 5,
			'menu_class'      => $menu_class,
			'items_wrap'      => '<ul role="menubar" id="%1$s" class="%2$s">%3$s</ul>',
			'fallback_cb'     => 'Avada_Nav_Walker::fallback',
			'walker'          => new Avada_Nav_Walker(),
			'container'       => false,
			'item_spacing'    => 'discard',
			'echo'            => false,
		);

		if ( $flyout_menu ) {
			$flyout_menu_args = array(
				'depth'     => 1,
				'container' => false,
			);

			$main_menu_args = wp_parse_args( $flyout_menu_args, $main_menu_args );

			$main_menu = wp_nav_menu( $main_menu_args );

			return $main_menu;

		} else {
			$uber_menu_class = '';
			if ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) ) {
				$uber_menu_class = ' fusion-ubermenu';
			}

			echo '<nav class="fusion-main-menu' . esc_attr( $uber_menu_class ) . '" aria-label="Main Menu">';
			echo wp_nav_menu( $main_menu_args );
			echo '</nav>';

			if ( has_nav_menu( 'sticky_navigation' ) && 'Top' === Avada()->settings->get( 'header_position' ) && ( ! function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) || ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ! ubermenu_get_menu_instance_by_theme_location( 'sticky_navigation' ) ) ) ) {

				$sticky_menu_args = array(
					'theme_location'  => 'sticky_navigation',
					'menu_id'		  => 'menu-main-menu-1',
					'walker'          => new Avada_Nav_Walker(),
					'item_spacing'    => 'discard',
				);

				$sticky_menu_args = wp_parse_args( $sticky_menu_args, $main_menu_args );

				echo '<nav class="fusion-main-menu fusion-sticky-menu" aria-label="Main Menu Sticky">';
				echo wp_nav_menu( $sticky_menu_args );
				echo '</nav>';
			}

			// Make sure mobile menu is not loaded when we use slideout menu or ubermenu.
			if ( ! function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) || ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ! ubermenu_get_menu_instance_by_theme_location( 'main_navigation' ) ) ) {
				avada_mobile_main_menu();
			}
		} // End if().
	}
} // End if().
