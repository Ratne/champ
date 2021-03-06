<?php
/**
 * Header-2 template.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       http://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="fusion-header-sticky-height"></div>
<div class="fusion-sticky-header-wrapper"> <!-- start fusion sticky header wrapper -->
	<div class="fusion-header">
		<div class="fusion-row">
			<div class="mt_logo">
			<?php avada_logo(); ?>			
			<?php get_template_part( 'templates/menu-mobile-modern' ); ?>
			</div>
			<div class="mt_banner">			
			<?php generated_dynamic_sidebar( 'TopAds' ); ?>		
			</div>
		</div>
	</div>
