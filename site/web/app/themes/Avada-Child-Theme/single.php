<?php
/**
 * Template used for single posts and other post-types
 * that don't have a specific template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>

<div id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
	<?php $post_pagination = get_post_meta( $post->ID, 'pyre_post_pagination', true ); ?>
	<?php if ( ( Avada()->settings->get( 'blog_pn_nav' ) && 'no' !== $post_pagination ) || ( ! Avada()->settings->get( 'blog_pn_nav' ) && 'yes' === $post_pagination ) ) : ?>
		<div class="single-navigation clearfix">
			<?php previous_post_link( '%link', esc_attr__( 'Previous', 'Avada' ) ); ?>
			<?php next_post_link( '%link', esc_attr__( 'Next', 'Avada' ) ); ?>
		</div>
	<?php endif; ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
			<?php $full_image = ''; ?>
			<?php if ( 'above' == Avada()->settings->get( 'blog_post_title' ) ) : ?>
				<?php echo wp_kses_post( avada_render_post_title( $post->ID, false, '', '2' ) ); ?>
			<?php elseif ( 'disabled' == Avada()->settings->get( 'blog_post_title' ) && Avada()->settings->get( 'disable_date_rich_snippet_pages' ) ) : ?>
				<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<?php endif; ?>

			<?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php if ( Avada()->settings->get( 'featured_images_single' ) ) : ?>
					<?php $video = get_post_meta( $post->ID, 'pyre_video', true ); ?>
					<?php if ( 0 < avada_number_of_featured_images() || $video ) : ?>
						<?php Avada()->images->set_grid_image_meta( array(
							'layout' => strtolower( 'large' ),
							'columns' => '1',
						) ); ?>
						<div class="fusion-flexslider flexslider fusion-flexslider-loading post-slideshow fusion-post-slideshow">
							<ul class="slides">
								<?php if ( $video ) : ?>
									<li>
										<div class="full-video">
											<?php // @codingStandardsIgnoreLine ?>
											<?php echo $video; ?>
										</div>
									</li>
								<?php endif; ?>
								<?php if ( has_post_thumbnail() && 'yes' != get_post_meta( $post->ID, 'pyre_show_first_featured_image', true ) ) : ?>
									<?php $attachment_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>
									<?php $full_image       = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>
									<?php $thumb_image       = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' ); ?>
									<?php $attachment_data  = wp_get_attachment_metadata( get_post_thumbnail_id() ); ?>
									<li>
										<?php if ( Avada()->settings->get( 'status_lightbox' ) && Avada()->settings->get( 'status_lightbox_single' ) ) : ?>
											<a href="<?php echo esc_url_raw( $full_image[0] ); ?>" data-rel="iLightbox[gallery<?php the_ID(); ?>]" title="<?php echo esc_attr( get_post_field( 'post_excerpt', get_post_thumbnail_id() ) ); ?>" data-title="<?php echo esc_attr( get_post_field( 'post_title', get_post_thumbnail_id() ) ); ?>" data-caption="<?php echo esc_attr( get_post_field( 'post_excerpt', get_post_thumbnail_id() ) ); ?>" aria-label="<?php echo esc_attr( get_post_field( 'post_title', get_post_thumbnail_id() ) ); ?>">
												<span class="screen-reader-text"><?php esc_attr_e( 'View Larger Image', 'Avada' ); ?></span>
												<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
											</a>
										<?php else : ?>
											<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
										<?php endif; ?>
									</li>
								<?php endif; ?>
								<?php $i = 2; ?>
								<?php while ( $i <= Avada()->settings->get( 'posts_slideshow_number' ) ) : ?>
									<?php $attachment_new_id = kd_mfi_get_featured_image_id( 'featured-image-' . $i, 'post' ); ?>
									<?php if ( $attachment_new_id ) : ?>
										<?php $attachment_image = wp_get_attachment_image_src( $attachment_new_id, 'full' ); ?>
										<?php $full_image       = wp_get_attachment_image_src( $attachment_new_id, 'full' ); ?>
										<?php $attachment_data  = wp_get_attachment_metadata( $attachment_new_id ); ?>
										<li>
											<?php if ( Avada()->settings->get( 'status_lightbox' ) && Avada()->settings->get( 'status_lightbox_single' ) ) : ?>
												<a href="<?php echo esc_url_raw( $full_image[0] ); ?>" data-rel="iLightbox[gallery<?php the_ID(); ?>]" title="<?php echo esc_attr( get_post_field( 'post_excerpt', $attachment_new_id ) ); ?>" data-title="<?php echo esc_attr( get_post_field( 'post_title', $attachment_new_id ) ); ?>" data-caption="<?php echo esc_attr( get_post_field( 'post_excerpt', $attachment_new_id ) ); ?>" aria-label="<?php echo esc_attr( get_post_field( 'post_title', get_post_thumbnail_id() ) ); ?>">
													<?php echo wp_get_attachment_image( $attachment_new_id, 'full' ); ?>
												</a>
											<?php else : ?>
												<?php echo wp_get_attachment_image( $attachment_new_id, 'full' ); ?>
											<?php endif; ?>
										</li>
									<?php endif; ?>
									<?php $i++; ?>
								<?php endwhile; ?>
							</ul>
						</div>
						<?php Avada()->images->set_grid_image_meta( array() ); ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( 'below' == Avada()->settings->get( 'blog_post_title' ) ) : ?>
				<?php echo wp_kses_post( avada_render_post_title( $post->ID, false, '', '2' ) ); ?>
			<?php endif; ?>
			<div class="post-content">
				<?php the_content(); ?>
				<?php $link_esterno=get_field('link_esterno'); ?>
				<?php
				if ($link_esterno!="")
				{
					ob_start();
					
					if ($thumb_image[0]!="")
					{
						?>
						<p style="text-align: center;"><a href="#" data-toggle="modal" data-target=".fusion-modal.mymodal"><img src="<?php echo $thumb_image[0]; ?>"></a></p>
						<?php
					}
					else
					{
						?>
						<p style="text-align: center;"><a class="fusion-button button-flat fusion-button-round button-large button-default button-1" href="#" data-toggle="modal" data-target=".fusion-modal.mymodal">VAI AL COUPON</a></p>
						<?php
					}
					$output = ob_get_contents();
					ob_end_clean();
					
					
					//echo do_shortcode('[sociallocker]'.$output.'[/sociallocker]');
					
					echo $output;
					

					global $wp;
					$current_url = home_url(add_query_arg(array(),$wp->request));					
					
					echo do_shortcode('
					[fusion_modal name="mymodal" title="'.get_the_title().'" size="large" background="" border_color="" show_footer="no" class="" id=""]

					
					<h2 style="text-align: center;">Stai per Ricevere il tuo Buono..</h2>
					<h4 style="text-align: center;"><strong>Passo 1</strong>: Premi il pulsante <strong>Condividi</strong> qui sotto e condividi su Facebook</h4>
					<div style="text-align: center;margin-left:45%;" class="fb-share-button" data-href="'.$current_url.'" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Condividi</a></div>					
					<h4 style="text-align: center;"><strong>Passo 2</strong>: Premi sul Pulsante verde qui sotto e ottieni immediatamente il tuo buono:</h4>
					
					[fusion_button link="'.$link_esterno.'" title="" target="_blank" alignment="center" modal="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" color="default" button_gradient_top_color="" button_gradient_bottom_color="" button_gradient_top_color_hover="" button_gradient_bottom_color_hover="" accent_color="" accent_hover_color="" type="" bevel_color="" border_width="" size="large" stretch="no" shape="" icon="" icon_position="left" icon_divider="no" animation_type="" animation_direction="left" animation_speed="0.3" animation_offset=""]Button Text[/fusion_button]				
					
					[/fusion_modal]								
					');
				}
				?>
				

				
				
				<?php fusion_link_pages(); ?>
				<?php if(function_exists('the_ratings') AND !is_home() AND !is_tax()) { the_ratings(); } ?>
			</div>

			<?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php echo wp_kses_post( avada_render_post_metadata( 'single' ) ); ?>
				<?php avada_render_social_sharing(); ?>
				<?php $author_info = get_post_meta( $post->ID, 'pyre_author_info', true ); ?>
				<?php if ( ( Avada()->settings->get( 'author_info' ) && 'no' !== $author_info ) || ( ! Avada()->settings->get( 'author_info' ) && 'yes' === $author_info ) ) : ?>
					<div class="about-author">
						<?php ob_start(); ?>
						<?php the_author_posts_link(); ?>
						<?php $title = sprintf( __( 'About the Author: %s', 'Avada' ), ob_get_clean() ); ?>
						<?php Avada()->template->title_template( $title, '3' ); ?>
						<div class="about-author-container">
							<div class="avatar">
								<?php echo get_avatar( get_the_author_meta( 'email' ), '72' ); ?>
							</div>
							<div class="description">
								<?php the_author_meta( 'description' ); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php avada_render_related_posts( get_post_type() ); // Render Related Posts. ?>

				<?php $post_comments = get_post_meta( $post->ID, 'pyre_post_comments', true ); ?>
				<?php if ( ( Avada()->settings->get( 'blog_comments' ) && 'no' !== $post_comments ) || ( ! Avada()->settings->get( 'blog_comments' ) && 'yes' === $post_comments ) ) : ?>
					<?php wp_reset_postdata(); ?>
					<?php comments_template(); ?>
				<?php endif; ?>
			<?php endif; ?>			
		</article>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</div>
<?php do_action( 'avada_after_content' ); ?>
<?php get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
