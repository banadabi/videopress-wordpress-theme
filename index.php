<?php
// Tüm yazıları tara ve YouTube/Archive.org içeriklerini işaretle
function rescan_all_posts() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    );
    
    $posts = get_posts($args);
    
    foreach ($posts as $post) {
        $content = $post->post_content;
        
        // YouTube içeriği kontrol et
        if (strpos($content, 'youtube.com/embed') !== false || 
            strpos($content, 'youtu.be') !== false ||
            strpos($content, 'youtube.com/watch') !== false) {
            update_post_meta($post->ID, '_has_youtube', '1');
            echo "YouTube içeriği işaretlendi: " . $post->post_title . "<br>";
        }
        
        // Archive.org içeriği kontrol et
        if (preg_match('/https:\/\/archive\.org\/download\/[^\s"\'<>]+\.(mp3|mp4|ogg|webm)/i', $content)) {
            update_post_meta($post->ID, '_has_archive', '1');
            echo "Archive.org içeriği işaretlendi: " . $post->post_title . "<br>";
        }
    }
    
    echo "Tüm yazılar tarandı ve işaretlendi.";
}

// Fonksiyonu çalıştır
rescan_all_posts();