<?php
/**
 * Template Name: Shorts Sayfası
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
    <!-- Font Awesome 6.4.0 sürümünü kullanalım -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    /* Doğrudan stil ekleme */
    body.dark-mode {
        background-color: #121212 !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode .tahir-shorts-header {
        background-color: #1a1a1a !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
    }

    body.dark-mode .tahir-shorts-title {
        color: #e0e0e0 !important;
    }

    body.dark-mode .tahir-shorts-subtitle {
        color: #aaaaaa !important;
    }

    body.dark-mode .tahir-short-card {
        background-color: #1e1e1e !important;
        border-color: #333 !important;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3) !important;
    }

    body.dark-mode .tahir-short-title {
        color: #e0e0e0 !important;
        border-bottom-color: #333 !important;
    }

    body.dark-mode .tahir-short-meta {
        color: #aaaaaa !important;
    }

    body.dark-mode .tahir-short-date {
        color: #aaaaaa !important;
    }

    body.dark-mode .tahir-short-link {
        color: #4d8edb !important;
        background-color: rgba(77, 142, 219, 0.1) !important;
    }

    body.dark-mode .tahir-short-link:hover {
        background-color: #4d8edb !important;
        color: #fff !important;
    }

    body.dark-mode .tahir-theme-toggle {
        background-color: #4d8edb !important;
    }

    .tahir-theme-toggle {
        position: fixed !important;
        bottom: 30px !important;
        right: 30px !important;
        width: 60px !important;
        height: 60px !important;
        border-radius: 50% !important;
        background-color: #0066cc !important;
        color: #fff !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        cursor: pointer !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
        z-index: 9999 !important;
        border: none !important;
    }

    .tahir-theme-toggle i {
        font-size: 28px !important;
    }
    </style>
