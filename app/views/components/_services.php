<?php
// Get theme colors
global $themeColors;
?>
<!-- Services Section -->
<section id="services" class="py-20 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-64 h-64" style="background-color: <?php echo ($themeColors['primary'] ?? '#f34d26') . '0D'; ?>; border-radius: 9999px; filter: blur(32px);"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64" style="background-color: <?php echo ($themeColors['secondary'] ?? '#00bda4') . '0D'; ?>; border-radius: 9999px; filter: blur(32px);"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 animate-fadeInUp" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">
                Our Services
            </h2>
            <p class="text-xl max-w-2xl mx-auto animate-fadeInUp-delayed" style="color: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;">
                Professional cleaning solutions tailored to your needs
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($services as $index => $service): ?>
                <div class="group relative flex flex-col h-full overflow-hidden rounded-2xl transform transition-all duration-500 hover:-translate-y-2 animate-fadeInUp" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <!-- Card Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-white/80 to-white/40 rounded-2xl border border-white/30 group-hover:border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/30 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>

                    <!-- Card Content -->
                    <div class="relative z-10 flex flex-col h-full p-6">
                        <!-- Icon -->
                        <div class="flex justify-center items-center h-32 mb-6">
                            <?php
                            $icon = 'fa-broom'; // default
                            $name = strtolower($service['name']);
                            if (strpos($name, 'regular') !== false) $icon = 'fa-home';
                            elseif (strpos($name, 'deep') !== false) $icon = 'fa-soap';
                            elseif (strpos($name, 'move') !== false) $icon = 'fa-truck-moving';
                            elseif (strpos($name, 'office') !== false) $icon = 'fa-building';
                            elseif (strpos($name, 'carpet') !== false) $icon = 'fa-rug';
                            elseif (strpos($name, 'vacuum') !== false) $icon = 'fa-wind';
                            elseif (strpos($name, 'tenancy') !== false) $icon = 'fa-key';
                            ?>
                            <div class="w-24 h-24 rounded-full flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300" style="background: linear-gradient(135deg, <?php echo ($themeColors['primary'] ?? '#f34d26') . '33'; ?> 0%, <?php echo ($themeColors['secondary'] ?? '#00bda4') . '33'; ?> 100%);">
                                <i class="fas <?php echo $icon; ?> text-4xl transition-transform duration-300" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;"></i>
                            </div>
                        </div>

                        <!-- Service Details -->
                        <div class="flex flex-col flex-grow">
                            <h4 class="text-2xl font-bold mb-3 group-hover:text-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] transition-colors duration-300" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">
                                <?php echo $service['name']; ?>
                            </h4>
                            <p class="text-gray-700 mb-6 flex-grow">
                                <?php echo $service['description']; ?>
                            </p>

                            <!-- Service Info -->
                            <div class="bg-white/50 rounded-lg p-4 mb-6 backdrop-blur-sm">
                                <ul class="space-y-2">
                                    <li class="flex items-center gap-2 text-gray-700">
                                        <i class="fas fa-clock" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;"></i>
                                        <span class="font-medium"><?php echo $service['duration_minutes']; ?> minutes</span>
                                    </li>
                                    <li class="flex items-center gap-2 text-gray-700">
                                        <i class="fas fa-tag" style="color: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;"></i>
                                        <span class="font-medium">$<?php echo number_format($service['base_price'], 2); ?></span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Book Now Button -->
                            <a href="./index.php?page=booking&service=<?php echo $service['id']; ?>"
                                class="group/btn relative overflow-hidden rounded-lg p-[2px] transition-all duration-300 hover:shadow-lg"
                                style="background: linear-gradient(90deg, <?php echo $themeColors['primary'] ?? '#f34d26'; ?> 0%, <?php echo $themeColors['secondary'] ?? '#00bda4'; ?> 100%);">
                                <div class="relative bg-white rounded-lg px-6 py-3 transition-all duration-300 group-hover/btn:bg-transparent">
                                    <span class="relative z-10 font-semibold transition-colors duration-300" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">
                                        Book Now
                                        <i class="fas fa-arrow-right ml-2 transform group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
    }

    .animate-fadeInUp-delayed {
        animation: fadeInUp 0.6s ease-out 0.3s forwards;
        opacity: 0;
    }
</style>