<?php
/**
 * Twenty Twenty-Four functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Twenty Twenty-Four
 * @since Twenty Twenty-Four 1.0
 */

/**
 * Register block styles.
 */

if ( ! function_exists( 'twentytwentyfour_block_styles' ) ) :
	/**
	 * Register custom block styles
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_styles() {

		register_block_style(
			'core/details',
			array(
				'name'         => 'arrow-icon-details',
				'label'        => __( 'Arrow icon', 'twentytwentyfour' ),
				/*
				 * Styles for the custom Arrow icon style of the Details block
				 */
				'inline_style' => '
				.is-style-arrow-icon-details {
					padding-top: var(--wp--preset--spacing--10);
					padding-bottom: var(--wp--preset--spacing--10);
				}

				.is-style-arrow-icon-details summary {
					list-style-type: "\2193\00a0\00a0\00a0";
				}

				.is-style-arrow-icon-details[open]>summary {
					list-style-type: "\2192\00a0\00a0\00a0";
				}',
			)
		);
		register_block_style(
			'core/post-terms',
			array(
				'name'         => 'pill',
				'label'        => __( 'Pill', 'twentytwentyfour' ),
				/*
				 * Styles variation for post terms
				 * https://github.com/WordPress/gutenberg/issues/24956
				 */
				'inline_style' => '
				.is-style-pill a,
				.is-style-pill span:not([class], [data-rich-text-placeholder]) {
					display: inline-block;
					background-color: var(--wp--preset--color--base-2);
					padding: 0.375rem 0.875rem;
					border-radius: var(--wp--preset--spacing--20);
				}

				.is-style-pill a:hover {
					background-color: var(--wp--preset--color--contrast-3);
				}',
			)
		);
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfour' ),
				/*
				 * Styles for the custom checkmark list block style
				 * https://github.com/WordPress/gutenberg/issues/51480
				 */
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
		register_block_style(
			'core/navigation-link',
			array(
				'name'         => 'arrow-link',
				'label'        => __( 'With arrow', 'twentytwentyfour' ),
				/*
				 * Styles for the custom arrow nav link block style
				 */
				'inline_style' => '
				.is-style-arrow-link .wp-block-navigation-item__label:after {
					content: "\2197";
					padding-inline-start: 0.25rem;
					vertical-align: middle;
					text-decoration: none;
					display: inline-block;
				}',
			)
		);
		register_block_style(
			'core/heading',
			array(
				'name'         => 'asterisk',
				'label'        => __( 'With asterisk', 'twentytwentyfour' ),
				'inline_style' => "
				.is-style-asterisk:before {
					content: '';
					width: 1.5rem;
					height: 3rem;
					background: var(--wp--preset--color--contrast-2, currentColor);
					clip-path: path('M11.93.684v8.039l5.633-5.633 1.216 1.23-5.66 5.66h8.04v1.737H13.2l5.701 5.701-1.23 1.23-5.742-5.742V21h-1.737v-8.094l-5.77 5.77-1.23-1.217 5.743-5.742H.842V9.98h8.162l-5.701-5.7 1.23-1.231 5.66 5.66V.684h1.737Z');
					display: block;
				}

				/* Hide the asterisk if the heading has no content, to avoid using empty headings to display the asterisk only, which is an A11Y issue */
				.is-style-asterisk:empty:before {
					content: none;
				}

				.is-style-asterisk:-moz-only-whitespace:before {
					content: none;
				}

				.is-style-asterisk.has-text-align-center:before {
					margin: 0 auto;
				}

				.is-style-asterisk.has-text-align-right:before {
					margin-left: auto;
				}

				.rtl .is-style-asterisk.has-text-align-left:before {
					margin-right: auto;
				}",
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_styles' );

/**
 * Enqueue block stylesheets.
 */

if ( ! function_exists( 'twentytwentyfour_block_stylesheets' ) ) :
	/**
	 * Enqueue custom block stylesheets
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_stylesheets() {
		/**
		 * The wp_enqueue_block_style() function allows us to enqueue a stylesheet
		 * for a specific block. These will only get loaded when the block is rendered
		 * (both in the editor and on the front end), improving performance
		 * and reducing the amount of data requested by visitors.
		 *
		 * See https://make.wordpress.org/core/2021/12/15/using-multiple-stylesheets-per-block/ for more info.
		 */
		wp_enqueue_block_style(
			'core/button',
			array(
				'handle' => 'twentytwentyfour-button-style-outline',
				'src'    => get_parent_theme_file_uri( 'assets/css/button-outline.css' ),
				'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
				'path'   => get_parent_theme_file_path( 'assets/css/button-outline.css' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_stylesheets' );

/**
 * Register pattern categories.
 */

if ( ! function_exists( 'twentytwentyfour_pattern_categories' ) ) :
	/**
	 * Register pattern categories
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfour_page',
			array(
				'label'       => _x( 'Pages', 'Block pattern category', 'twentytwentyfour' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfour' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_pattern_categories' );

/**
 * YouTube içeriklerini işaretlemek için mevcut gönderileri tara
 */
function videopress_scan_existing_posts() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_has_youtube',
                'compare' => 'NOT EXISTS'
            )
        )
    );
    
    $posts = get_posts($args);
    
    foreach ($posts as $post) {
        $content = $post->post_content;
        
        if (strpos($content, 'youtube.com/embed') !== false || 
            strpos($content, 'youtu.be') !== false ||
            strpos($content, 'youtube.com/watch') !== false) {
            update_post_meta($post->ID, '_has_youtube', '1');
        }
    }
}

// Tek seferlik çalıştırmak için bu fonksiyonu çağırın
// add_action('init', 'videopress_scan_existing_posts');

/**
 * YouTube ID'sini içerikten çıkarma fonksiyonu
 */
function videopress_extract_youtube_id($content) {
    $youtube_id = null;
    
    // iframe sorguları
    if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $content, $matches)) {
        $youtube_id = $matches[1];
    }
    // normal YouTube bağlantıları
    elseif (preg_match('/watch\?v=([a-zA-Z0-9_-]+)/', $content, $matches)) {
        $youtube_id = $matches[1];
    }
    // kısaltılmış bağlantılar
    elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $content, $matches)) {
        $youtube_id = $matches[1];
    }
    
    return $youtube_id;
}

