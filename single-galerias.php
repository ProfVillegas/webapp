<?php get_header(); ?>

<main id="primary" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php
                    // Obtener el contenido y extraer las galerías
                    $content = get_the_content();

                    print_r($content);
                    // Buscar bloques de galería en el contenido (nueva estructura de Gutenberg)
                    preg_match_all('/<figure class="wp-block-gallery[^>]*>.*?<\/figure>/s', $content, $gallery_matches);

                    if (!empty($gallery_matches[0])) {
                        // Mostrar el slider personalizado para la galería
                        echo '<div class="custom-gallery-slider">';

                        // Extraer imágenes de la galería (nueva estructura)
                        // Modificación aquí: buscar dentro de cada galería individualmente
                        preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>/', $content, $image_matches);
                        preg_match_all('/<img[^>]+alt=["\']([^"\']*)["\'][^>]*>/', $content, $alt_matches);

                        $images = array();
                        // Asegúrate de que ambos arrays tengan la misma cantidad de elementos
                        $num_images = min(count($image_matches[1]), count($alt_matches[1]));

                        for ($i = 0; $i < $num_images; $i++) {
                            $images[] = array(
                                'src' => $image_matches[1][$i],
                                'alt' => $alt_matches[1][$i]
                            );
                        }
                        
                        if (!empty($images)) {
                            // Construir el HTML del slider
                    ?>
                            <div class="gallery-slider-container">
                                <!-- Sección superior: imagen principal e información -->
                                <div class="gallery-main">
                                    <div class="main-image-container">
                                        <?php foreach ($images as $index => $image) : ?>
                                            <div class="image-wrapper">
                                                <img src="<?php echo esc_url($image['src']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="active" data-index="0">
                                                <div class="image-info">
                                                    <!--  Caption aquí si es necesario -->
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- Controles de navegación -->
                                    <button class="slider-nav prev" aria-label="Imagen anterior">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                    <button class="slider-nav next" aria-label="Siguiente imagen">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Sección inferior: thumbnails -->
                                <div class="gallery-thumbnails">
                                    <?php foreach ($images as $index => $image) : ?>
                                        <div class="thumbnail-item <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                                            <img src="<?php echo esc_url($image['src']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                    <?php
                        }

                        echo '</div>';

                        echo "// Mostrar el resto del contenido sin la galería";

                        // Si no hay galería, mostrar el contenido normal
                        // Eliminar la etiqueta <figure class="wp-block-gallery ..."> y su contenido
                        $content_without_gallery = preg_replace('/<figure class="wp-block-gallery[^>]*>.*?<\/figure>/s', '', $content);
                        echo $content_without_gallery;
                    } else {
                        echo "// Si no hay galería, mostrar el contenido normal";
                        the_content();
                    }
                    ?>
                </div>
            </article>
    <?php endwhile;
    endif;
    ?>
</main>

<style>
    /* Estilos para el slider personalizado */
    .gallery-slider-container {
        max-width: 100%;
        margin: 2rem auto;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .gallery-main {
        position: relative;
        background: #000;
        aspect-ratio: 16/9;
    }

    .main-image-container {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .main-image-container img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: none;
        transition: opacity 0.5s ease;
        cursor: pointer;
    }

    .main-image-container img.active {
        display: block;
    }

    .image-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: #fff;
        padding: 2rem 1rem 1rem;
        transition: opacity 0.3s ease;
    }

    .image-caption {
        text-align: center;
        font-size: 1.1rem;
    }

    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.3s ease;
        z-index: 10;
    }

    .slider-nav:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .slider-nav.prev {
        left: 15px;
    }

    .slider-nav.next {
        right: 15px;
    }

    .slider-nav svg {
        width: 24px;
        height: 24px;
    }

    .gallery-thumbnails {
        display: flex;
        overflow-x: auto;
        padding: 10px;
        background: #f5f5f5;
        scrollbar-width: thin;
        -ms-overflow-style: none;
    }

    .gallery-thumbnails::-webkit-scrollbar {
        height: 6px;
    }

    .gallery-thumbnails::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }

    .thumbnail-item {
        flex: 0 0 auto;
        width: 80px;
        height: 60px;
        margin-right: 8px;
        cursor: pointer;
        border: 3px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        transition: border-color 0.3s ease;
    }

    .thumbnail-item.active {
        border-color: #0073aa;
    }

    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Estilos para lightbox */
    .lightbox-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
    }

    .lightbox-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .lightbox-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
    }

    .lightbox-content img {
        max-width: 90vw;
        max-height: 90vh;
        width: auto;
        height: auto;
        margin: auto;
    }

    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        color: white;
        background: none;
        border: none;
        font-size: 2rem;
        cursor: pointer;
    }

    .lightbox-caption {
        color: white;
        text-align: center;
        margin-top: 1rem;
        max-width: 80vw;
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
    }

    .lightbox-prev {
        left: 15px;
    }

    .lightbox-next {
        right: 15px;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .slider-nav,
        .lightbox-nav {
            width: 40px;
            height: 40px;
        }

        .thumbnail-item {
            width: 60px;
            height: 45px;
        }

        .image-info {
            padding: 1rem 0.5rem 0.5rem;
        }

        .image-caption {
            font-size: 0.9rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración del slider
        const gallerySlider = document.querySelector('.gallery-slider-container');
        if (!gallerySlider) return;

        const mainImages = gallerySlider.querySelectorAll('.main-image-container img');
        const thumbnails = gallerySlider.querySelectorAll('.thumbnail-item');
        const prevButton = gallerySlider.querySelector('.slider-nav.prev');
        const nextButton = gallerySlider.querySelector('.slider-nav.next');

        // Obtener los textos de los captions
        const imageCaptions = Array.from(mainImages).map(img => {
            const captionElement = img.parentNode.querySelector('.image-caption');
            return captionElement ? captionElement.textContent : '';
        });

        let currentIndex = 0;
        let autoPlayInterval;

        // Función para mostrar una imagen específica
        function showImage(index) {
            // Ocultar todas las imágenes
            mainImages.forEach(img => img.classList.remove('active'));
            thumbnails.forEach(thumb => thumb.classList.remove('active'));

            // Mostrar la imagen seleccionada
            mainImages[index].classList.add('active');
            thumbnails[index].classList.add('active');

            // Actualizar el caption
            const captionElement = gallerySlider.querySelector('.image-caption');
            if (captionElement) {
                captionElement.textContent = imageCaptions[index];
            }

            currentIndex = index;
        }

        // Navegación con botones
        prevButton.addEventListener('click', function() {
            let newIndex = currentIndex - 1;
            if (newIndex < 0) newIndex = mainImages.length - 1;
            showImage(newIndex);
            resetAutoPlay();
        });

        nextButton.addEventListener('click', function() {
            let newIndex = currentIndex + 1;
            if (newIndex >= mainImages.length) newIndex = 0;
            showImage(newIndex);
            resetAutoPlay();
        });

        // Navegación con thumbnails
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                showImage(index);
                resetAutoPlay();
            });
        });

        // Navegación con teclado
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                prevButton.click();
            } else if (e.key === 'ArrowRight') {
                nextButton.click();
            } else if (e.key === 'Escape') {
                closeLightbox();
            }
        });

        // Lightbox al hacer clic en la imagen principal
        mainImages.forEach(img => {
            img.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                openLightbox(index);
            });
        });

        // Función para abrir lightbox
        function openLightbox(index) {
            // Crear overlay de lightbox si no existe
            let lightbox = document.querySelector('.lightbox-overlay');
            if (!lightbox) {
                lightbox = document.createElement('div');
                lightbox.className = 'lightbox-overlay';

                const lightboxContent = document.createElement('div');
                lightboxContent.className = 'lightbox-content';

                const closeButton = document.createElement('button');
                closeButton.className = 'lightbox-close';
                closeButton.innerHTML = '&times;';
                closeButton.addEventListener('click', closeLightbox);

                const caption = document.createElement('div');
                caption.className = 'lightbox-caption';

                // Botones de navegación para el lightbox
                const prevBtn = document.createElement('button');
                prevBtn.className = 'lightbox-nav lightbox-prev';
                prevBtn.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                prevBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    let newIndex = currentIndex - 1;
                    if (newIndex < 0) newIndex = mainImages.length - 1;
                    updateLightboxImage(newIndex);
                });

                const nextBtn = document.createElement('button');
                nextBtn.className = 'lightbox-nav lightbox-next';
                nextBtn.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                nextBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    let newIndex = currentIndex + 1;
                    if (newIndex >= mainImages.length) newIndex = 0;
                    updateLightboxImage(newIndex);
                });

                lightboxContent.appendChild(prevBtn);
                lightboxContent.appendChild(nextBtn);
                lightboxContent.appendChild(closeButton);
                lightboxContent.appendChild(caption);
                lightbox.appendChild(lightboxContent);

                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox) {
                        closeLightbox();
                    }
                });

                document.body.appendChild(lightbox);
            }

            // Actualizar lightbox con la imagen seleccionada
            updateLightboxImage(index);

            // Mostrar lightbox
            lightbox.classList.add('active');

            // Prevenir scroll del body
            document.body.style.overflow = 'hidden';
        }

        // Función para actualizar la imagen en el lightbox
        function updateLightboxImage(index) {
            const lightbox = document.querySelector('.lightbox-overlay');
            if (!lightbox) return;

            let lightboxImg = lightbox.querySelector('img');
            if (!lightboxImg) {
                lightboxImg = document.createElement('img');
                lightbox.querySelector('.lightbox-content').insertBefore(lightboxImg, lightbox.querySelector('.lightbox-caption'));
            }

            lightboxImg.src = mainImages[index].src;
            lightboxImg.alt = mainImages[index].alt;

            const caption = lightbox.querySelector('.lightbox-caption');
            caption.textContent = imageCaptions[index];

            currentIndex = index;
        }

        // Función para cerrar lightbox
        function closeLightbox() {
            const lightbox = document.querySelector('.lightbox-overlay');
            if (lightbox) {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        // Auto-play cada 5 segundos
        function startAutoPlay() {
            autoPlayInterval = setInterval(() => {
                let newIndex = currentIndex + 1;
                if (newIndex >= mainImages.length) newIndex = 0;
                showImage(newIndex);
            }, 5000);
        }

        function resetAutoPlay() {
            clearInterval(autoPlayInterval);
            startAutoPlay();
        }

        // Pausar auto-play al interactuar
        gallerySlider.addEventListener('mouseenter', () => {
            clearInterval(autoPlayInterval);
        });

        gallerySlider.addEventListener('mouseleave', () => {
            startAutoPlay();
        });

        // Iniciar auto-play
        startAutoPlay();
    });
</script>

<?php get_footer(); ?>