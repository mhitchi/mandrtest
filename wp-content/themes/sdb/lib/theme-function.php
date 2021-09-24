<?php
/**
 * function to display button
 */
function mr_display_button($text, $link, $classes = array(), $include_text_wrapper = false){
	?>
	<a href="<?= $link; ?>" class="button <?= implode(',', $classes); ?>"><?= ($include_text_wrapper ? '<span class="link-text">' : ''); ?><?= $text; ?><?= ($include_text_wrapper === true ? '</span>' : ''); ?></a>
	<?php
}
/**
 * Import SVG code from filepath
 * https://stackoverflow.com/questions/29991284/php-get-svg-tag-from-svg-file-and-show-it-in-html-in-div
 * 
 * @param string $file Filepath string for SVG
 * @return object
 */
function import_SVG($file) {
	if( !$file ) {
		return false;
	}

	$svg_file = file_get_contents($file);

	$find_string   = '<svg';
	$position = strpos($svg_file, $find_string);

	$svg_file_new = substr($svg_file, $position);

	return $svg_file_new;
}

/**
 * Process CSV file
 * 
 * @param String $file URL to CSV file
 * @param Function $callback Pass an optional callback function
 * @param Array $args Pass an array of arguments to include in callback
 */
function process_csv_file( $file, $callback = null, $args = null ){
	$row = 0;
    $cx = 0;

	if( ( $csv = fopen( $file, 'r' ) ) !== false ) {
        while ( ( $data = fgetcsv( $csv, 9999, ',' ) ) !== false ) {
            $row++;

			// Callback function will include row iterator, data array and optional args
			if( $callback !== null ) $callback( $row, $data, $args );
        }

        fclose( $csv );
    }
}

/**
 * Return the variable width custom field as column class name
 */
function module_get_variable_column_classname($width){
    switch($width) :
        case '1/3' :
            $width = 'one-third';
            break;
        case '2/3' :
            $width = 'two-thirds';
            break;
        case '1/4' :
            $width = 'one-fourth';
            break;
        case '3/4' :
            $width = 'three-fourths';
            break;
        case '2/5' :
            $width = 'two-fifths';
			break;
		case '3/5' :
			$width = 'three-fifths';
			break;
		default :
			$width = '';
		break;
	endswitch;

	return $width;
}

/**
 * Dynamically generate standard-layout column width classes
 */
function module_get_column_width($column, $total, $row){
    $size = '';
    switch($total) :
        case 2 :
            $size = 'one-half';
            break;
        case 3 :
            $size = 'one-third';
            break;
        case 4 :
            $size = 'one-fourth';
            break;
        case 5 :
            $size = 'one-fifth';
            break;
        case 6 :
            $size = 'one-sixth';
			break;
		default :
			$size = '';
		break;
	endswitch;
	
	// Boolean checks
	$isFirstColumn = $column === 0 ? true : false;
	$isVariable = $total === 7 ? true : false;
	$isSingle = $total === 1 ? true : false;

	// Variable columns
	if( $isVariable ) {
		$left_width = $row['left_column_width'];
		$right_width = $row['right_column_width'];

		if( $isFirstColumn ){
			$size = module_get_variable_column_classname($left_width);
		} else {
			$size = module_get_variable_column_classname($right_width);
		}
	}

	// Append .first class
    if( $isFirstColumn && !$isSingle) {
        $size .= ' first';
    }

    echo $size;
}

/* localize nav variable */
function localize_fullpage_nav_variable() {
	
	$nav_id = get_field('fullpage_navigation');	
	$returnArray = array();
	$count = 1;
	
	$returnArray[0]['anchor'] = $nav_id;
	
	while (have_rows('fullpage_page_layouts')) : the_row();
		$section_anchor = get_sub_field('section_id');
		$returnArray[$count]['anchor'] = $section_anchor;
		$count++; 
	endwhile;
	
	return $returnArray;
}

function echo_slugs_from_object_array( $arr ) {
	if( !empty($arr) ) {
		foreach( $arr as $trm ) :
			echo $trm->slug.',';
		endforeach;	
	}
}

function get_section_style() {
	
    $section_bg = get_sub_field('section_background');
    $apply_text_color = get_sub_field('apply_text_color');
    $section_text_color = get_sub_field('section_text_color');

	switch( $section_bg ) :
		case 'Image':
			$section_style = "background-image:url('".get_sub_field('section_background_image')."');";
			break;
		case 'Color':
			$section_style = 'background-color:'.get_sub_field('section_background_color').';';
			break;
		case 'Transparent':
		default:
			$section_style = '';
			break;
    endswitch;

    // if($apply_text_color && $section_text_color !== false){
    //     $section_style .= 'color:'.$section_text_color.';';
    // }

	return $section_style;
}

function email_link( $email ) {
	$return = "<a href='mailto:".antispambot($email)."' target='_blank' rel='noopener noreferrer'>".antispambot($email)."</a>";
	return $return;
}
function phone_tel_number( $phone ) {
	return preg_replace('/\D+/', '', $phone);
}
function phone_link( $phone ) {
	$return = "<a href='tel:".phone_tel_number($phone)."' target='_blank' rel='noopener noreferrer'>".$phone."</a>";
	return $return;
}

/* localize script for google map */
function localize_google_map_data() {
	
	$returnArray = array();
	if ( have_rows('map_locations', 'option' ) ) {
		
		$cx = count( get_field('map_locations', 'option' ) );
		$ix = 0;
		
		while ( have_rows('map_locations', 'option' ) ) {
			the_row();
			$thisLocation = get_sub_field( 'map', 'option' );
			$returnArray[$ix]['title'] = get_sub_field( 'title', 'option' );
			$returnArray[$ix]['address'] = $thisLocation['address'];
			$returnArray[$ix]['phone'] = get_sub_field( 'location_phone', 'option' );
			$returnArray[$ix]['hours'] = get_sub_field( 'location_hours', 'option' );  
			$returnArray[$ix]['lat'] = $thisLocation['lat'];
			$returnArray[$ix]['lng'] = $thisLocation['lng'];   
			$ix++;
		}
	}else {
		$returnArray = false;
	}
	
	return $returnArray;
}