</head>
<body class="tahir-shorts-body">
    <div class="tahir-mobile-app">
        <div class="tahir-shorts-header">
            <h1 class="tahir-shorts-title">Video ve Ses İçerikleri</h1>
            <p class="tahir-shorts-subtitle">YouTube ve Archive.org içeriklerinin tamamını burada bulabilirsiniz</p>
        </div>
        <div class="tahir-shorts-container">
            <?php
            // Sorgu parametrelerini güncelle
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 12,
                'paged' => $paged,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => '_has_youtube',
                        'value' => '1',
                        'compare' => '='
                    ),
                    array(
                        'key' => '_has_archive',
                        'value' => '1',
                        'compare' => '='
                    )
                )
            );
            
            $shorts_query = new WP_Query($args);
            
            if ($shorts_query->have_posts()) :
                echo '<div class="tahir-shorts-grid">';
                
                while ($shorts_query->have_posts()) : $shorts_query->the_post();
                    $content = get_the_content();
                    $is_youtube = get_post_meta(get_the_ID(), '_has_youtube', true);
                    $is_archive = get_post_meta(get_the_ID(), '_has_archive', true);
                    
                    echo '<div class="tahir-short-card">';
                    echo '<h3 class="tahir-short-title">' . get_the_title() . '</h3>';
                    
                    if ($is_youtube) {
                        $youtube_id = videopress_extract_youtube_id($content);
                        if ($youtube_id) {
                            echo '<div class="tahir-video-wrapper">';
                            echo '<iframe width="100%" height="200" src="https://www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allowfullscreen></iframe>';
                            echo '</div>';
                        }
                    }
                    
                    if ($is_archive) {
                        if (preg_match('/https:\/\/archive\.org\/download\/[^\s"\'<>]+\.(mp3|mp4|ogg|webm)/i', $content, $matches)) {
                            $media_url = $matches[0];
                            $extension = pathinfo(parse_url($media_url, PHP_URL_PATH), PATHINFO_EXTENSION);
                            
                            if (in_array($extension, ['mp3', 'ogg', 'wav'])) {
                                echo '<div class="tahir-audio-wrapper">';
                                echo '<audio controls src="' . $media_url . '" style="width:100%"></audio>';
                                echo '</div>';
                            } else {
                                echo '<div class="tahir-video-wrapper">';
                                echo '<video width="100%" height="200" controls><source src="' . $media_url . '" type="video/' . $extension . '"></video>';
                                echo '</div>';
                            }
                        }
                    }
                    
                    echo '<div class="tahir-short-meta">';
                    echo '<span class="tahir-short-date">' . get_the_date() . '</span>';
                    echo '<a href="' . get_permalink() . '" class="tahir-short-link">Detaylar</a>';
                    echo '</div>';
                    
                    echo '</div>';
                endwhile;
                
                echo '</div>';
                wp_reset_postdata();
            else :
                echo '<p>Hiç içerik bulunamadı.</p>';
            endif;
            
            // Sayfalama kodunu ekle - Gizli olarak ekleyelim
            echo '<div class="tahir-pagination" style="display:none;">';
            echo paginate_links(array(
                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $shorts_query->max_num_pages,
                'prev_text' => '&laquo; Önceki',
                'next_text' => 'Sonraki &raquo;',
            ));
            echo '</div>';

            // Yükleniyor göstergesi
            echo '<div class="tahir-loading"><div class="tahir-loading-spinner"></div></div>';

            // Sonsuz kaydırma için JavaScript
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                const grid = document.querySelector(".tahir-shorts-grid");
                const pagination = document.querySelector(".tahir-pagination");
                const loading = document.querySelector(".tahir-loading");
                let currentPage = ' . max(1, get_query_var("paged")) . ';
                let maxPages = ' . $shorts_query->max_num_pages . ';
                let isLoading = false;
                
                // Sayfa sonuna gelince yeni içerik yükle
                window.addEventListener("scroll", function() {
                    if (isLoading) return;
                    
                    // Sayfanın sonuna yaklaşıldı mı kontrol et
                    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
                        loadMoreContent();
                    }
                });
                
                function loadMoreContent() {
                    if (currentPage >= maxPages) return;
                    
                    isLoading = true;
                    currentPage++;
                    loading.style.display = "block";
                    
                    // AJAX isteği gönder
                    fetch("' . admin_url("admin-ajax.php") . '", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: "action=load_more_shorts&page=" + currentPage
                    })
                    .then(response => response.text())
                    .then(data => {
                        loading.style.display = "none";
                        
                        // Yeni içeriği ekle
                        const tempDiv = document.createElement("div");
                        tempDiv.innerHTML = data;
                        const newItems = tempDiv.querySelectorAll(".tahir-short-card");
                        
                        newItems.forEach(item => {
                            grid.appendChild(item);
                        });
                        
                        isLoading = false;
                    })
                    .catch(error => {
                        console.error("Hata:", error);
                        loading.style.display = "none";
                        isLoading = false;
                    });
                }
            });
            </script>';
            ?>
        </div>
    </div>
    
    <script>
    // Hata ayıklama için
    console.log('Theme script loaded');
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded');
        const themeToggle = document.getElementById('themeToggle');
        console.log('Theme toggle button:', themeToggle);
        const shortItems = document.querySelectorAll('.tahir-short-item');
        const shortsContainer = document.querySelector('.tahir-shorts-container');
        let currentIndex = 0;
        let players = [];
        
        // Tüm ses oynatıcılarını başlat
        shortItems.forEach((item, index) => {
            const audio = item.querySelector('audio');
            if (audio) {
                const playBtn = item.querySelector('.tahir-audio-short-play-btn');
                const playIcon = item.querySelector('.tahir-audio-short-play-icon');
                const progressBar = item.querySelector('.tahir-audio-short-progress-bar');
                const progressContainer = item.querySelector('.tahir-audio-short-progress');
                const currentTime = item.querySelector('.tahir-audio-short-current-time');
                const duration = item.querySelector('.tahir-audio-short-duration');
                
                players[index] = {
                    audio: audio,
                    playBtn: playBtn,
                    playIcon: playIcon,
                    progressBar: progressBar,
                    progressContainer: progressContainer,
                    currentTime: currentTime,
                    duration: duration,
                    isPlaying: false
                };
                
                // Oynat/Duraklat
                if (playBtn) {
                    playBtn.addEventListener('click', function() {
                        togglePlay(index);
                    });
                }
                
                // İlerleme çubuğu güncelleme
                audio.addEventListener('timeupdate', function() {
                    updateProgress(index);
                });
                
                // Toplam süre
                audio.addEventListener('loadedmetadata', function() {
                    updateDuration(index);
                });
                
                // İlerleme çubuğuna tıklama
                if (progressContainer) {
                    progressContainer.addEventListener('click', function(e) {
                        const percent = e.offsetX / progressContainer.offsetWidth;
                        audio.currentTime = percent * audio.duration;
                    });
                }
                
                // Oynatma tamamlandığında
                audio.addEventListener('ended', function() {
                    resetPlayer(index);
                });
            }
        });
        
        // Kaydırma olayını dinle
        shortsContainer.addEventListener('scroll', function() {
            const scrollPosition = shortsContainer.scrollTop;
            const windowHeight = window.innerHeight;
            
            shortItems.forEach((item, index) => {
                const itemTop = item.offsetTop;
                const itemHeight = item.offsetHeight;
                
                if (scrollPosition >= itemTop - windowHeight / 2 && 
                    scrollPosition < itemTop + itemHeight - windowHeight / 2) {
                    if (currentIndex !== index) {
                        // Önceki oynatıcıyı durdur
                        if (players[currentIndex] && players[currentIndex].isPlaying) {
                            pausePlayer(currentIndex);
                        }
                        
                        currentIndex = index;
                        
                        // Yeni oynatıcıyı otomatik başlat (isteğe bağlı)
                        // if (players[currentIndex]) {
                        //     playPlayer(currentIndex);
                        // }
                    }
                }
            });
        });
        
        // Oynatıcıyı başlat
        function playPlayer(index) {
            if (players[index]) {
                players[index].audio.play();
                players[index].playIcon.classList.add('playing');
                players[index].isPlaying = true;
            }
        }
        
        // Oynatıcıyı durdur
        function pausePlayer(index) {
            if (players[index]) {
                players[index].audio.pause();
                players[index].playIcon.classList.remove('playing');
                players[index].isPlaying = false;
            }
        }
        
        // Oynatıcıyı sıfırla
        function resetPlayer(index) {
            if (players[index]) {
                players[index].playIcon.classList.remove('playing');
                players[index].progressBar.style.width = '0%';
                players[index].audio.currentTime = 0;
                players[index].isPlaying = false;
            }
        }
        
        // Oynat/Durdur
        function togglePlay(index) {
            if (players[index]) {
                if (players[index].isPlaying) {
                    pausePlayer(index);
                } else {
                    // Diğer tüm oynatıcıları durdur
                    players.forEach((player, i) => {
                        if (i !== index && player && player.isPlaying) {
                            pausePlayer(i);
                        }
                    });
                    
                    playPlayer(index);
                }
            }
        }
        
        // İlerleme çubuğunu güncelle
        function updateProgress(index) {
            if (players[index]) {
                const audio = players[index].audio;
                const percent = (audio.currentTime / audio.duration) * 100;
                players[index].progressBar.style.width = percent + '%';
                
                // Geçen süreyi güncelle
                const mins = Math.floor(audio.currentTime / 60);
                const secs = Math.floor(audio.currentTime % 60);
                players[index].currentTime.textContent = (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
            }
        }
        
        // Toplam süreyi güncelle
        function updateDuration(index) {
            if (players[index]) {
                const audio = players[index].audio;
                const mins = Math.floor(audio.duration / 60);
                const secs = Math.floor(audio.duration % 60);
                players[index].duration.textContent = (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
            }
        }
    });
    </script>
    
    <!-- Dark Mode Toggle Butonu -->
    <button class="tahir-theme-toggle" id="themeToggle" aria-label="Tema Değiştir">
        <i class="fas fa-moon"></i>
    </button>

    <script>
    // Dark Mode JavaScript - Güçlendirilmiş
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded for theme toggle');
        
        // Tema değiştirme düğmesini seçelim
        const themeToggle = document.getElementById('themeToggle');
        
        if (!themeToggle) {
            console.error('Theme toggle button not found!');
            return;
        }
        
        console.log('Theme toggle button found:', themeToggle);
        
        const themeIcon = themeToggle.querySelector('i');
        const body = document.body;
        
        // Kaydedilmiş temayı kontrol et
        const savedTheme = localStorage.getItem('tahir-theme');
        console.log('Saved theme:', savedTheme);
        
        // Önce tüm tema sınıflarını temizle
        body.classList.remove('light-mode', 'dark-mode');
        
        // Tema uygula
        if (savedTheme === 'dark-mode') {
            console.log('Applying dark mode');
            body.classList.add('dark-mode');
            document.documentElement.setAttribute('data-theme', 'dark');
            updateThemeIcon('dark-mode');
        } else {
            console.log('Applying light mode');
            body.classList.add('light-mode');
            document.documentElement.setAttribute('data-theme', 'light');
            updateThemeIcon('light-mode');
        }
        
        // Tema değiştirme düğmesi
        themeToggle.addEventListener('click', function() {
            console.log('Theme toggle clicked');
            
            if (body.classList.contains('dark-mode')) {
                console.log('Switching to light mode');
                body.classList.remove('dark-mode');
                body.classList.add('light-mode');
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('tahir-theme', 'light-mode');
                updateThemeIcon('light-mode');
                console.log('Light mode activated');
            } else {
                console.log('Switching to dark mode');
                body.classList.remove('light-mode');
                body.classList.add('dark-mode');
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('tahir-theme', 'dark-mode');
                updateThemeIcon('dark-mode');
                console.log('Dark mode activated');
            }
        });
        
        // Tema ikonunu güncelle
        function updateThemeIcon(theme) {
            if (!themeIcon) {
                console.error('Theme icon not found!');
                return;
            }
            
            if (theme === 'dark-mode') {
                themeIcon.className = ''; // Tüm sınıfları temizle
                themeIcon.classList.add('fas', 'fa-sun');
            } else {
                themeIcon.className = ''; // Tüm sınıfları temizle
                themeIcon.classList.add('fas', 'fa-moon');
            }
        }
    });
    </script>
    
    <?php wp_footer(); ?>
</body>
</html> 