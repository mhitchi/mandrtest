<?php
/**
 * Columns
 */
add_shortcode('one-half', 'fluid_column');
add_shortcode('one-third', 'fluid_column');
add_shortcode('two-thirds', 'fluid_column');
add_shortcode('one-fourth', 'fluid_column');
add_shortcode('three-fourths', 'fluid_column');
add_shortcode('one-fifth', 'fluid_column');
add_shortcode('two-fifths', 'fluid_column');
add_shortcode('three-fifths', 'fluid_column');
add_shortcode('four-fifths', 'fluid_column');
add_shortcode('one-sixth', 'fluid_column');
add_shortcode('five-sixths', 'fluid_column');
function fluid_column($atts, $content=null, $shortcodename ="")
{	
	$first = '';
	$last = '';
	if (isset($atts[0]) && trim($atts[0]) == 'first')  $first = 'first';
	if (isset($atts[0]) && trim($atts[0]) == 'last')  $last = 'last';
	
	//remove wrong nested <p>
	$content = remove_invalid_tags($content, array('p'));


	// add divs to the content
	$return = '<div class="'.$shortcodename.' '.$first.'">';
	$return .= do_shortcode($content);
	$return .= '</div>';
	
	if($last != '') $return .= '<div class="clear"></div>';

	return $return;
}


/**
 * Heading
 */
