<?php
// Get theme colors
global $themeColors;
?>
<!-- Process Section -->
<section id="process" class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <!-- Step 1: Book -->
            <div class="group text-center transition-transform duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    1
                </div>
                <div class="relative group">
                    <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/20 rounded-2xl border border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/30 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/60 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
                    <div class="relative z-10 p-8 h-full">
                        <i class="fas fa-calendar-check text-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] text-4xl mb-4 group-hover:scale-110 transition-transform duration-300"></i>
                        <h3 class="text-lg font-semibold mb-3 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">Book</h3>
                        <p class="text-gray-600">Schedule your cleaning service through our easy online booking system or give us a call.</p>
                    </div>
                </div>
            </div>
            <!-- Step 2: Prepare -->
            <div class="group text-center transition-transform duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    2
                </div>
                <div class="relative group">
                    <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/20 rounded-2xl border border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/30 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/60 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
                    <div class="relative z-10 p-8 h-full">
                        <i class="fas fa-clipboard-list text-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] text-4xl mb-4 group-hover:scale-110 transition-transform duration-300"></i>
                        <h3 class="text-lg font-semibold mb-3 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">Prepare</h3>
                        <p class="text-gray-600">Our team will prepare all necessary equipment and supplies for your specific needs.</p>
                    </div>
                </div>
            </div>
            <!-- Step 3: Clean -->
            <div class="group text-center transition-transform duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    3
                </div>
                <div class="relative group">
                    <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/20 rounded-2xl border border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/30 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/60 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
                    <div class="relative z-10 p-8 h-full">
                        <i class="fas fa-broom text-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] text-4xl mb-4 group-hover:scale-110 transition-transform duration-300"></i>
                        <h3 class="text-lg font-semibold mb-3 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">Clean</h3>
                        <p class="text-gray-600">Our professional cleaners will thoroughly clean your space according to your requirements.</p>
                    </div>
                </div>
            </div>
            <!-- Step 4: Review -->
            <div class="group text-center transition-transform duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    4
                </div>
                <div class="relative group">
                    <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/20 rounded-2xl border border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/30 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/60 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
                    <div class="relative z-10 p-8 h-full">
                        <i class="fas fa-check-circle text-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] text-4xl mb-4 group-hover:scale-110 transition-transform duration-300"></i>
                        <h3 class="text-lg font-semibold mb-3 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">Review</h3>
                        <p class="text-gray-600">We'll do a final inspection to ensure everything meets our high standards of cleanliness.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- What to Expect & Our Commitment -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-24">
            <div class="relative group">
                <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/20 rounded-2xl border border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/30 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/60 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
                <div class="relative z-10 p-8">
                    <h3 class="text-2xl font-semibold mb-6 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">What to Expect</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check text-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] mt-1 mr-3"></i>
                            <span class="text-gray-700">Professional and friendly cleaners</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] mt-1 mr-3"></i>
                            <span class="text-gray-700">Eco-friendly cleaning products</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] mt-1 mr-3"></i>
                            <span class="text-gray-700">Fully insured and bonded service</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] mt-1 mr-3"></i>
                            <span class="text-gray-700">Satisfaction guaranteed</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#ffffff'; ?>]/20 rounded-2xl border border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/30 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/60 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
                <div class="relative z-10 p-8 flex flex-col justify-between">
                    <div>
                        <h3 class="text-2xl font-semibold mb-6 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">Our Commitment</h3>
                        <p class="text-gray-700 mb-6">We are committed to providing exceptional cleaning services that exceed your expectations. Our team is trained to pay attention to every detail and ensure your complete satisfaction.</p>
                    </div>
                    <a href="./index.php?page=booking" class="inline-block px-8 py-3 text-white bg-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] hover:bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300 rounded-md shadow-md hover:shadow-xl text-lg font-semibold text-center mt-4">
                        Book Your Cleaning Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>