/**
 * VideoPress teması için YouTube videolarını öne çıkarma fonksiyonu - Geliştirilmiş
 */
function videopress_youtube_content_filter($content) {
    if (is_single() || is_home() || is_front_page()) {
        $youtube_id = videopress_extract_youtube_id($content);
        
        if (!empty($youtube_id)) {
            $youtube_embed = '<div class="videopress-youtube-container"><iframe width="100%" height="500" src="https://www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
            
            // İçerikte iframe'i büyük embed ile değiştir
            $content = preg_replace('/<iframe.*youtube.com\/embed.*<\/iframe>/', $youtube_embed, $content, 1);
        }
    }
    return $content;
}
add_filter('the_content', 'videopress_youtube_content_filter');

/**
 * Ana sayfa için özel YouTube gösterimi
 */
function videopress_display_youtube_posts() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'meta_query' => array(
            array(
                'key' => '_has_youtube',
                'compare' => 'EXISTS'
            )
        )
    );
    
    $youtube_posts = new WP_Query($args);
    
    if ($youtube_posts->have_posts()) {
        echo '<div class="videopress-featured-videos">';
        echo '<h2 class="videopress-section-title">Videolu Sohbetler</h2>';
        echo '<div class="videopress-video-grid">';
        
        while ($youtube_posts->have_posts()) {
            $youtube_posts->the_post();
            
            $content = get_the_content();
            $youtube_id = videopress_extract_youtube_id($content);
            
            if (!empty($youtube_id)) {
                ?>
                <div class="videopress-video-item">
                    <div class="videopress-video-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/maxresdefault.jpg" alt="<?php the_title_attribute(); ?>">
                            <div class="videopress-play-button"></div>
                        </a>
                    </div>
                    <h3 class="videopress-video-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="videopress-video-meta">
                        <span class="videopress-views"><?php echo get_post_meta(get_the_ID(), 'video_views', true) ? get_post_meta(get_the_ID(), 'video_views', true) : '0'; ?> görüntülenme</span>
                        <span class="videopress-date"><?php echo get_the_date(); ?></span>
                    </div>
                </div>
                <?php
            }
        }
        
        echo '</div>';
        echo '</div>';
        
        wp_reset_postdata();
    }
}

