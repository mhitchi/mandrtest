<?php get_header(); ?>
<main id="primary-wrap" class="primary-content" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('page post-holder'); ?>>
            <?php the_title(); ?>
            <?php the_content(); ?>
        </article>
    <?php endwhile; 
			numbered_pagination(); 
          endif; 
    ?>
</main>
<?php get_footer(); ?>