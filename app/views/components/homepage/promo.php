<?php
// Get settings for theme colors
global $connexion;
?>

<!-- Promo Section -->
<section class="py-16 bg-gradient-to-r from-[var(--color-primary)]/10 to-[var(--color-secondary)]/10">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Quality Service -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-12 h-12 bg-[var(--color-primary)]/10 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-star text-[var(--color-primary)] text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Quality Service</h3>
                <p class="text-gray-600">We pride ourselves on delivering exceptional cleaning services that exceed expectations.</p>
            </div>

            <!-- Experienced Team -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-12 h-12 bg-[var(--color-secondary)]/10 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-users text-[var(--color-secondary)] text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Experienced Team</h3>
                <p class="text-gray-600">Our professional cleaners are trained and experienced in all types of cleaning services.</p>
            </div>

            <!-- Satisfaction Guaranteed -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-12 h-12 bg-[var(--color-accent)]/10 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-check-circle text-[var(--color-accent)] text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Satisfaction Guaranteed</h3>
                <p class="text-gray-600">Your satisfaction is our priority. We're not happy until you're happy with our service.</p>
            </div>
        </div>
    </div>
</section>