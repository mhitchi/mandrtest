<div class="header-title">
    <div class="container">
        <h1>
            <?php
                if (is_home()) {
                    if (get_option('page_for_posts', true)) {
                    echo get_the_title(get_option('page_for_posts', true));
                    } else {
                        echo 'Blog';
                    }
                } elseif (is_archive()) {
                    echo get_the_archive_title();
                } elseif (is_search()) {
                    echo sprintf( 'Search Results for %s', get_search_query() );
                } elseif( valid_element(get_field('page_title')) ) {
                    echo get_field('page_title');
                } else {
                    echo get_the_title();
                }
            ?>
        </h1>

        <?php if(is_single()): ?>
            <time datetime="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_time('F j, Y'); ?></time>
            
            <?= blog_categories(); ?>

            <?= blog_tags(); ?>

            <?php if(is_single()): ?>
                
            <?php 
            $blog_page_id = get_option('page_for_posts'); 
            if( $blog_page_id ) :
                ?>
                <div class="breadcrumbs">
                    <a href="<?= get_the_permalink($blog_page_id); ?>">
                    <span class="ikes-chevron-left" aria-hidden="true"></span>
                    Back to <?= get_the_title($blog_page_id); ?></a>
                </div>
                <?php
            endif;
            ?>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>