/**
 * YouTube içeren gönderileri işaretleme
 */
function videopress_mark_youtube_posts($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    $content = get_post_field('post_content', $post_id);
    
    if (strpos($content, 'youtube.com/embed') !== false || 
        strpos($content, 'youtu.be') !== false ||
        strpos($content, 'youtube.com/watch') !== false) {
        update_post_meta($post_id, '_has_youtube', '1');
    } else {
        delete_post_meta($post_id, '_has_youtube');
    }
}
add_action('save_post', 'videopress_mark_youtube_posts');

/**
 * Archive.org dosyalarını işleme
 */
function videopress_process_archive_url($url) {
    // URL'den dosya adını ve uzantısını çıkar
    $file_info = pathinfo(parse_url($url, PHP_URL_PATH));
    $extension = isset($file_info['extension']) ? strtolower($file_info['extension']) : '';
    
    return [
        'url' => $url,
        'type' => in_array($extension, ['mp4', 'webm', 'ogg']) ? 'video' : 'audio',
        'extension' => $extension
    ];
}

/**
 * Archive.org ses dosyaları için özel player
 */
function videopress_display_audio_player($url, $title = '') {
    $file_info = pathinfo(parse_url($url, PHP_URL_PATH));
    $extension = isset($file_info['extension']) ? strtolower($file_info['extension']) : '';
    
    // Rastgele bir ID oluştur (her player için benzersiz olmalı)
    $player_id = 'audio-player-' . mt_rand(1000, 9999);
    
    ob_start();
    ?>
    <div class="tahir-audio-player" id="<?php echo esc_attr($player_id); ?>">
        <div class="tahir-audio-player-inner">
            <div class="tahir-audio-thumbnail">
                <div class="tahir-audio-icon"></div>
            </div>
            <div class="tahir-audio-details">
                <?php if (!empty($title)) : ?>
                    <h4 class="tahir-audio-title"><?php echo esc_html($title); ?></h4>
                <?php endif; ?>
                <div class="tahir-audio-controls">
                    <button class="tahir-audio-play-btn" aria-label="Oynat/Duraklat">
                        <span class="tahir-play-icon"></span>
                    </button>
                    <div class="tahir-audio-progress">
                        <div class="tahir-audio-progress-bar"></div>
                    </div>
                    <div class="tahir-audio-time">
                        <span class="tahir-audio-current-time">00:00</span>
                        <span class="tahir-audio-duration">00:00</span>
                    </div>
                    <div class="tahir-audio-volume">
                        <button class="tahir-audio-volume-btn" aria-label="Ses">
                            <span class="tahir-volume-icon"></span>
                        </button>
                        <div class="tahir-audio-volume-slider">
                            <div class="tahir-audio-volume-progress"></div>
                        </div>
                    </div>
                    <a href="<?php echo esc_url($url); ?>" download class="tahir-audio-download" aria-label="İndir">
                        <span class="tahir-download-icon"></span>
                    </a>
                </div>
            </div>
        </div>
        <audio preload="metadata">
            <source src="<?php echo esc_url($url); ?>" type="audio/<?php echo esc_attr($extension); ?>">
            Tarayıcınız audio etiketini desteklemiyor.
        </audio>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const player = document.getElementById('<?php echo esc_js($player_id); ?>');
        const audio = player.querySelector('audio');
        const playBtn = player.querySelector('.tahir-audio-play-btn');
        const playIcon = player.querySelector('.tahir-play-icon');
        const progressBar = player.querySelector('.tahir-audio-progress-bar');
        const progressContainer = player.querySelector('.tahir-audio-progress');
        const currentTime = player.querySelector('.tahir-audio-current-time');
        const duration = player.querySelector('.tahir-audio-duration');
        const volumeBtn = player.querySelector('.tahir-audio-volume-btn');
        const volumeIcon = player.querySelector('.tahir-volume-icon');
        const volumeSlider = player.querySelector('.tahir-audio-volume-slider');
        const volumeProgress = player.querySelector('.tahir-audio-volume-progress');
        
        // Oynat/Duraklat
        playBtn.addEventListener('click', function() {
            if (audio.paused) {
                audio.play();
                playIcon.classList.add('playing');
            } else {
                audio.pause();
                playIcon.classList.remove('playing');
            }
        });
        
        // İlerleme çubuğu güncelleme
        audio.addEventListener('timeupdate', function() {
            const percent = (audio.currentTime / audio.duration) * 100;
            progressBar.style.width = percent + '%';
            
            // Geçen süreyi güncelle
            const mins = Math.floor(audio.currentTime / 60);
            const secs = Math.floor(audio.currentTime % 60);
            currentTime.textContent = (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
        });
        
        // Toplam süre
        audio.addEventListener('loadedmetadata', function() {
            const mins = Math.floor(audio.duration / 60);
            const secs = Math.floor(audio.duration % 60);
            duration.textContent = (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
        });
        
        // İlerleme çubuğuna tıklama
        progressContainer.addEventListener('click', function(e) {
            const percent = e.offsetX / progressContainer.offsetWidth;
            audio.currentTime = percent * audio.duration;
        });
        
        // Ses kontrolü
        volumeBtn.addEventListener('click', function() {
            if (audio.muted) {
                audio.muted = false;
                volumeIcon.classList.remove('muted');
                volumeProgress.style.width = (audio.volume * 100) + '%';
            } else {
                audio.muted = true;
                volumeIcon.classList.add('muted');
                volumeProgress.style.width = '0%';
            }
        });
        
        // Ses seviyesi ayarı
        volumeSlider.addEventListener('click', function(e) {
            const percent = e.offsetX / volumeSlider.offsetWidth;
            audio.volume = percent;
            volumeProgress.style.width = (percent * 100) + '%';
            
            if (percent === 0) {
                audio.muted = true;
                volumeIcon.classList.add('muted');
            } else {
                audio.muted = false;
                volumeIcon.classList.remove('muted');
            }
        });
        
        // Ses seviyesini başlangıçta ayarla
        volumeProgress.style.width = (audio.volume * 100) + '%';
        
        // Oynatma tamamlandığında
        audio.addEventListener('ended', function() {
            playIcon.classList.remove('playing');
            progressBar.style.width = '0%';
            audio.currentTime = 0;
        });
    });
    </script>
    <?php
    return ob_get_clean();
}

