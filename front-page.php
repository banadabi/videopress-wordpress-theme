<?php get_header(); ?>

<div class="videopress-container">
    <?php 
    // Mevcut YouTube içerikli gönderileri işaretle
    if (!get_option('videopress_scanned_posts')) {
        videopress_scan_existing_posts();
        update_option('videopress_scanned_posts', '1');
    }
    ?>
    
    <!-- Kategori Sekmeleri -->
    <div class="videopress-category-tabs">
        <div class="category-tab active" data-category="all">Tüm Kategoriler</div>
        <?php
        // WordPress kategorilerini al
        $categories = get_categories(array(
            'orderby' => 'count',
            'order'   => 'DESC',
            'hide_empty' => true,
            'number'  => 10 // En popüler 10 kategori
        ));
        
        foreach ($categories as $category) {
            $cat_id = $category->term_id;
            $cat_name = $category->name;
            echo '<div class="category-tab" data-category="' . $cat_id . '">' . $cat_name . '</div>';
        }
        ?>
    </div>
    
    <!-- Filtreleme ve Arama Bölümü -->
    <div class="videopress-filter-container">
        <div class="videopress-filter-buttons">
            <button class="filter-button active" data-filter="all">Tüm İçerikler</button>
            <button class="filter-button" data-filter="video">Videolar</button>
            <button class="filter-button" data-filter="audio">Sesli İçerik</button>
            <button class="filter-button" data-filter="text">Yazılar</button>
        </div>
        
        <div class="videopress-search-box">
            <input type="text" class="videopress-search-input" placeholder="İçerik Ara...">
            <span class="videopress-search-icon"><i class="fas fa-search"></i></span>
        </div>
    </div>
    
    <h2 class="videopress-section-title">Tüm İçerikler</h2>
    
    <div class="videopress-posts-grid" id="videopress-posts-container">
        <?php
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'paged' => 1
        );
        
        $all_posts = new WP_Query($args);
        
        if ($all_posts->have_posts()) :
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
                                    <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/maxresdefault.jpg" 
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
                                    <img src="<?php echo $thumb_url[0]; ?>"
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
                                <img src="<?php echo $thumb_url[0]; ?>"
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
        endif;
        ?>
    </div>
    
    <!-- Sayfalama bilgisi (gizli) -->
    <div class="videopress-pagination-info" style="display:none;" 
         data-max-pages="<?php echo $all_posts->max_num_pages; ?>"
         data-current-page="1">
    </div>
    
    <!-- Yükleniyor göstergesi -->
    <div class="videopress-loading">
        <div class="videopress-loading-spinner"></div>
    </div>
    
    <!-- Karanlık Mod Toggle Düğmesi -->
    <div class="dark-mode-toggle">
        <i class="fas fa-sun"></i>
    </div>
    
    <!-- Video ve Ses Modalları -->
    <div class="videopress-modal" id="videoModal">
        <div class="videopress-modal-content">
            <span class="videopress-modal-close">&times;</span>
            <div class="videopress-modal-iframe" id="videoContainer"></div>
        </div>
    </div>
    
    <div class="videopress-modal" id="audioModal">
        <div class="videopress-modal-content">
            <span class="videopress-modal-close">&times;</span>
            <div class="videopress-modal-audio" id="audioContainer">
                <h3 id="audioTitle"></h3>
                <div class="audio-player-container">
                    <audio controls class="audio-player" id="audioPlayer">
                        <source src="" type="audio/mpeg" id="audioSource">
                        Tarayıcınız ses oynatmayı desteklemiyor.
                    </audio>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sonsuz kaydırma ve filtreleme için JavaScript -->
    <script>
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    document.addEventListener("DOMContentLoaded", function() {
        const postsContainer = document.getElementById("videopress-posts-container");
        const paginationInfo = document.querySelector(".videopress-pagination-info");
        const loading = document.querySelector(".videopress-loading");
        const endMessage = document.querySelector(".videopress-end-message");
        const filterButtons = document.querySelectorAll(".filter-button");
        const searchInput = document.querySelector(".videopress-search-input");
        const categoryTabs = document.querySelectorAll(".category-tab");
        const sectionTitle = document.querySelector(".videopress-section-title");
        
        // Karanlık modu varsayılan olarak etkinleştir
        document.body.classList.add("dark-mode");
        
        // Karanlık mod değiştirme butonu ekle
        const darkModeToggle = document.createElement("div");
        darkModeToggle.className = "dark-mode-toggle";
        darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        document.body.appendChild(darkModeToggle);
        
        // Karanlık mod değiştirme butonu için olay dinleyicisi
        darkModeToggle.addEventListener("click", function() {
            document.body.classList.toggle("dark-mode");
            if (document.body.classList.contains("dark-mode")) {
                this.innerHTML = '<i class="fas fa-moon"></i>';
                localStorage.setItem("darkMode", "enabled");
            } else {
                this.innerHTML = '<i class="fas fa-sun"></i>';
                localStorage.setItem("darkMode", "disabled");
            }
        });
        
        // Karanlık mod tercihini localStorage'dan yükle
        const savedDarkMode = localStorage.getItem("darkMode");
        if (savedDarkMode === "disabled") {
            document.body.classList.remove("dark-mode");
            darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        }
        
        let currentPage = parseInt(paginationInfo.getAttribute("data-current-page"));
        let maxPages = parseInt(paginationInfo.getAttribute("data-max-pages"));
        let isLoading = false;
        let currentFilter = "all"; // İçerik türü filtresi
        let currentCategory = "all"; // Kategori filtresi
        let searchQuery = ""; // Arama sorgusu
        
        // Kategori sekmeleri için olay dinleyiciler
        categoryTabs.forEach(tab => {
            tab.addEventListener("click", function() {
                // Aktif sekme stilini değiştir
                categoryTabs.forEach(t => t.classList.remove("active"));
                this.classList.add("active");
                
                currentCategory = this.getAttribute("data-category");
                currentPage = 1; // Sayfa numarasını sıfırla
                
                // Kategori başlığını güncelle
                if (currentCategory === "all") {
                    sectionTitle.textContent = "Tüm İçerikler";
                } else {
                    const categoryName = this.textContent;
                    sectionTitle.textContent = categoryName;
                }
                
                // İçerikleri yükle
                loadCategoryPosts(true);
            });
        });
        
        // Filtre butonları için olay dinleyiciler
        filterButtons.forEach(button => {
            button.addEventListener("click", function() {
                // Aktif buton stilini değiştir
                filterButtons.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");
                
                currentFilter = this.getAttribute("data-filter");
                currentPage = 1; // Sayfa numarasını sıfırla
                
                // İçerikleri yükle
                loadCategoryPosts(true);
            });
        });
        
        // Arama kutusu için olay dinleyici
        let searchTimeout;
        searchInput.addEventListener("input", function() {
            clearTimeout(searchTimeout);
            
            // Kullanıcı yazmayı bitirdikten 500ms sonra arama yap
            searchTimeout = setTimeout(() => {
                searchQuery = this.value.toLowerCase();
                currentPage = 1; // Sayfa numarasını sıfırla
                loadCategoryPosts(true);
            }, 500);
        });
        
        // Kategori içeriklerini yükleme işlevi
        function loadCategoryPosts(isNewFilter = false) {
            isLoading = true;
            loading.style.display = "block";
            
            // Yeni filtre ise mevcut içeriği temizle
            if (isNewFilter) {
                postsContainer.innerHTML = "";
                endMessage.style.display = "none";
            }
            
            // AJAX isteği gönder
            fetch(ajaxurl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "action=load_category_posts&page=" + currentPage +
                      "&category=" + currentCategory +
                      "&filter=" + currentFilter +
                      "&search=" + encodeURIComponent(searchQuery)
            })
            .then(response => response.json())
            .then(data => {
                loading.style.display = "none";
                
                if (data.success) {
                    // Sayfa bilgilerini güncelle
                    maxPages = data.data.max_pages;
                    
                    if (data.data.content) {
                        // Yeni içeriği ekle
                        const tempDiv = document.createElement("div");
                        tempDiv.innerHTML = data.data.content;
                        const newItems = tempDiv.querySelectorAll(".videopress-post-item");
                        
                        newItems.forEach(item => {
                            postsContainer.appendChild(item);
                        });
                        
                        // Video ve ses thumbnail'lerini ayarla
                        setupMediaThumbnails();
                        
                        // Sonuç bulunamadıysa mesaj göster
                        if (newItems.length === 0 && isNewFilter) {
                            postsContainer.innerHTML = '<div class="no-results">Bu kriterlere uygun içerik bulunamadı.</div>';
                        }
                    } else if (isNewFilter) {
                        postsContainer.innerHTML = '<div class="no-results">Bu kriterlere uygun içerik bulunamadı.</div>';
                    }
                    
                    // Son sayfa kontrolü
                    if (currentPage >= maxPages && endMessage) {
                        endMessage.style.display = "block";
                    }
                }
                
                isLoading = false;
            })
            .catch(error => {
                console.error("Hata:", error);
                loading.style.display = "none";
                isLoading = false;
            });
        }
        
        // Sayfa sonuna gelince yeni içerik yükle
        window.addEventListener("scroll", function() {
            if (isLoading) return;
            
            // Sayfanın sonuna yaklaşıldı mı kontrol et
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
                if (currentPage < maxPages) {
                    currentPage++;
                    loadCategoryPosts(false);
                }
            }
        });
        
        // Video ve Ses thumbnail'lerine tıklama olayı ekleme
        function setupMediaThumbnails() {
            // Video thumbnail'leri
            const videoThumbnails = document.querySelectorAll(".videopress-post-thumbnail.youtube-thumbnail");
            const videoModal = document.getElementById("videoModal");
            const videoContainer = document.getElementById("videoContainer");
            
            // Ses thumbnail'leri
            const audioThumbnails = document.querySelectorAll(".videopress-post-thumbnail.archive-thumbnail");
            const audioModal = document.getElementById("audioModal");
            const audioContainer = document.getElementById("audioContainer");
            const audioPlayer = document.getElementById("audioPlayer");
            const audioSource = document.getElementById("audioSource");
            const audioTitle = document.getElementById("audioTitle");
            
            // Tüm modallardaki kapatma düğmeleri
            const closeBtns = document.querySelectorAll(".videopress-modal-close");
            
            // Video thumbnaillerine tıklama
            videoThumbnails.forEach(thumbnail => {
                thumbnail.addEventListener("click", function(e) {
                    e.preventDefault();
                    
                    // YouTube ID alma işlemi
                    const link = this.querySelector("a");
                    const img = this.querySelector("img");
                    const src = img.getAttribute("src") || img.getAttribute("data-src");
                    const youtubeId = extractYoutubeId(src);
                    
                    if (youtubeId) {
                        // Modal içeriğini ayarla
                        videoContainer.innerHTML = `<iframe src="https://www.youtube.com/embed/${youtubeId}?autoplay=1" 
                                                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                  allowfullscreen></iframe>`;
                        
                        // Modalı göster
                        videoModal.style.display = "flex";
                        document.body.classList.add("modal-open");
                    } else {
                        // ID bulunamazsa normal davranışı sürdür (detay sayfasına git)
                        window.location.href = link.getAttribute("href");
                    }
                });
            });
            
            // Ses thumbnaillerine tıklama
            audioThumbnails.forEach(thumbnail => {
                thumbnail.addEventListener("click", async function(e) {
                    e.preventDefault();
                    
                    const link = this.querySelector("a");
                    const postUrl = link.getAttribute("href");
                    const title = thumbnail.closest("article").querySelector(".videopress-post-title a").textContent;
                    
                    // Detay sayfasından ses dosyasını çekme
                    try {
                        const response = await fetch(postUrl);
                        const text = await response.text();
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(text, "text/html");
                        const content = doc.querySelector(".entry-content").innerHTML;
                        
                        // Archive.org ses URL'sini çekme
                        const audioUrl = extractArchiveAudioUrl(content);
                        
                        if (audioUrl) {
                            // Ses oynatıcısını ayarla
                            audioTitle.textContent = title;
                            audioSource.src = audioUrl;
                            audioPlayer.load();
                            
                            // Modalı göster
                            audioModal.style.display = "flex";
                            document.body.classList.add("modal-open");
                            audioPlayer.play();
                        } else {
                            // URL bulunamazsa detay sayfasına git
                            window.location.href = postUrl;
                        }
                    } catch (error) {
                        console.error("Ses dosyası çekilemedi:", error);
                        window.location.href = postUrl;
                    }
                });
            });
            
            // Modal kapatma
            closeBtns.forEach(btn => {
                btn.addEventListener("click", function() {
                    closeAllModals();
                });
            });
            
            // Modal dışına tıklanınca kapatma
            document.querySelectorAll(".videopress-modal").forEach(modal => {
                modal.addEventListener("click", function(e) {
                    if (e.target === this) {
                        closeAllModals();
                    }
                });
            });
            
            // ESC tuşu ile modal kapatma
            document.addEventListener("keydown", function(e) {
                if (e.key === "Escape") {
                    closeAllModals();
                }
            });
            
            // Tüm modalları kapatma fonksiyonu
            function closeAllModals() {
                videoModal.style.display = "none";
                audioModal.style.display = "none";
                videoContainer.innerHTML = "";
                audioPlayer.pause();
                document.body.classList.remove("modal-open");
            }
            
            // YouTube ID çıkarma yardımcı fonksiyonu
            function extractYoutubeId(url) {
                if (!url) return null;
                
                const maxresPattern = /\/vi\/([^\/]+)\/maxresdefault/;
                const hqPattern = /\/vi\/([^\/]+)\/hqdefault/;
                
                let match = url.match(maxresPattern) || url.match(hqPattern);
                
                return match ? match[1] : null;
            }
            
            // Archive.org ses URL'si çıkarma yardımcı fonksiyonu
            function extractArchiveAudioUrl(content) {
                const regex = /https:\/\/archive\.org\/download\/[^\s"'<>]+\.(mp3|ogg)/i;
                const match = content.match(regex);
                return match ? match[0] : null;
            }
        }
    });
    </script>
    
    <!-- Tüm içerikler yüklendiğinde gösterilecek mesaj -->
    <div class="videopress-end-message" style="display:none; text-align:center; padding:20px; margin:20px 0;">
        <p>Tüm içerikler yüklendi.</p>
    </div>
</div>

<?php get_footer(); ?> 