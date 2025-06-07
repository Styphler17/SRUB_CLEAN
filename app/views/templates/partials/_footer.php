<?php
global $themeColors, $connexion;
// Fetch settings and contact info from the database
if ($connexion) {
    // Settings
    $settings = $connexion->query("SELECT setting_key, setting_value FROM settings")->fetchAll(PDO::FETCH_KEY_PAIR);
    // Contact Info
    $contact = $connexion->query("SELECT * FROM contact_info LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    // Business Hours
    $hours = $connexion->query("SELECT * FROM business_hours ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
} else {
    $settings = [];
    $contact = [];
    $hours = [];
}

?>
<!-- Footer -->
<footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-gray-300 pt-12 pb-8 mt-auto">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Brand Info -->
            <div class="space-y-4">
                <img src="/assets/images/logo/cleanesta-services-logo.png"
                    alt="Cleanesta Cleaning Logo" class="h-32">
                <p class="text-gray-400 text-sm">
                    <?php echo $settings['cleanesta-description'] ?? 'Bringing sparkle to your space. Trusted by hundreds for spotless home and office cleaning services.'; ?>
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h6 class="text-white font-bold uppercase mb-4">Quick Links</h6>
                <ul class="space-y-2 text-sm">
                    <li><a href="/home" class="text-gray-400 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300 hover:pl-2 block">Home</a></li>
                    <li><a href="/services" class="text-gray-400 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300 hover:pl-2 block">Services</a></li>
                    <li><a href="/about" class="text-gray-400 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300 hover:pl-2 block">About</a></li>
                    <li><a href="/process" class="text-gray-400 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300 hover:pl-2 block">Process</a></li>
                    <li><a href="/testimonials" class="text-gray-400 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300 hover:pl-2 block">Testimonials</a></li>
                    <li><a href="/contact" class="text-gray-400 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300 hover:pl-2 block">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h6 class="text-white font-bold uppercase mb-4">Contact</h6>
                <ul class="space-y-3 text-sm text-gray-400">
                    <?php if (!empty($contact['phone_numbers'])): ?>
                        <?php foreach (json_decode($contact['phone_numbers'], true) ?? [] as $phone): ?>
                            <li class="flex items-center">
                                <i class="fas fa-phone mr-3 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]"></i>
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300"><?php echo $phone; ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!empty($contact['email'])): ?>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]"></i>
                            <a href="mailto:<?php echo $contact['email']; ?>" class="hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300"><?php echo $contact['email']; ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($contact['whatsapp_link'])): ?>
                        <li class="flex items-center">
                            <i class="fab fa-whatsapp mr-3 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]"></i>
                            <a href="<?php echo $contact['whatsapp_link']; ?>" target="_blank" class="hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300">
                                <?php echo preg_replace('/^https:\/\/wa\.me\//', '+', $contact['whatsapp_link']); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Business Hours -->
            <div>
                <h6 class="text-white font-bold uppercase mb-4">Business Hours</h6>
                <ul class="space-y-2 text-sm">
                    <?php if (!empty($hours)): ?>
                        <?php
                        $dayColors = [
                            'Monday' => $themeColors['primary'] ?? '#f34d26',
                            'Tuesday' => $themeColors['secondary'] ?? '#00bda4',
                            'Wednesday' => $themeColors['accent'] ?? '#7d2ea8',
                            'Thursday' => $themeColors['primary'] ?? '#f34d26',
                            'Friday' => $themeColors['secondary'] ?? '#00bda4',
                            'Saturday' => $themeColors['accent'] ?? '#7d2ea8',
                            'Sunday' => $themeColors['primary'] ?? '#f34d26'
                        ];
                        foreach ($hours as $hour):
                            $bgColor = $dayColors[$hour['day']] ?? $themeColors['primary'] ?? '#f34d26';
                        ?>
                            <li class="rounded-lg overflow-hidden">
                                <div class="flex items-center justify-between px-3 py-2" style="background-color: <?php echo $bgColor; ?>20;">
                                    <span class="font-medium text-white"><?php echo $hour['day']; ?></span>
                                    <?php if ($hour['is_closed']): ?>
                                        <span class="text-red-400 font-semibold">Closed</span>
                                    <?php else: ?>
                                        <span class="text-white"><?php echo date('g:i A', strtotime($hour['open_time'])) . ' - ' . date('g:i A', strtotime($hour['close_time'])); ?></span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="rounded-lg overflow-hidden">
                            <div class="flex items-center justify-between px-3 py-2" style="background-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>20;">
                                <span class="font-medium text-white">Not available</span>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <hr class="border-gray-700 my-8">

        <!-- Bottom -->
        <div class="flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-400 mb-4 md:mb-0">&copy; <?php echo date('Y'); ?> Cleanesta Cleaning. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="/privacy" class="text-sm text-gray-400 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300">Privacy Policy</a>
                <a href="/terms" class="text-sm text-gray-400 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] transition-colors duration-300">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop" class="hidden fixed bottom-8 right-8 z-50 bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white p-3 rounded-full shadow-lg hover:bg-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] transition-colors duration-300" aria-label="Back to top">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>

<!-- JS: Back to Top Button and Animations -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('backToTop');

        if (backToTopButton) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopButton.classList.remove('hidden');
                    backToTopButton.classList.add('block');
                } else {
                    backToTopButton.classList.add('hidden');
                    backToTopButton.classList.remove('block');
                }
            });

            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>