/**
 * Son Dersler bölümü için özel fonksiyon - Geliştirilmiş
 */
function videopress_display_archive_posts() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 9,
        'meta_query' => array(
            array(
                'key' => '_has_archive',
                'compare' => 'EXISTS'
            )
        )
    );
    
    $archive_posts = new WP_Query($args);
    
    if ($archive_posts->have_posts()) {
        echo '<div class="videopress-archive-section">';
        echo '<h2 class="videopress-section-title">Sesli Dersler</h2>';
        echo '<div class="videopress-archive-grid">';
        
        while ($archive_posts->have_posts()) {
            $archive_posts->the_post();
            
            $content = get_the_content();
            $archive_url = '';
            
            // Archive.org URL'sini içerikten çıkar
            if (preg_match('/https:\/\/archive\.org\/download\/[^\s"\'<>]+\.(mp3|mp4|ogg|webm)/i', $content, $matches)) {
                $archive_url = $matches[0];
            }
            
            if (!empty($archive_url)) {
                $file_info = pathinfo(parse_url($archive_url, PHP_URL_PATH));
                $extension = isset($file_info['extension']) ? strtolower($file_info['extension']) : '';
                
                // Ses dosyası mı kontrol et
                $is_audio = in_array($extension, ['mp3', 'ogg', 'wav']);
                
                ?>
                <div class="videopress-archive-item">
                    <?php if ($is_audio) : ?>
                        <div class="videopress-archive-media">
                            <?php echo videopress_display_audio_player($archive_url, get_the_title()); ?>
                        </div>
                    <?php else : ?>
                        <div class="videopress-archive-media">
                            <video controls poster="<?php echo get_template_directory_uri(); ?>/assets/images/video-poster.jpg">
                                <source src="<?php echo esc_url($archive_url); ?>" type="video/<?php echo esc_attr($extension); ?>">
                                Tarayıcınız video etiketini desteklemiyor.
                            </video>
                        </div>
                    <?php endif; ?>
                    
                    <div class="videopress-archive-content">
                        <h3 class="videopress-archive-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="videopress-archive-meta">
                            <span class="videopress-archive-date"><?php echo get_the_date(); ?></span>
                            <span class="videopress-archive-download">
                                <a href="<?php echo esc_url($archive_url); ?>" download>İndir</a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                // Archive.org URL'si yoksa normal gösterim
                ?>
                <div class="videopress-archive-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="videopress-archive-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="videopress-archive-content">
                        <h3 class="videopress-archive-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="videopress-archive-excerpt"><?php the_excerpt(); ?></div>
                        <div class="videopress-archive-meta">
                            <span class="videopress-archive-date"><?php echo get_the_date(); ?></span>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
        echo '</div>';
        
        // Sayfalama
        echo '<div class="videopress-archive-pagination">';
        echo paginate_links(array(
            'total' => $archive_posts->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'prev_text' => '&laquo; Önceki',
            'next_text' => 'Sonraki &raquo;',
        ));
        echo '</div>';
        
        echo '</div>';
        
        wp_reset_postdata();
    }
}

/**
 * Archive.org içeren gönderileri işaretleme
 */
function videopress_mark_archive_posts($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    $content = get_post_field('post_content', $post_id);
    
    if (preg_match('/https:\/\/archive\.org\/download\/[^\s"\'<>]+\.(mp3|mp4|ogg|webm)/i', $content)) {
        update_post_meta($post_id, '_has_archive', '1');
    } else {
        delete_post_meta($post_id, '_has_archive');
    }
}
add_action('save_post', 'videopress_mark_archive_posts');

/**
 * Mevcut Archive.org içerikli gönderileri işaretleme
 */
function videopress_scan_existing_archive_posts() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_has_archive',
                'compare' => 'NOT EXISTS'
            )
        )
    );
    
    $posts = get_posts($args);
    
    foreach ($posts as $post) {
        $content = $post->post_content;
        
        if (preg_match('/https:\/\/archive\.org\/download\/[^\s"\'<>]+\.(mp3|mp4|ogg|webm)/i', $content)) {
            update_post_meta($post->ID, '_has_archive', '1');
        }
    }
}

