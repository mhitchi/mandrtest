<?php
add_action( 'wp_head', 'blog_index_schema' );
get_header();
?>
<main id="primary-wrap" class="primary-content" role="main">
	<div class="archive-holder">
    	<?php get_template_part( 'template-parts/title' ); ?>
		<div class="container">
			<div id="posts" class="posts">
				<section class="section-wrap double-padding">
					<?php
					if( $wp_query->have_posts() ):
						while( $wp_query->have_posts() ):
							$wp_query->the_post();
							
							get_template_part('template-parts/posts/blog-listing', null, array('id'=>get_the_ID()));

						endwhile; 
						numbered_pagination();
					else:
						?>
						<div class="no-results">
							<p>We're sorry, but there are currently no news posts available.</p>
						</div>
						<?php
					endif;
					?>
				</section>
			</div>
        </div>
    </div>
</main>
<?php get_footer(); ?>
