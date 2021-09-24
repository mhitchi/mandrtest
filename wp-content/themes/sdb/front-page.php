<?php
/**
 * The Home Page
 */

get_header(); ?>

<main id="primary-wrap" class="primary-content" role="main">
	<?php
	if (have_posts()) : while (have_posts()) : the_post();

		/**
		 * Hero
		 * */
		$hero = get_field('hero'); // image, content, button_text, button_link

		// make sure it's in array format
		if(!is_array($hero['image'])){
			$hero['image'] = acf_get_attachment($hero['image']);
		}
		?>
		<section class="hero h2-larger-container" style="background-image: url(<?= $hero['image']['url']; ?>);">
			<div class="hero__wrap">
				<div class="hero__content">
					<h2><?= $hero['content']; ?></h2>
					<?= mr_display_button($hero['button_text'],$hero['button_link']); ?>
				</div>
			</div>
		</section>
		<?php

		/**
		 * 3 Cards
		 */
		$personal_ins = get_field('personal_insurance_highlight'); // image, title, button-text, button_link
		$business_ins = get_field('business_insurance_highlight'); // image, title, button-text, button_link
		$insurance_quote = get_field('insurance_quote'); // title, message, button-text, button_link
		// make sure it's in array format
		if(!is_array($personal_ins['image'])){
			$personal_ins['image'] = acf_get_attachment($personal_ins['image']);
		}
		if(!is_array($business_ins['image'])){
			$business_ins['image'] = acf_get_attachment($business_ins['image']);
		}
		?>
		<section class="homepage-highlights section-wrap double-padding--bot">
			<div class="homepage-highlights__grid container">
				<div class="homepage-highlights__grid__item homepage-highlights__grid__item--1 card-style">
					<div class="homepage-highlights__grid__item__image">
						<img src="<?= $personal_ins['image']['url']; ?>" alt="<?= $personal_ins['image']['alt']; ?>">
					</div>
					<div class="homepage-highlights__grid__item__content">
						<h2><?= $personal_ins['title']; ?></h2>
						<?= mr_display_button($personal_ins['button_text'],$personal_ins['button_link']); ?>
					</div>
				</div>
				<div class="homepage-highlights__grid__item homepage-highlights__grid__item--2 card-style">
					<div class="homepage-highlights__grid__item__image">
						<img src="<?= $business_ins['image']['url']; ?>" alt="<?= $business_ins['image']['alt']; ?>">
					</div>
					<div class="homepage-highlights__grid__item__content">
						<h2><?= $business_ins['title']; ?></h2>
						<?= mr_display_button($business_ins['button_text'],$business_ins['button_link']); ?>
					</div>
				</div>
				<div class="homepage-highlights__grid__item homepage-highlights__grid__item--3 callout-card-style">
					<h2><?= $insurance_quote['title']; ?></h2>
					<p><?= $insurance_quote['message']; ?></p>
					<?= mr_display_button($insurance_quote['button_text'],$insurance_quote['button_link']); ?>
				</div>
		</section>
		<?php
		/**
		 * Why Choose SDB?
		 */
		$why_sdb = get_field('why_sdb'); // title, column_1, column_2, column_3, button_text, button_link
		$col1 = $why_sdb['column_1']; // icon, title
		$col2 = $why_sdb['column_2']; // icon, title
		$col3 = $why_sdb['column_3']; // icon, title
		// make sure it's in array format
		if(!is_array($col1['icon'])){
			$col1['icon'] = acf_get_attachment($col1['icon']);
		}
		if(!is_array($col2['icon'])){
			$col2['icon'] = acf_get_attachment($col2['icon']);
		}
		if(!is_array($col3['icon'])){
			$col3['icon'] = acf_get_attachment($col3['icon']);
		}
		?>
		<section class="why-sdb section-wrap double-padding h2-larger-container">
			<div class="why-sdb__wrapper container">
				<h2><?= $why_sdb['title']; ?></h2>
				<div class="why-sdb__columns">
					<div class="why-sdb__column one-third first">
						<img src="<?= $col1['icon']['url']; ?>" alt="<?= $col1['icon']['alt']; ?>">
						<h3><?= $col1['title']; ?></h3>
					</div>
					<div class="why-sdb__column one-third">
						<img src="<?= $col2['icon']['url']; ?>" alt="<?= $col2['icon']['alt']; ?>">
						<h3><?= $col2['title']; ?></h3>
					</div>
					<div class="why-sdb__column one-third">
						<img src="<?= $col3['icon']['url'];?>" alt="<?= $col3['icon']['alt'];?>">
						<h3><?= $col3['title']; ?></h3>
					</div>
				</div>
				<?= mr_display_button($why_sdb['button_text'],$why_sdb['button_link']); ?>
			</div>
		</section>
		<?php
		/**
		 * We're Looking Out for You
		 */
		$looking_out_for_you = get_field('looking_out_for_you'); //image, content, button_text, button_link
		if(!is_array($looking_out_for_you['image'])){
			$looking_out_for_you['image'] = acf_get_attachment($looking_out_for_you['image']);
		}
		?>
		<section class="looking-out section-wrap double-padding h2-larger-container">
			<div class="looking-out__wrapper container">
				<figure class="looking-out__image">
					<img src="<?= $looking_out_for_you['image']['url']; ?>" alt="<?= $looking_out_for_you['image']['alt']; ?>">
				</figure>
				<div class="looking-out__content">
					<?= $looking_out_for_you['content']; ?>
					<?= mr_display_button($looking_out_for_you['button_text'],$looking_out_for_you['button_link']); ?>
				</div>
			</div>
		</section>

		<?php
		/**
		 * Resources & News Feed
		 */
		$news_feed = get_field('news_feed'); // title, button_text, button_link
		?>
		<section class="news-feed section-wrap double-padding h2-larger-container">
			<div class="news-feed__grid">
				<div class="news-feed__left">
					<h2><?= $news_feed['title']; ?></h2>
					<?= mr_display_button($news_feed['button_text'],$news_feed['button_link']); ?>
					<div class="news-feed__carousel-navigation"></div>
				</div>				
				<?php
				// WP_Query arguments
				$args = array (
					'post_type'              => 'post',
					'posts_per_page'         => '9',
					'no_found_rows'          => true,
				);

				// The Query
				$post_query = new WP_Query( $args );

				// The Loop
				if ( $post_query->have_posts() ) :
					?>
					<div class="news-feed__feed">
						<div class="news-feed__carousel slick-slider">
							<?php
							while($post_query->have_posts()):
								$post_query->the_post();
								if(has_post_thumbnail()){
									$image = acf_get_attachment(get_post_thumbnail_id(get_the_ID()));
									$img_alt = $image['alt'];
									if($image){
										if((int)$image['width'] !== 371 || (int)$image['height'] !== 209){
											$img_url = aq_resize( $image['url'], 371, 209, true, true, true );
										}else {
											$img_url = $image['url'];
										}
									}
								}else {
									$image = get_field('mandr_blog_default_image', 'options');
									$img_alt = '';
									if(!is_array($image)){
										$image = acf_get_attachment($image);
									}
									if((int)$image['width'] !== 371 || (int)$image['height'] !== 209){
										$img_url = aq_resize( $image['url'], 371, 209, true, true, true );
									}else {
										$img_url = $image['url'];
									}
								}
								?>
								<div class="news-feed__item slick-slide <?php if(has_post_thumbnail()) : ?> news-feed__item--has-thumbnail <?php endif; ?>">
									<a class="news-feed__item__link-wrapper" href="<?= get_the_permalink(); ?>">
										<figure class="news-feed__item__image">
											<img src="<?= $img_url; ?>" alt="<?= $img_alt; ?>">
										</figure>
										<div class="news-feed__item__content">
											<h3 class="news-feed__item__title"><?= get_the_title(); ?></h3>
											<time datetime="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_time('F j, Y'); ?></time>
											<span class="news-feed__item__link" href="<?= get_the_permalink(); ?>">Read Article</span>
										</div>
									</a>
								</div>
								<?php
							endwhile;
							?>
						</div>
						<script>
						jQuery(window).load(function() {
							jQuery(".slick-slider").slick({
<<<<<<< HEAD
								appendArrows: $('.news-feed__carousel-navigation'),
								autoplay: true,
								autoplaySpeed: 8000,
								rows: 0,
								slide: '.news-feed__item',
								slidesToScroll: 3,
								slidesToShow: 3,
=======
								//accessibility: true,
								//adaptiveHeight: false,
								appendArrows: $('.news-feed__carousel-navigation'),
								//appendDots: $(element),
								//arrows: true,
								//asNavFor: $(element)
								autoplay: true,
								autoplaySpeed: 8000,
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
								rows: 0, //Setting this to 1 adds more divs that will require style changes, and setting this to more than 1 initializes grid mode. Use slidesPerRow to set how many slides should be in each row.
								//rtl: false,
								slide: '.news-feed__item',
								//slidesPerRow: 1,
								slidesToScroll: 3,
								slidesToShow: 3,
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
>>>>>>> 7c88980af092cc99303e62defe1f425b16467df1
								responsive: [
									{
										breakpoint: 1242,
										settings: {
											slidesToScroll: 2,
											slidesToShow: 2
										}
									},
									{
										breakpoint: 961,
										settings: {
											slidesToScroll: 3,
											slidesToShow: 3
										}
									},
									{
										breakpoint: 768,
										settings: {
											slidesToScroll: 2,
											slidesToShow: 2
										}
									},
									{
										breakpoint: 480,
										settings: {
											slidesToScroll: 1,
											slidesToShow: 1
										}
									},
								 ]
							});
						});
						</script>
					</div>
					<?php
				else :
					?>
					<div class="news-feed__feed empty">
						<h3>There is no news at this time</h3>
					</div>
					<?php
				endif;
				?>
				
			</div>
		</section>

	<?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>