// Meta etiketleme işlemi için özel sayfa oluştur
function create_meta_tagger_page() {
    // Sadece yöneticiler için
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // URL'de meta-tagger parametresi varsa çalıştır
    if (isset($_GET['meta-tagger']) && $_GET['meta-tagger'] == '1') {
        // Tüm yazıları tara ve YouTube/Archive.org içeriklerini işaretle
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
        
        echo '<p><a href="' . home_url('/shorts/') . '" class="button">Shorts Sayfasına Git</a></p>';
        
        // Çıkış yap
        exit;
    }
}
add_action('init', 'create_meta_tagger_page');

// Yönetim paneline meta etiketleyici bağlantısı ekle
function add_meta_tagger_link($wp_admin_bar) {
    if (current_user_can('manage_options')) {
        $args = array(
            'id'    => 'meta-tagger',
            'title' => 'Meta Etiketleyici',
            'href'  => home_url('/?meta-tagger=1'),
            'meta'  => array('class' => 'meta-tagger-link')
        );
        $wp_admin_bar->add_node($args);
    }
}
add_action('admin_bar_menu', 'add_meta_tagger_link', 999);

// Meta etiketleme işlemini düzeltme
function fix_meta_tags() {
    // Sadece yöneticiler için
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // URL'de fix-meta parametresi varsa çalıştır
    if (isset($_GET['fix-meta']) && $_GET['fix-meta'] == '1') {
        global $wpdb;
        
        // Tüm yazıları al
        $posts = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => -1,
        ));
        
        $youtube_count = 0;
        $archive_count = 0;
        
        echo '<h1>Meta Veri Düzeltme</h1>';
        echo '<ul>';
        
        foreach ($posts as $post) {
            $content = $post->post_content;
            
            // YouTube içeriği kontrol et
            if (strpos($content, 'youtube.com/embed') !== false || 
                strpos($content, 'youtu.be') !== false ||
                strpos($content, 'youtube.com/watch') !== false) {
                
                // Mevcut meta veriyi sil
                delete_post_meta($post->ID, '_has_youtube');
                
                // Yeni meta veriyi ekle
                add_post_meta($post->ID, '_has_youtube', '1', true);
                
                echo "<li>YouTube içeriği düzeltildi: <a href='".get_permalink($post->ID)."'>" . $post->post_title . "</a></li>";
                $youtube_count++;
            }
            
            // Archive.org içeriği kontrol et
            if (preg_match('/https:\/\/archive\.org\/download\/[^\s"\'<>]+\.(mp3|mp4|ogg|webm)/i', $content)) {
                
                // Mevcut meta veriyi sil
                delete_post_meta($post->ID, '_has_archive');
                
                // Yeni meta veriyi ekle
                add_post_meta($post->ID, '_has_archive', '1', true);
                
                echo "<li>Archive.org içeriği düzeltildi: <a href='".get_permalink($post->ID)."'>" . $post->post_title . "</a></li>";
                $archive_count++;
            }
        }
        
        echo '</ul>';
        echo "<p><strong>Toplam:</strong> $youtube_count YouTube içeriği, $archive_count Archive.org içeriği düzeltildi.</p>";
        
        echo '<p><a href="' . home_url('/shorts/') . '" class="button">Shorts Sayfasına Git</a></p>';
        
        // Çıkış yap
        exit;
    }
}
add_action('init', 'fix_meta_tags');