/* localize script for advanced locations */
function localize_adv_locations_data() {
	$query = new WP_Query(array(
		'post_type' => 'mandr_location',
		'status' => 'publish',
		'nopaging' => true,
	));

	if ( $query->have_posts() ) {
		$returnArray = array(
			'type' => 'FeatureCollection',
			'features' => array()
		);

		while ( $query->have_posts() ) {
			$query->the_post();
			$location_title = get_the_title();
			$location_lat = get_field('location_lat');
			$location_lng = get_field('location_lng');
			$location_description = get_field('location_description');
			$location_phone = get_field('location_phone');
			$location_phone_formatted = get_field('location_phone_formatted');
			$location_address_formatted = get_field('location_address_formatted');
			
			if( $location_lat && $location_lng ) {
				
				$returnArray['features'][] = array(
					'type' => 'Feature',
					'geometry' => array(
						'type' => 'Point',
						'coordinates' => array(
							$location_lng,
							$location_lat
						)
					),
					'properties' => array(
						'name' => $location_title,
						'description' => $location_description,
						'phoneFormatted' => $location_phone_formatted,
						'phone' => $location_phone,
						'address' => $location_address_formatted,			
					)
				);
			}
		}
		
	}else {
		$returnArray = false;
	}
	wp_reset_postdata();
	
	return $returnArray;
}

//acf remove autop
function the_field_without_wpautop( $field_name ) {
	
	remove_filter('acf_the_content', 'wpautop');
	
	the_field( $field_name );
	
	add_filter('acf_the_content', 'wpautop');
                
}

/* Display Vimeo Videos */
function print_vimeo_list() {
	
	ob_start();
	
	if( have_rows('asdfvideos') ):
		$count = 0;
		?>
		<div class="video-list">
		<?php
		while ( have_rows('asdfvideos') ) : 
			the_row();
			
			$count++;
			
			if($count % 2 === 1){
				$first = ' first';
			}else{
				$first = '';
			}
			
			$title = get_sub_field('title');
			$video_url = get_sub_field('vimeo_link');
			$description = get_sub_field('vimeo_description');
			
			$oembed_endpoint = 'http://vimeo.com/api/oembed';
			$xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url) . '&width=480';

			// Load in the oEmbed XML
			$oembed = simplexml_load_string(curl_get($xml_url));
			
			$video_player = html_entity_decode($oembed->html);
			$video_image = html_entity_decode($oembed->thumbnail_url);

			?>
			<div class="video-item one-half <?php echo $first; ?>">
				<h3><?php echo $title; ?></h3>
				<div class="iframe-embed video-link">
				<?php echo $video_player; ?>
				<!--
					<a href="<?php //echo $video_url; ?>" rel="prettyPhoto">
						<img src="<?php //echo $video_image; ?>">
						<span class="hover-icon"></span>
					</a> -->
				</div>		
				<?php if( $description ) { ?>
					<div class="video-description">
						<?php echo $description; ?>
					</div>
				<?php } ?>
			</div>
			<?php
		endwhile;
		?>
		</div>
		<?php
	endif;
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;		
}

/* Single Vimeo Video */
function print_vimeo_video() {
	
	$output = '';
	
	ob_start();
	$video_url = get_field('vimeo_link');
	
	if( $video_url ) {
		$video_url = get_field('vimeo_link');
		
		$oembed_endpoint = 'http://vimeo.com/api/oembed';
		$xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url) . '&width=480';

		// Load in the oEmbed XML
		$oembed = simplexml_load_string(curl_get($xml_url));
		
		$video_player = html_entity_decode($oembed->html);
		$video_image = html_entity_decode($oembed->thumbnail_url);

		?>
		<div class="video-item">
			<div class="iframe-embed video-link">
				<?php echo $video_player; ?>
			</div>
		</div>
		<?php
	}
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;		
}

// Take any standard youtube link and return the video ID
function youtube_video_id($url){
	// Youtube Video id is 11 characters in length
	$video_pattern = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i';
		
	return preg_replace($video_pattern, '$1', $url);
}

// Curl helper function
function curl_get($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	$return = curl_exec($curl);
	curl_close($curl);
	return $return;
}

// Limit a string by word count, append ellipses
function my_string_limit_words($string, $word_limit = 0)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if($word_limit > 0 && count($words) > $word_limit) {
      array_pop($words);
      return implode(' ', $words).'... ';
  }else{
      return $string;      
  }
}

// Limit a string by character count, append ellipses
function my_string_limit_char($string, $substr = 0)
{
	$string = strip_tags(str_replace('...', '...', $string));
	if ( $substr > 0 && strlen($string) > $substr ) {
		$string = rtrim(substr($string, 0, $substr)) . ' ...';
	}
	return $string;
}

//Add formatting to get_the_content
function get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}

// Remove invalid tags
function remove_invalid_tags($str, $tags) 
{
    foreach($tags as $tag)
    {
    	$str = preg_replace('#^<\/'.$tag.'>|<'.$tag.'>$#', '', trim($str));
    }

    return $str;
}

/**
 * Validate if element is not null, an empty string or false.
 */
function valid_element($e){
    if($e === null || $e === '' || $e === false){
        return false;
    }

    return true;
}

// debug help
if (!function_exists('write_log')) {
	function write_log ( $log )  {
		if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, true ) );
		} else {
			error_log( $log );
		}
	}
}