add_shortcode('heading', 'heading_sc');
function heading_sc($atts, $content = null) {

	extract(shortcode_atts(
        array(
            'tag' => 'h1',
            'style' => '',
            'align' => 'false'
    ), $atts));
	
	$output = '';
	
	if( $style !== '' ) {
		$class = 'class="' . $style . '"';
	}else {
		$class = '';
    }
    
    if( $align !== 'false' ) {
		if( $align === 'center' || $align === 'centered' ) {
			$align = 'style="text-align: center;"';
		}elseif( $align === 'left' ) {
			$align = 'style="text-align: left;"';
		}elseif( $align === 'right' ) {
			$align = 'style="text-align: right;"';
		}
	}else {
		$align = '';
	}
    
    ob_start();
        ?>
        <<?= $tag; ?> <?= $class; ?> <?= $align; ?>>
            <?= do_shortcode($content); ?>
        </<?= $tag; ?>>
        <?php

    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/**
 * Div and Span Shortcode
 */
add_shortcode('container', 'div_span_wrapping_shortcode'); 
function div_span_wrapping_shortcode($atts, $content = null) {

	$first_class = '';
	$second_class = '';
	$third_class = '';
	
	if ( isset($atts[0]) ) {
		$first_class = trim($atts[0]);
		if ( isset($atts[1]) ){
			$second_class = trim($atts[1]);
			if ( isset($atts[2]) ){
				$third_class = trim($atts[2]);
			}
		}
	}
    
	ob_start();
	?>
		<div class="<?php echo $first_class,' ',$second_class,' ',$third_class; ?>">
	
		<?php echo do_shortcode($content); ?>
		
		</div>
		
	<?php
	$output = ob_get_contents();
	ob_end_clean();
    return $output;

}

/**
 * Contact Phone
 */
add_shortcode('contact_phone', 'phone_link_sc');
function phone_link_sc($atts, $content = null) {
	
	$phone = get_option( 'options_mandr_phone' );
	$phone2 = get_option( 'options_mandr_phone_appearance' );
    $output = '<a itemprop="telephone" href="tel:'.$phone.'">'.$phone2.'</a>';

    return $output;
}

/**
 * Contact Email
 */
add_shortcode('contact_email', 'contact_email_sc');
function contact_email_sc($atts, $content = null) {
	
	$email = antispambot(get_option( 'options_mandr_email' ));
    $output = '<a itemprop="email" href="mailto:'.$email.'">'.$email.'</a>';

    return $output;
}

/**
 * Contact Address
 */
add_shortcode('contact_address', 'contact_address_sc');
function contact_address_sc($atts, $content = null) {
	
    $location_text = get_option( 'options_mandr_address' );
    $location_full = get_option( 'options_mandr_address_link' );
    
    $output = '<a itemprop="address" href="'. $location_full.'" target="_blank">'.$location_text.'</a>';

    return $output;
}

/**
 * Facebook
 */
add_shortcode('social_facebook', 'social_facebook_sc');
function social_facebook_sc($atts, $content = null) {
	
	//$link = get_field( 'mandr_facebook', 'option' );
	$link = get_option( 'options_mandr_facebook' );
    $output = '<a href="'.$email.'">Facebook</a>';

    return $output;
}

/**
 * Staff List
 */
add_shortcode('staff_list', 'staff_list_sc');
function staff_list_sc(){
    
	if( have_rows( 'staff' ) ) :
    // Begin buffering
    ob_start();
	?>
    <div class="staff-list">
		<?php 
			while( have_rows( 'staff' ) ):
			the_row();
			$name = get_sub_field( 'name' );
			$position = get_sub_field( 'position' );
			$email_field = get_sub_field( 'email' );
			$email = antispambot( $email_field );
		?>
        <div class="staff-person">
        	<?php if( $name ) : ?>
				<h2><?= $name; ?></h2>
			<?php endif; ?>
			
			<?php if( $position ) : ?>
				<h3><?= $position; ?></h3>
			<?php endif; ?>
			
			<?php if( $email_field ) : ?>
				<a class="button email-button" href="mailto:<?= $email; ?>"><?= $email; ?></a>
       		<?php endif; ?>
       		
        	<?= get_sub_field( 'bio' ); ?>
		</div>
        <?php endwhile; ?>  
	</div>
    <?php endif;
    
    // End buffering, save, return
    $output = ob_get_clean();
    return $output;
}

/**
* Create Google Maps unordered list
*/
add_shortcode('map_listing', 'map_listing_sc');
function map_listing_sc($atts) {
	if( have_rows('map_locations', 'option') ) :
	$cx = 0;
		ob_start(); 
		?>
            <ul id="map-listing">
            <?php 
                while ( have_rows('map_locations', 'option') ) :
                    the_row('map_locations', 'option');
					$cx++;
                    $text = get_sub_field( 'title', 'option' );
					$location = get_sub_field( 'map', 'option' );
                        ?>
                            <li class="single-listing">		
								<button class="listing-button" data-lat="<?= $location['lat']; ?>" data-lng="<?= $location['lng']; ?>">
									<?= $text; ?>
								</button>
							</li>
                        <?php
                endwhile;
                ?>
            </ul>
        <?php
		$output = ob_get_contents();
		ob_end_clean();
	endif;
	return $output;
}

/**
 * Column Count shortcode
 */
add_shortcode('column_count', 'column_count_shortcode');
function column_count_shortcode($atts, $content=null){
    
	if (isset($atts[0])){ $number = trim($atts[0]); }
        else { return do_shortcode($content); }
        
    $style = "-moz-column-count: $number; -webkit-column-count: $number; column-count: $number;";
            
    $output = '<div class="column-box" style="'.$style.'">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    
    return $output;
}
/**
 * Responsive Column Width shortcode
 */
add_shortcode('responsive_column_width', 'r_column_width_shortcode');
function r_column_width_shortcode($atts, $content=null){
    
	if (isset($atts[0])){ $number = trim($atts[0]); }
        else { return do_shortcode($content); }
        
    $style = "-moz-column-width: {$number}px; -webkit-column-width: {$number}px; column-width: {$number}px;";
            
    $output = '<div style="'.$style.'">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    
    return $output;
}

/**
 * Responsive Column Count shortcode
 */
add_shortcode('responsive_column_count', 'r_column_count_shortcode');
function r_column_count_shortcode($atts, $content=null){
    
	if (isset($atts[0])){ $number = trim($atts[0]); }
        else { return do_shortcode($content); }
        
    $style = "-moz-column-count: $number; -webkit-column-count: $number; column-count: $number;";
            
    $output = '<div class="responsive-column-count" style="'.$style.'">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    
    return $output;
}

/**
 * Email
 */
add_shortcode('email', 'email_shortcode');
function email_shortcode($atts, $content = null) {

	extract(shortcode_atts(
        array(
            'email' => 'example@example.com',
            'text' => 'Example',
            'class' => ''
    ), $atts));
    
    $email = antispambot($email);
    $text = antispambot($text);
    
    $output =  '<a href="mailto:'.$email.'" class="'.$class.'">';
		$output .= $text;
		$output .= '</a>';

    return $output;
}

/**
 * Button
 */
add_shortcode('button', 'button_shortcode');
function button_shortcode($atts, $content = null) {

	extract(shortcode_atts(
        array(
            'link' => 'https://www.google.com',
            'text' => 'Button Text',
			'mobile_text' => '',
			'newtab' => 'false',
			'align' => 'false',
			'download' => 'false'
    ), $atts));
	
	$output = '';
	
	if( $newtab !== false && $newtab !== 'false' ) {
		$insert = ' target="_blank" ';
		$rel = 'rel="noopener noreferrer" ';
	}else {
		$insert = '';
		$rel = '';
	}
	
	if($mobile_text !== ''){
		$mobile = '<span class="mobile-text">' . $mobile_text . '</span>';
	} else {
		$mobile = '';
	}

	if( $align !== 'false' ) {
		if( $align === 'center' || $align === 'centered' ) {
			$p_align = '<p class="centered-button">';
		}elseif( $align === 'left' ) {
			$p_align = '<p class="left-button">';
		}elseif( $align === 'right' ) {
			$p_align = '<p class="right-button">';
		}
	}else {
		$p_align = '';
	}
	
	if( $download === 'false' ) {
		$download = '';
	}else {
		$download = 'download';
	}
	
	$output .= $p_align;
    $output .=  '<a '.$download.' href="'.$link.'" title="'.$text.'" class="button"'.$insert.$rel.'>';
	$output .= $mobile;
	$output .= '<span class="text-wrap">' . $text . '</span>';
	$output .= '</a>';
	
	if( $align !== 'false' ) {
		$output .= '</p>';
	}

    return $output;
}

/**
 * Spacer
 */
add_shortcode('spacer', 'spacer_shortcode');
function spacer_shortcode($atts, $content = null) {

    $output = '<div class="spacer"><!-- --></div>';

    return $output;
}

/**
 *	Callout Shortcode
 */
add_shortcode('callout', 'wh_callout_shortcode');
function wh_callout_shortcode($atts, $content = null) {
    
	ob_start();
	?>
		<div class="callout-wrap">
	
		<?php echo do_shortcode($content); ?>
		
		</div>
		
	<?php
	$output = ob_get_contents();
	ob_end_clean();
    return $output;

}

/**
 * Clear
 */
add_shortcode('clear', 'shortcode_clear');
function shortcode_clear() {
	return '<div class="clear"></div>';
}

/**
 * The Year
 */
add_shortcode('the_year', 'the_year_shortcode');
function the_year_shortcode($atts, $content=null){

    return date("Y");
}

/**
 * Toggle
 */
add_shortcode('toggle', 'toggle_shortcode');
function toggle_shortcode($atts, $content = null) {

    extract(shortcode_atts(
        array(
            'title' => 'This is your title'
    ), $atts));

    $output = '<div class="toggle">';
    $output .= '<a href="#" class="trigger" aria-expanded="false"><span></span>'.$title.'</a>';
    $output .= '<div class="box" aria-hidden="true">';
    $output .= do_shortcode($content);
    $output .= '</div><!-- .box (end) -->';
    $output .= '</div><!-- .toggle (end) -->';

    return $output;
}

/**
 * Tabs - v3
 */
add_shortcode('tabs', 'tabs_shortcode');
function tabs_shortcode($atts, $content = null) {
	
	$rand = substr(md5(microtime()),rand(0,26),3);

    $output = '<div class="tabs-wrapper">';
    $output .= '<div class="tab-menu-wrapper tabs" role="tablist" aria-orientation="horizontal">';

    //Build tab menu
    $numTabs = count($atts);

    for($i = 1; $i <= $numTabs; $i++){
        $output .= '<button id="tab_' . $i . '" class="tab-link '.( $i===1 ? 'tab-current' : '' ).'" data-tab="tab'.$i.'-'.$rand.'" role="tab" aria-selected="' . ( $i===1 ? 'true' : 'false' ) . '" aria-controls="tab'.$i.'-'.$rand.'">'.$atts['tab'.$i].'</button>';
    }
	
    $output .= '</div><!-- .tab-menu (end) -->';
    $output .= '<div class="tab-content-wrapper">';

    //Build content of tabs
    $tabContent = do_shortcode($content);
    $find = array();
    $replace = array();
	$cx = 0;
	
    foreach($atts as $key => $value){
		$cx++;
        $find[] = '['.$key.']';
        $find[] = '[/'.$key.']';
        $replace[] = '<div id="'.$key.'-'.$rand.'" class="tab-content '.( $key==='tab1' ? 'tab-current' : '' ).'" role="tabpanel" aria-labelledby="tab_' . $cx . '">';
        $replace[] = '</div><!-- .tab (end) -->';
    }

    $tabContent = str_replace($find, $replace, $tabContent);

    $output .= $tabContent;

    $output .= '</div><!-- .tab-content-wrapper (end) -->';
    $output .= '</div><!-- .tabs-wrapper (end) -->';

    return $output;
}

/**
 * Youtube Video Player
 */
add_shortcode('youtube', 'shortcode_youtube_video');
function shortcode_youtube_video($atts, $content = null) {
	
    extract(shortcode_atts(array(
        'link' => '',
		'align' => '',
		'image' => ''
    ), $atts));	

	$yt_link = $link;
	$yt_id = youtube_video_id($yt_link);
		
	if( !empty($image) ) {
		$yt_img = wp_get_attachment_image_src($image, array(480,360));
		$yt_img = $yt_img[0];
	} else {
		$yt_img = 'https://img.youtube.com/vi/'.$yt_id.'/0.jpg';
	}
	
	if($align === 'right'){
		$yt_align = 'alignright';
	}else if($align === 'left'){
		$yt_align = 'alignleft';
	}else if($align === 'center'){
		$yt_align = 'aligncenter';
	}else{
		$yt_align = $align;	
	}
	
	$output = "
	<div class='youtube-embed ".$yt_align."'>
		<a href='https://www.youtube.com/watch?v=".$yt_id."' class='popup-video'>
			<img class='youtube-link-img' src='".$yt_img."'>
			<span class='play-hover'></span>
		</a>
	</div>
	";
	
    return $output;

}

/**
 * Vimeo Video Player
 */
add_shortcode('vimeo', 'shortcode_vimeo_video');
function shortcode_vimeo_video($atts, $content = null) {
	
    extract(shortcode_atts(array(
        'link' => '',
		'align' => 'center',
		'image' => ''
    ), $atts));	
		
	$oembed_endpoint = 'http://vimeo.com/api/oembed';
	$xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($link) . '&width=640&byline=false&title=false';

	// Load in the oEmbed XML
	$oembed = simplexml_load_string(curl_get($xml_url));
	
	$video_player = html_entity_decode($oembed->html);
	
	if( $image != '' ) {
		$video_image = $image;
	}else {
		$video_image = html_entity_decode($oembed->thumbnail_url);	
	}
	
	if($align === 'right'){
		$vid_align = 'alignright';
	}else if($align === 'left'){
		$vid_align = 'alignleft';
	}else if($align === 'center'){
		$vid_align = 'aligncenter';
	}else{
		$vid_align = $align;	
	}
	
	$output = "
	<div class='youtube-embed ".$vid_align."'>
		<a href='".$link."' class='popup-video'>
			<img class='youtube-link-img' src='".$video_image."'>
			<span class='play-hover'></span>
		</a>
	</div>
	";
	
    return $output;
}

/**
 * Print Posts Paged shortcode
 * 		prints any post type with paging
 *		this depends on pagenavi plugin
 */
add_shortcode( 'print_posts_paged', 'shortcode_print_posts_paged' );
function sermons_shortcode( $atts ) {
	extract(
		shortcode_atts( array(
				'limit' => 9,
				'type' => 'post'
			), $atts 
		) 
	);
	
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;  
	
	$query_args =  array ( 
		'posts_per_page' => $limit, 
		'post_type' => $type, 
		'order' => 'ASC', 
		'orderby' =>'menu_order', 
		'paged' => $paged 
	);
	
	$wp_query = new WP_Query( $query_args );
	
	ob_start();
	
	if ( $wp_query->have_posts() ) { 
		$total = $wp_query->post_count;
		//$cx = 0;
	?>
	<div class="">
		<?php
		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();
			//$cx++;
			?>
			<article <?php post_class('post-holder clearfix'); ?>>
				<?php get_template_part( '/templates/listing' ); ?>
			</article>
		<?php } ?>
	</div>
	<?php wp_pagenavi( array('query'=> $wp_query) ); ?>
	<?php } ?>
	<?php
	
	// Reset after new wp_query
	wp_reset_postdata();
	
	$output = ob_get_contents();
	ob_end_clean();
    return $output;	
}

