<?php 

/**	Image Slider
 *		Uses picture element - allows for more exact control than srcset, good for design decisions
 */

if ( false === ( $template_slider = get_transient( 'template_slider' ) ) ) {
	ob_start();
	
	if( have_rows('slides') ) :
		?>
		<section id="slider-wrapper">
			<div class="slick-slider">
				<?php 
				while ( have_rows('slides') ) :
					the_row('slides');
					
					$images = get_sub_field('images');
					$img_main = $images['slide_main'];
					$img_url_main = $img_main['url'];
					if( !empty($img_main['alt']) ) {
						$img_alt = $img_main['alt'];
					}else {
						$img_alt = $img_main['title'];
					}
					$img_url_med = $images['slide_medium'];
					$img_url_small = $images['slide_small'];
	
					$button = get_sub_field('button');
					$link = $button['link'];
					$link_text = $button['link_text'];
	
					$message = get_sub_field('message');
					$message_title = $message['title'];
					$message_subtitle = $message['subtitle'];

					$sl_image_url = aq_resize( $img_url_main, 1920, 600, true, true, true );
					
					if( $img_url_med ) {
						$sl_image_url_med = aq_resize( $img_url_med, 1200, 552, true, true, true );
					}else {
						$sl_image_url_med = aq_resize( $img_url_main, 1200, 552, true, true, true );
					}
					
					if( $img_url_small ) {
						$sl_image_url_small = aq_resize( $img_url_small, 800, 600, true, true, true );
					}else {
						$sl_image_url_small = aq_resize( $img_url_main, 800, 600, true, true, true );
					}
														
					if($img_url_main){
						?>
						<div class='slick-slide'>
						<?php
							if( !$sl_image_url_small ) {
								?>
								<img 
									data-lazy="<?php echo $sl_image_url; ?>"
									alt="<?= $img_alt; ?>" 
								/>
								<?php
							}else {
								?>
								<picture>
									<!--[if IE 9]><audio><![endif]-->				
									<source 
										srcset="<?php echo $sl_image_url_small; ?>"
										media="(max-width: 480px)"
									>
									<source 
										srcset="<?php echo $sl_image_url_med; ?>"
										media="(max-width: 768px)"
									>
									<source
										srcset="<?php echo $sl_image_url; ?>"
										media="(min-width: 769px)"
									>
									<!--[if IE 9]></audio><![endif]-->
									<img 
										src="<?php echo $sl_image_url_med; ?>"
										alt="<?= $img_alt; ?>" 
									/>
								</picture>					
								<?php
							}
							
							if( $message ) {
								echo "<div class='slick-caption-wrap'>";
									echo '<h3 class="slick-caption-title">'.$message_title.'</h3>';
									echo '<div class="slick-caption">'.$message_subtitle.'</div>';
									if( $link ) :
										?>
										<a href="<?= $link; ?>" class="button"><?= $link_text; ?></a>
										<?php
									endif;
								echo "</div>";
							}
						?>
						</div>
						<?php
					}
					
				endwhile;
				?>
			</div>
			<script>
				jQuery(window).load(function() {
					jQuery(".slick-slider").slick({
						//accessibility: true,
						//adaptiveHeight: false,
						//appendArrows: $(element),
						//appendDots: $(element),
						//arrows: true,
						//asNavFor: $(element)
						autoplay: true,
						//autoplay: 3000,
						//centerMode: false,
						//centerPadding: '50px',
						//cssEase: 'ease',
						//customPaging: function(slider, i) {
						//    return '<button type="button" data-role="none">' + (i + 1) + '</button>';
						//},
						//dots: false,
						//dotsClass: 'slick-dots',
						//draggable: true,
						//easing: 'linear',
						//edgeFriction: 0.15,
						//fade: false,
						//focusOnSelect: false,
						//focusOnChange: false,
						//infinite: true,
						//initialSlide: 0,
						//lazyLoad: 'ondemand',
						//mobileFirst: false,
						//nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next">Next</button>',
						//pauseOnDotsHover: false,
						//pauseOnFocus: true,
						//pauseOnHover: true,
						//prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous">Previous</button>',
						//respondTo: 'window',
						//responsive: [
						//	{
						//	  breakpoint: 767,
						//	  settings: {
						//		arrows: false
						//	  }
						//	}
							// You can unslick at a given breakpoint now by adding:
							// settings: "unslick"
							// instead of a settings object
						//  ],
						rows: 0, //Setting this to 1 adds more divs that will require style changes, and setting this to more than 1 initializes grid mode. Use slidesPerRow to set how many slides should be in each row.
						//rtl: false,
						slide: '.slick-slide',
						//slidesPerRow: 1,
						//slidesToScroll: 1,
						//slidesToShow: 1,
						//speed: 300,
						//swipe: true,
						//swipeToSlide: false,
						//touchMove: true,
						//touchThreshold: 5,
						//useCSS: true,
						//useTransform: true,
						//variableWidth: false,
						//vertical: false,
						//verticalSwiping: false,
						//waitForAnimate: true
						//zIndex: 1000
					});
				});
			</script>
		</section>
	<?php endif;
	
	$template_slider = ob_get_clean();
	// Transient set for 30 seconds, increase when going live
	set_transient( 'template_slider', $template_slider, 30 );
}

echo $template_slider;