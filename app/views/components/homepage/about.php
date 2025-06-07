<?php
// Get theme colors
global $themeColors;
// $primary = $themeColors['primary'] ?? '#f34d26';
// $secondary = $themeColors['secondary'] ?? '#00bda4';
// $accent = $themeColors['accent'] ?? '#7d2ea8';
// $neutral = $themeColors['neutral'] ?? '#ffffff';
// $dark = $themeColors['dark'] ?? '#1f1f1f';
?>
<!-- About Section -->
<section id="about" class="py-20 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-1/4 w-64 h-64" style="background-color: <?php echo ($themeColors['primary'] ?? '#f34d26') . '0D'; ?>; border-radius: 9999px; filter: blur(32px);"></div>
        <div class="absolute bottom-0 left-1/4 w-64 h-64" style="background-color: <?php echo ($themeColors['secondary'] ?? '#00bda4') . '0D'; ?>; border-radius: 9999px; filter: blur(32px);"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <!-- Image -->
            <div class="lg:w-5/12 w-full relative group">
                <div class="absolute -inset-4 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-500" style="background: linear-gradient(135deg, <?php echo ($themeColors['primary'] ?? '#f34d26') . '33'; ?> 0%, <?php echo ($themeColors['secondary'] ?? '#00bda4') . '33'; ?> 100%);"></div>
                <img src="/assets/images/about/team.png" alt="Our Cleaning Team"
                    class="w-full rounded-2xl shadow-2xl relative z-10 transform transition-all duration-500 group-hover:scale-[1.02]">
                <!-- Decorative elements -->
                <div class="absolute -bottom-4 -right-4 w-24 h-24 rounded-full blur-xl" style="background-color: <?php echo ($themeColors['primary'] ?? '#f34d26') . '33'; ?>;"></div>
                <div class="absolute -top-4 -left-4 w-24 h-24 rounded-full blur-xl" style="background-color: <?php echo ($themeColors['secondary'] ?? '#00bda4') . '33'; ?>;"></div>
            </div>

            <!-- Content -->
            <div class="lg:w-7/12 w-full">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 animate-fadeInUp" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">
                    About Cleanesta Cleaning
                </h2>
                <p class="text-xl mb-8 animate-fadeInUp-delayed" style="color: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;">
                    I am a dedicated and experienced cleaner committed to delivering spotless results in every home and office I touch.
                </p>

                <!-- Highlights -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                    <div class="flex items-start group animate-fadeInUp" style="animation-delay: 0.2s">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 group-hover:bg-opacity-20 transition-colors duration-300" style="background-color: <?php echo ($themeColors['primary'] ?? '#f34d26') . '1A'; ?>;">
                            <i class="fas fa-check-circle" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;"></i>
                        </div>
                        <span class="text-gray-700 text-lg">Professional and experienced</span>
                    </div>
                    <div class="flex items-start group animate-fadeInUp" style="animation-delay: 0.3s">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 group-hover:bg-opacity-20 transition-colors duration-300" style="background-color: <?php echo ($themeColors['primary'] ?? '#f34d26') . '1A'; ?>;">
                            <i class="fas fa-leaf" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;"></i>
                        </div>
                        <span class="text-gray-700 text-lg">Eco-friendly cleaning products</span>
                    </div>
                    <div class="flex items-start group animate-fadeInUp" style="animation-delay: 0.4s">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 group-hover:bg-opacity-20 transition-colors duration-300" style="background-color: <?php echo ($themeColors['primary'] ?? '#f34d26') . '1A'; ?>;">
                            <i class="fas fa-shield-alt" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;"></i>
                        </div>
                        <span class="text-gray-700 text-lg">Fully insured and bonded</span>
                    </div>
                    <div class="flex items-start group animate-fadeInUp" style="animation-delay: 0.5s">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 group-hover:bg-opacity-20 transition-colors duration-300" style="background-color: <?php echo ($themeColors['primary'] ?? '#f34d26') . '1A'; ?>;">
                            <i class="fas fa-star" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;"></i>
                        </div>
                        <span class="text-gray-700 text-lg">Satisfaction guaranteed</span>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mb-8">
                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-4 text-center transform transition-all duration-300 hover:-translate-y-1 animate-fadeInUp" style="animation-delay: 0.6s">
                        <h3 class="text-3xl font-bold mb-2" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">1+</h3>
                        <p class="text-gray-600">Years Experience</p>
                    </div>
                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-4 text-center transform transition-all duration-300 hover:-translate-y-1 animate-fadeInUp" style="animation-delay: 0.7s">
                        <h3 class="text-3xl font-bold mb-2" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">50+</h3>
                        <p class="text-gray-600">Happy Clients</p>
                    </div>
                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-4 text-center transform transition-all duration-300 hover:-translate-y-1 animate-fadeInUp" style="animation-delay: 0.8s">
                        <h3 class="text-3xl font-bold mb-2" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">100+</h3>
                        <p class="text-gray-600">Cleanings Done</p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="animate-fadeInUp" style="animation-delay: 0.9s">
                    <a href="/contact"
                        class="group/btn relative overflow-hidden rounded-lg p-[2px] transition-all duration-300 hover:shadow-lg inline-block"
                        style="background: linear-gradient(90deg, <?php echo $themeColors['primary'] ?? '#f34d26'; ?> 0%, <?php echo $themeColors['secondary'] ?? '#00bda4'; ?> 100%);">
                        <div class="relative bg-white rounded-lg px-8 py-4 transition-all duration-300 group-hover/btn:bg-transparent">
                            <span class="relative z-10 font-semibold transition-colors duration-300 text-lg" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">
                                Get a Free Quote
                                <i class="fas fa-arrow-right ml-2 transform group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .animate-fadeInUp-delayed {
        animation: fadeInUp 0.6s ease-out 0.3s forwards;
        opacity: 0;
    }
</style>