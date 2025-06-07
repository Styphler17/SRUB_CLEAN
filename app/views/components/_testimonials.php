<?php
// Get theme colors
global $themeColors;
?>
<main class="container mx-auto px-4 flex flex-col lg:flex-row items-center lg:items-start relative">
    <!-- Testimonials Carousel (SwiperJS) -->
    <div id="testimonials" class="py-16 flex-1 w-full lg:w-2/3">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="mb-16 text-center">
                <!-- Decorative elements -->
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-1 bg-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] rounded-full"></div>
                </div>
                <!-- Title and subtitle -->
                <h2 class="text-4xl font-bold mb-4 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">What Our Clients Say</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Real feedback from our valued clients who trust us with their cleaning needs</p>
            </div>
            <!-- Swiper Carousel -->
            <div class="swiper testimonials-swiper">
                <div class="swiper-wrapper">
                    <?php
                    // Use either $testimonials or $reviews, whichever is available
                    $items = isset($testimonials) ? $testimonials : (isset($reviews) ? $reviews : []);
                    foreach ($items as $item):
                    ?>
                        <div class="swiper-slide">
                            <!-- Testimonial Card -->
                            <div class="relative group h-full flex flex-col items-center">
                                <!-- Quote icon -->
                                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-quote-left text-white text-xl"></i>
                                </div>
                                <!-- Glassmorphism background -->
                                <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/80 to-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/40 rounded-3xl border-2 border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/20 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/40 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
                                <div class="relative z-10 p-8 pt-12 flex flex-col h-full w-full max-w-md mx-auto">
                                    <!-- Star Rating -->
                                    <div class="flex items-center justify-center mb-6">
                                        <?php for ($i = 0; $i < 5; $i++):
                                            $starClass = 'fas fa-star mx-0.5 text-xl ';
                                            if ($i < $item['rating']) {
                                                $starClass .= 'text-[' . ($themeColors['secondary'] ?? '#00bda4') . ']';
                                            } else {
                                                $starClass .= 'text-gray-300';
                                            }
                                        ?>
                                            <i class="<?php echo $starClass; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <!-- Testimonial Comment -->
                                    <p class="text-gray-700 mb-6 flex-1 text-center text-lg italic leading-relaxed">"<?php echo $item['comment']; ?>"</p>
                                    <!-- Reviewer Name and Date -->
                                    <div class="flex flex-col items-center mt-4">
                                        <div class="w-16 h-16 rounded-full bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/10 flex items-center justify-center mb-4">
                                            <i class="fas fa-user text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-2xl"></i>
                                        </div>
                                        <h6 class="font-semibold text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-lg"><?php echo !empty($item['name']) ? $item['name'] : 'Anonymous'; ?></h6>
                                        <small class="text-gray-500 mt-1"><?php echo date('F Y', strtotime($item['created_at'])); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Swiper Navigation -->
                <div class="swiper-button-next text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]"></div>
                <div class="swiper-button-prev text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]"></div>
                <!-- Swiper Pagination -->
                <div class="swiper-pagination mt-8"></div>
            </div>
        </div>
    </div>
    <!-- Review Form Aside (fixed/sticky on desktop, stacked on mobile) -->
    <aside class="w-full lg:w-1/3 lg:sticky lg:top-24 flex-shrink-0 z-20">
        <?php require_once __DIR__ . '/_review-form.php'; ?>
    </aside>
</main>

<!-- SwiperJS CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Initialize Swiper carousel for testimonials
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.testimonials-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            slidesPerView: 1,
            spaceBetween: 32,
            breakpoints: {
                768: {
                    slidesPerView: 1,
                },
                1024: {
                    slidesPerView: 1,
                }
            }
        });
    });
</script>