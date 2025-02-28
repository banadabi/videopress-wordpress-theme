<?php
/**
 * İçerik kartı template dosyası
 */
?>

<?php if ($is_youtube) : 
    $youtube_id = videopress_extract_youtube_id($content);
    if ($youtube_id) : ?>
        <div class="videopress-post-thumbnail youtube-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/hqdefault.jpg" 
                     data-src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/maxresdefault.jpg"
                     data-srcset="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/maxresdefault.jpg 1280w,
                                 https://img.youtube.com/vi/<?php echo $youtube_id; ?>/hqdefault.jpg 480w"
                     sizes="(max-width: 768px) 100vw, 300px"
                     class="lazyload"
                     alt="<?php the_title_attribute(); ?>">
                <div class="videopress-play-button"></div>
            </a>
        </div>
    <?php endif; ?>
<?php elseif ($is_archive) : ?>
    <div class="videopress-post-thumbnail archive-thumbnail">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php 
                $thumb_id = get_post_thumbnail_id();
                $thumb_url = wp_get_attachment_image_src($thumb_id, 'medium_large', true);
                $thumb_large = wp_get_attachment_image_src($thumb_id, 'large', true);
                $thumb_small = wp_get_attachment_image_src($thumb_id, 'medium', true);
                ?>
                <img src="<?php echo $thumb_small[0]; ?>"
                     data-src="<?php echo $thumb_url[0]; ?>"
                     data-srcset="<?php echo $thumb_large[0]; ?> 1024w, <?php echo $thumb_url[0]; ?> 768w, <?php echo $thumb_small[0]; ?> 300w"
                     sizes="(max-width: 768px) 100vw, 300px"
                     class="lazyload"
                     alt="<?php the_title_attribute(); ?>">
            <?php else : ?>
                <div class="archive-audio-icon"></div>
            <?php endif; ?>
        </a>
    </div>
<?php elseif (has_post_thumbnail()) : ?>
    <div class="videopress-post-thumbnail">
        <a href="<?php the_permalink(); ?>">
            <?php 
            $thumb_id = get_post_thumbnail_id();
            $thumb_url = wp_get_attachment_image_src($thumb_id, 'medium_large', true);
            $thumb_large = wp_get_attachment_image_src($thumb_id, 'large', true);
            $thumb_small = wp_get_attachment_image_src($thumb_id, 'medium', true);
            ?>
            <img src="<?php echo $thumb_small[0]; ?>"
                 data-src="<?php echo $thumb_url[0]; ?>"
                 data-srcset="<?php echo $thumb_large[0]; ?> 1024w, <?php echo $thumb_url[0]; ?> 768w, <?php echo $thumb_small[0]; ?> 300w"
                 sizes="(max-width: 768px) 100vw, 300px"
                 class="lazyload"
                 alt="<?php the_title_attribute(); ?>">
        </a>
    </div>
<?php else : ?>
    <div class="videopress-post-thumbnail default-thumbnail">
        <a href="<?php the_permalink(); ?>">
            <div class="default-thumbnail-icon"></div>
        </a>
    </div>
<?php endif; ?>

<div class="videopress-post-content">
    <h3 class="videopress-post-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
    
    <div class="videopress-post-excerpt">
        <?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?>
    </div>
    
    <div class="videopress-post-meta">
        <span class="videopress-post-date"><?php echo get_the_date(); ?></span>
        <?php if ($is_youtube) : ?>
            <span class="videopress-post-type youtube-type">Video</span>
        <?php elseif ($is_archive) : ?>
            <span class="videopress-post-type archive-type">Ses</span>
        <?php else : ?>
            <span class="videopress-post-type text-type">Yazı</span>
        <?php endif; ?>
    </div>
</div> 