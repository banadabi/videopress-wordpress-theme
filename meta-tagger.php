<?php
/**
 * Template Name: Meta Etiketleyici
 */

// WordPress'i yükle
require_once('../../../wp-load.php');

// Tüm yazıları tara ve YouTube/Archive.org içeriklerini işaretle
function rescan_all_posts() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    );
    
    $posts = get_posts($args);
    $youtube_count = 0;
    $archive_count = 0;
    
    echo '<h1>İçerik Tarama Sonuçları</h1>';
    echo '<ul>';
    
    foreach ($posts as $post) {
        $content = $post->post_content;
        
        // YouTube içeriği kontrol et
        if (strpos($content, 'youtube.com/embed') !== false || 
            strpos($content, 'youtu.be') !== false ||
            strpos($content, 'youtube.com/watch') !== false) {
            update_post_meta($post->ID, '_has_youtube', '1');
            echo "<li>YouTube içeriği işaretlendi: <a href='".get_permalink($post->ID)."'>" . $post->post_title . "</a></li>";
            $youtube_count++;
        }
        
        // Archive.org içeriği kontrol et
        if (preg_match('/https:\/\/archive\.org\/download\/[^\s"\'<>]+\.(mp3|mp4|ogg|webm)/i', $content)) {
            update_post_meta($post->ID, '_has_archive', '1');
            echo "<li>Archive.org içeriği işaretlendi: <a href='".get_permalink($post->ID)."'>" . $post->post_title . "</a></li>";
            $archive_count++;
        }
    }
    
    echo '</ul>';
    echo "<p><strong>Toplam:</strong> $youtube_count YouTube içeriği, $archive_count Archive.org içeriği işaretlendi.</p>";
    
    if ($youtube_count == 0 && $archive_count == 0) {
        echo '<div style="color: red; padding: 15px; border: 1px solid red; margin: 20px 0;">';
        echo '<h2>Hiç içerik bulunamadı!</h2>';
        echo '<p>Shorts sayfasının çalışması için YouTube veya Archive.org içerikli yazılar eklemeniz gerekiyor.</p>';
        echo '<p>Örnek YouTube içeriği:</p>';
        echo '<pre>&lt;iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;</pre>';
        echo '<p>Örnek Archive.org içeriği:</p>';
        echo '<pre>https://archive.org/download/DOSYA_ADI/dosya.mp3</pre>';
        echo '</div>';
    }
}

// Fonksiyonu çalıştır
rescan_all_posts();
?> 