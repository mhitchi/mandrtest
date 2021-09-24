<?php
$id = $args['id'];

if(!$id){
    return;
}

$title = get_the_title($id);
$link = get_the_permalink($id);  
$excerpt = get_the_advanced_acf_excerpt($id);

if(has_post_thumbnail($id)){
    $featured_img = acf_get_attachment(get_post_thumbnail_id($id));
    if((int)$featured_img['width'] !== 600 || (int)$featured_img['height'] !== 315){
        $image_url = aq_resize($featured_img['url'], 600, 315, true, true, true);
    }else {
        $image_url = $featured_img['url'];
    }
}else {
    $featured_img = get_field('mandr_blog_default_image', 'options');
    if(!is_array($featured_img)){
        $featured_img = acf_get_attachment($featured_img);
    }
    if((int)$featured_img['width'] !== 600 || (int)$featured_img['height'] !== 315){
        $image_url = aq_resize( $featured_img['url'], 600, 315, true, true, true );
    }else {
        $image_url = $image['url'];
    }
}

$class = 'section-wrap blog-listing blog-listing--has-thumbnail';
?>
<article class="<?= $class; ?> card-style one-half">
    <figure class="blog-listing__figure">
        <a href="<?= $link; ?>"><img class="blog-listing__image" src="<?= $image_url; ?>" alt="<?= $featured_image['alt']; ?>"></a>
    </figure>
    <div class="blog-listing__content-wrap">
        <header class="blog-listing__header">
            <h2 class="blog-listing__header__title"><a href="<?= $link; ?>"><?= $title; ?></a></h2>
            <time class="blog-listing__header__time" datetime="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_time('F j, Y'); ?></time>
            <?php
            if( blog_categories($id) ) :
                echo blog_categories($id);
            endif;
            ?>
        </header>
        <?php
        if( blog_tags($id) ) :
            echo blog_tags($id);
        endif;
        if( $excerpt ) :
            ?>
            <div class="blog-listing__excerpt">
                <?= get_the_advanced_acf_excerpt($id); ?>
            </div>
            <?php
        endif;
        ?>
        <a class="blog-listing__button button" href="<?= $link; ?>" >Read More</a>
    </div>
    
</article>