/**
 * Recent Blog Posts
 */
//add_shortcode('recent_posts', 'shortcode_recent_posts');
function shortcode_recent_posts($atts, $content = null) {

	extract(shortcode_atts(array(
			'num' => '3'
	), $atts));
	
	// WP_Query arguments
	$args = array (
		'post_type'              => 'post',
		'posts_per_page'         => '3',
	);
	
	// The Query
	$post_query = new WP_Query( $args );
	
	// The Loop
	ob_start();
	if ( $post_query->have_posts() ) {
		?>
		<div class="recent-posts">
			<?php
			while ( $post_query->have_posts() ) {
				$post_query->the_post();
				?>
				<div class="recent-post">
					<div class="post-meta one-third med-one-third first med-first">
						<div class="color-wrap">
							<div class="day"><?php echo get_the_date('d'); ?></div>
							<div class="month"><?php echo get_the_date('M'); ?></div>
						</div>
					</div>
					<div class="post-content two-thirds med-two-thirds">
						<h3><a href="<?php echo the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
						<?php echo my_string_limit_char_ellipses( get_the_excerpt(), 120 ); ?>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		?>
		No posts found.
		<?php
	}
	?>
	<div class="clear"></div>
	<?php
	// Restore original Post Data
	wp_reset_postdata();		

	$output = ob_get_contents();
	ob_end_clean();
    return $output;
}

/* 
 * Display All Children Links
**/
add_shortcode( 'subpages','subpage_links_shortcode' );
function subpage_links_shortcode($atts, $content = null) {
	
	// Get the # of links to display
	if (isset($atts[0])){ $num = trim($atts[0]); }
		else { $num = -1; }
	
	// Get current ID to dispaly children
	global $post;
	if( !isset($post) ){ return ''; }
	$parent_ID = $post->ID;
	
	// Get # Columns to sort into
	$cols = get_field('num_cols');
	switch($cols) {
		case 1:
			$grid_class = ' ';
			break;
		case 2:
			$grid_class = 'one-half';
			break;	
		case 3:
			$grid_class = 'one-third';
			break;
		case 4:
			$grid_class = 'one-fourth';
			break;								
		default:
			$grid_class = ' ';
	}
	
	// WP_Query arguments
	$args = array (
		'post_parent'		=> $parent_ID,
		'post_type'			=> 'page',
		'posts_per_page'	=> $num		
	);
	
	// The Query
	$subpage_query = new WP_Query( $args );
	
	// The Loop
	if ( $subpage_query->have_posts() ) :
		$cx = 0;
		ob_start();
		while ( $subpage_query->have_posts() ) : $subpage_query->the_post();
			$cx++;
			
			$img_args = array(
				'width' => 400,
				'height' => 300,
				'crop' => true,
				'single' => true,
				'upscale' => true
			);
			$img = resize_featured_image( get_the_id(), $img_args);
			?>
			
			<div class="subpage-link <?php 
										// Set up the normal grid breakdown if more than 1 column
										if( $cols > 1 ){
											echo $grid_class;
											if ($cx % $cols === 1){ 
												echo ' first';
											} 
										}
										// Only add the medium grid classes if more than 1 columns
										if( $cols > 1 ){ 
											echo ' med-one-half';
											
											if($cx % 2 === 1){
												echo ' med-first'; 
											}
										} ?> ">
				<h3><?php echo get_the_title(); ?></h3>
				<?php /**if( !empty($img) ) { ?>
					<figure class="featured-thumb">
						<img src="<?php echo $img; ?>" alt="<?php echo get_the_title(); ?>" />
					</figure>
				<?php } **/?>
				<div class="excerpt">
					<?php echo get_the_excerpt(); ?>
				</div>
				<a class="button" href="<?php echo get_the_permalink(); ?>">Learn More</a>
			</div>
			
			<?php
		endwhile;
	endif;
	
	// Restore original Post Data
	wp_reset_postdata();
	
	$output = ob_get_contents();
	ob_end_clean();
    return $output;
}

/**
 *	Single Subpage shortcode
 */
add_shortcode( 'pagelinks','mandr_pagelinks_shortcode' );
function mandr_pagelinks_shortcode($atts, $content = null) {
	
	// Empty output;
	$output = '';
		
	// Get # Columns to sort into
	$cols = get_field('num_cols');
	switch($cols) {
		case 1:
			$grid_class = ' ';
			break;
		case 2:
			$grid_class = 'one-half';
			break;	
		case 3:
			$grid_class = 'one-third';
			break;
		case 4:
			$grid_class = 'one-fourth';
			break;								
		default:
			$grid_class = ' ';
	}
	
	// The Loop
	if ( have_rows('select_links' ) ) :
	
		$cx = 0;
		ob_start();
		
		while ( have_rows('select_links' ) ) :
			the_row();
			
			// Grab the global post, switch it to the selected post, setup post data
			global $post;
			$obj = get_sub_field( 'page' );
			if( !$obj ){ return ''; }
			$post = $obj;
			setup_postdata($post);
			
			$cx++;
			
			$img_args = array(
				'width' => 400,
				'height' => 300,
				'crop' => true,
				'single' => true,
				'upscale' => true
			);
			//$img = resize_featured_image( $id, $img_args);
			
			$title = get_the_title();
			$excerpt = get_the_excerpt();
			$link = get_the_permalink();
			?>
			
			<div class="subpage-link <?php 
										// Set up the normal grid breakdown if more than 1 column
										if( $cols > 1 ){
											echo $grid_class;
											if ($cx % $cols === 1){ 
												echo ' first';
											} 
										}
										// Only add the medium grid classes if more than 1 columns
										if( $cols > 1 ){ 
											echo ' med-one-half';
											
											if($cx % 2 === 1){
												echo ' med-first'; 
											}
										} ?> ">
				<h3><?php echo $title; ?></h3>
				<?php /**if( !empty($img) ) { ?>
					<figure class="featured-thumb">
						<img src="<?php echo $img; ?>" alt="<?php echo get_the_title(); ?>" />
					</figure>
				<?php } **/?>
				<div class="excerpt">
					<?php echo $excerpt; ?>
				</div>
				<a class="button" href="<?php echo $link; ?>">Learn More</a>
			</div>
			
			<?php
			wp_reset_postdata();
		endwhile;
		$output = ob_get_contents();
		ob_end_clean();		
	endif;
	
    return $output;	
}

/**
 * Shortcode Starter
 */
//add_shortcode('starter', 'shortcode_starter');
function shortcode_starter($atts, $content = null) {

		extract(shortcode_atts(array(
				'' => '',
				'' => ''
		), $atts));

		return $output;
}

/**
 * Shortcode Starter v2
 */
//add_shortcode('shortcode_name_here', 'shortcode_function_name_here');
function shortcode_function_name_here(){
    
    // WP_Query, grab up to 100 blog posts, no paging
    $query_args =  array ( 
        'posts_per_page' => 100, 
        'post_type' => 'post', 
        'no_found_rows' => true,
    );

    $wp_query = new WP_Query( $query_args );
    
    // Begin buffering
    ob_start();
    
    // Build table or whatever
    if( $wp_query->have_posts() ) :
    
        ?>
        <table>
           <tr>
                <th>Titles</th>
            </tr>
            <?php while( $wp_query->have_posts() ) : the_post(); ?>
                <tr>
                    <td><?php the_title(); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <?php
    
    // Alternative message if there's no posts       
    else:
        
        ?>
        <h3>Sorry, but we have nothing for you.</h3>
        <?php
        
    endif;
    
    // End buffering, save, return
    $output = ob_get_clean();
    return $output;
}