// Yönetim paneline meta düzeltme bağlantısı ekle
function add_fix_meta_link($wp_admin_bar) {
    if (current_user_can('manage_options')) {
        $args = array(
            'id'    => 'fix-meta',
            'title' => 'Meta Düzeltme',
            'href'  => home_url('/?fix-meta=1'),
            'meta'  => array('class' => 'fix-meta-link')
        );
        $wp_admin_bar->add_node($args);
    }
}
add_action('admin_bar_menu', 'add_fix_meta_link', 999);

// Lazy Loading ve srcset işlevi için lazysizes kütüphanesini ekle
function add_lazy_loading_script() {
    wp_enqueue_script('lazysizes', 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js', array(), '5.3.2', true);
}
add_action('wp_enqueue_scripts', 'add_lazy_loading_script');

// Font Awesome için
function add_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'add_font_awesome');

// Filtreleme için ayrıntılı AJAX işleyicisi
function load_more_all_posts() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $filter = isset($_POST['filter']) ? sanitize_text_field($_POST['filter']) : 'all';
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'paged' => $page,
    );
    
    // Arama sorgusu varsa, WP_Query'ye ekle
    if (!empty($search)) {
        $args['s'] = $search;
    }
    
    // Filtreler için meta sorgular ekle
    if ($filter === 'video') {
        $args['meta_query'] = array(
            array(
                'key' => '_has_youtube',
                'value' => '1',
                'compare' => '='
            )
        );
    } elseif ($filter === 'audio') {
        $args['meta_query'] = array(
            array(
                'key' => '_has_archive',
                'value' => '1',
                'compare' => '='
            )
        );
    } elseif ($filter === 'text') {
        $args['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => '_has_youtube',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => '_has_archive',
                'compare' => 'NOT EXISTS'
            )
        );
    }
    
    $all_posts = new WP_Query($args);
    
    if ($all_posts->have_posts()) {
        while ($all_posts->have_posts()) : $all_posts->the_post();
            $is_youtube = get_post_meta(get_the_ID(), '_has_youtube', true);
            $is_archive = get_post_meta(get_the_ID(), '_has_archive', true);
            $content = get_the_content();
            
            // İçerik türünü belirleme
            $content_type = 'text';
            if ($is_youtube) {
                $content_type = 'video';
            } elseif ($is_archive) {
                $content_type = 'audio';
            }
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('videopress-post-item'); ?> data-type="<?php echo esc_attr($content_type); ?>">
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
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    } else {
        echo '<div class="no-results">Hiçbir sonuç bulunamadı.</div>';
    }
    
    die();
}
add_action('wp_ajax_load_more_all_posts', 'load_more_all_posts');
add_action('wp_ajax_nopriv_load_more_all_posts', 'load_more_all_posts');

// Custom CSS dosyasını ekle
function load_custom_css() {
    wp_enqueue_style('custom-styles', get_template_directory_uri() . '/custom-style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'load_custom_css');

// Özel tek sütun düzeni CSS dosyasını ekle
function load_single_column_css() {
    wp_enqueue_style('single-column-layout', get_template_directory_uri() . '/single-column-layout.css', array(), '1.0.1');
}
add_action('wp_enqueue_scripts', 'load_single_column_css', 100); // Yüksek öncelik (100) ile yükle

// Doğrudan stil ekleme
function add_inline_single_column_styles() {
    ?>
    <style>
    /* Grid düzenini iptal edip tek sütun oluştur */
    .videopress-posts-grid {
        display: flex !important;
        flex-direction: column !important;
        grid-template-columns: none !important;
        gap: 30px !important;
        margin-top: 30px !important;
        max-width: 1200px !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }
    
    /* Post öğelerini yatay düzende göster */
    .videopress-post-item {
        background: #fff !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1) !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        margin-bottom: 0 !important;
        display: flex !important;
        flex-direction: row !important;
        width: 100% !important;
        max-width: 1200px !important;
    }
    
    /* Thumbnail boyutunu sabitle */
    .videopress-post-thumbnail {
        position: relative !important;
        flex: 0 0 300px !important;
        height: 220px !important;
    }
    
    /* İçerik alanını düzenle */
    .videopress-post-content {
        flex: 1 !important;
        padding: 25px !important;
        display: flex !important;
        flex-direction: column !important;
    }
    
    /* Başlık stilini ayarla */
    .videopress-post-title {
        font-size: 22px !important;
        font-weight: 600 !important;
        margin-bottom: 15px !important;
    }
    
    /* Özet stilini ayarla */
    .videopress-post-excerpt {
        margin-bottom: 20px !important;
        line-height: 1.6 !important;
        flex-grow: 1 !important;
    }
    
    /* Meta bilgilerini düzenle */
    .videopress-post-meta {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding-top: 15px !important;
        border-top: 1px solid #eee !important;
    }
    
    /* Mobil görünüm için düzenlemeler */
    @media (max-width: 768px) {
        .videopress-post-item {
            flex-direction: column !important;
        }
        
        .videopress-post-thumbnail {
            flex: none !important;
            width: 100% !important;
            height: 200px !important;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'add_inline_single_column_styles', 100);

// Ses URL'sini AJAX ile almak için endpoint
function get_audio_url_ajax() {
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    
    if (!$post_id) {
        wp_send_json_error('Geçersiz gönderi ID\'si');
        return;
    }
    
    $post = get_post($post_id);
    $audio_url = videopress_extract_archive_audio($post->post_content);
    
    if ($audio_url) {
        wp_send_json_success(array(
            'url' => $audio_url,
            'title' => get_the_title($post_id)
        ));
    } else {
        wp_send_json_error('Ses dosyası bulunamadı');
    }
    
    die();
}
add_action('wp_ajax_get_audio_url', 'get_audio_url_ajax');
add_action('wp_ajax_nopriv_get_audio_url', 'get_audio_url_ajax');

// Archive.org ses dosyaları için güçlendirilmiş URL çıkarma
function videopress_extract_archive_audio($content) {
    $audio_url = null;
    
    // Archive.org MP3/OGG bağlantıları
    if (preg_match('/https:\/\/archive\.org\/download\/[^\s"\'<>]+\.(mp3|ogg)/i', $content, $matches)) {
        $audio_url = $matches[0];
    }
    // Alternatif olarak iFrame embed URL'lerini kontrol et
    elseif (preg_match('/https:\/\/archive\.org\/embed\/([^"\'<>\s]+)/i', $content, $matches)) {
        $archive_id = $matches[1];
        // URL'yi varsayılan MP3'e çevir
        $audio_url = "https://archive.org/download/{$archive_id}/{$archive_id}.mp3";
    }
    
    return $audio_url;
}

// Kategori bazlı filtreleme için AJAX işleyici
function load_category_posts() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $filter = isset($_POST['filter']) ? sanitize_text_field($_POST['filter']) : 'all';
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'paged' => $page
    );
    
    // Arama sorgusu varsa ekle
    if (!empty($search)) {
        $args['s'] = $search;
    }
    
    // Kategori filtresi ekle
    if ($category !== 'all') {
        $args['cat'] = intval($category);
    }
    
    // İçerik türü filtresi ekle
    if ($filter === 'video') {
        $args['meta_query'] = array(
            array(
                'key' => '_has_youtube',
                'value' => '1',
                'compare' => '='
            )
        );
    } elseif ($filter === 'audio') {
        $args['meta_query'] = array(
            array(
                'key' => '_has_archive',
                'value' => '1',
                'compare' => '='
            )
        );
    } elseif ($filter === 'text') {
        $args['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => '_has_youtube',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => '_has_archive',
                'compare' => 'NOT EXISTS'
            )
        );
    }
    
    $category_posts = new WP_Query($args);
    
    ob_start();
    if ($category_posts->have_posts()) {
        while ($category_posts->have_posts()) : $category_posts->the_post();
            // Mevcut post görüntüleme kodu buraya
            $is_youtube = get_post_meta(get_the_ID(), '_has_youtube', true);
            $is_archive = get_post_meta(get_the_ID(), '_has_archive', true);
            $content = get_the_content();
            
            // İçerik türünü belirleme
            $content_type = 'text';
            if ($is_youtube) {
                $content_type = 'video';
            } elseif ($is_archive) {
                $content_type = 'audio';
            }
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('videopress-post-item'); ?> data-type="<?php echo esc_attr($content_type); ?>">
                <?php include(locate_template('template-parts/content-card.php')); ?>
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    } else {
        echo '<div class="no-results">Bu kategoride içerik bulunamadı.</div>';
    }
    $content = ob_get_clean();
    
    $response = array(
        'content' => $content,
        'max_pages' => $category_posts->max_num_pages,
        'found_posts' => $category_posts->found_posts
    );
    
    wp_send_json_success($response);
    die();
}
add_action('wp_ajax_load_category_posts', 'load_category_posts');
add_action('wp_ajax_nopriv_load_category_posts', 'load_category_posts');
