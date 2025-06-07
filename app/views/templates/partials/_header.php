<?php
// Get theme colors
global $themeColors;
// Use global $contactInfo if available
if (!isset($contactInfo)) {
    $contactInfo = [];
}
$phoneNumbers = [];
if (!empty($contactInfo['phone_numbers'])) {
    $phoneNumbers = is_array($contactInfo['phone_numbers']) ? $contactInfo['phone_numbers'] : json_decode($contactInfo['phone_numbers'], true);
}
$callNumber = $phoneNumbers[0] ?? null;
$currentPage = $_SERVER['REQUEST_URI'];

// Pre-compute active classes
$primaryColor = $themeColors['primary'] ?? '#f34d26';
$secondaryColor = $themeColors['secondary'] ?? '#00bda4';

$activeClass = 'text-[' . $primaryColor . '] underline underline-offset-8 decoration-2';
$activeMobileClass = 'text-[' . $primaryColor . '] bg-gray-100';

$activeHome = ($currentPage === '/home') ? $activeClass : '';
$activeServices = ($currentPage === '/services') ? $activeClass : '';
$activeProcess = ($currentPage === '/process') ? $activeClass : '';
$activeTestimonials = ($currentPage === '/testimonials') ? $activeClass : '';
$activeContact = ($currentPage === '/contact') ? $activeClass : '';

$activeHomeMobile = ($currentPage === '/home') ? $activeMobileClass : '';
$activeServicesMobile = ($currentPage === '/services') ? $activeMobileClass : '';
$activeProcessMobile = ($currentPage === '/process') ? $activeMobileClass : '';
$activeTestimonialsMobile = ($currentPage === '/testimonials') ? $activeMobileClass : '';
$activeContactMobile = ($currentPage === '/contact') ? $activeMobileClass : '';
?>
<!-- Header -->
<header class="fixed top-0 left-0 right-0 bg-white/90 shadow-lg border-b border-gray-200 backdrop-blur-md z-50 transition-all duration-300" id="mainHeader">
    <nav class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <!-- Logo Left -->
            <a class="flex-shrink-0 group" href="/home">
                <img src="/assets/images/logo/cleanesta-services-logo.png"
                    alt="Cleanesta Cleaning Logo" class="h-24 transition-transform duration-300 group-hover:scale-105">
            </a>

            <!-- Center Nav Links -->
            <div class="hidden lg:flex flex-1 justify-center items-center space-x-6 xl:space-x-10 font-medium text-base" id="mainNav">
                <a class="text-gray-800 px-2 py-1 rounded transition-all duration-200 hover:text-[<?php echo $primaryColor; ?>] hover:underline underline-offset-8 decoration-2 <?php echo $activeHome; ?>" href="/home">Home</a>
                <a class="text-gray-800 px-2 py-1 rounded transition-all duration-200 hover:text-[<?php echo $primaryColor; ?>] hover:underline underline-offset-8 decoration-2 <?php echo $activeServices; ?>" href="/services">Services</a>
                <a class="text-gray-800 px-2 py-1 rounded transition-all duration-200 hover:text-[<?php echo $primaryColor; ?>] hover:underline underline-offset-8 decoration-2 <?php echo $activeProcess; ?>" href="/process">Process</a>
                <a class="text-gray-800 px-2 py-1 rounded transition-all duration-200 hover:text-[<?php echo $primaryColor; ?>] hover:underline underline-offset-8 decoration-2 <?php echo $activeTestimonials; ?>" href="/testimonials">Testimonials</a>
                <a class="text-gray-800 px-2 py-1 rounded transition-all duration-200 hover:text-[<?php echo $primaryColor; ?>] hover:underline underline-offset-8 decoration-2 <?php echo $activeContact; ?>" href="/contact">Contact</a>
            </div>

            <!-- Right Buttons -->
            <div class="hidden lg:flex items-center space-x-2">
                <a class="inline-block px-8 py-3 rounded-full font-semibold shadow bg-[<?php echo $primaryColor; ?>] text-white hover:bg-[<?php echo $secondaryColor; ?>] hover:scale-105 hover:brightness-110 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[<?php echo $secondaryColor; ?>] focus:ring-offset-2" id="bookNowBtn" href="/booking">
                    Book Now
                </a>
                <?php if ($callNumber): ?>
                    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $callNumber); ?>" class="inline-block px-6 py-3 rounded-full font-semibold shadow bg-[<?php echo $secondaryColor; ?>] text-white hover:bg-[<?php echo $primaryColor; ?>] hover:scale-105 hover:brightness-110 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[<?php echo $primaryColor; ?>] focus:ring-offset-2" id="callNowBtn">
                        <i class="fas fa-phone-alt mr-2"></i>Call Now
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button class="lg:hidden p-2 rounded-full border border-gray-200 bg-white shadow hover:bg-[<?php echo $primaryColor; ?>] hover:text-white focus:outline-none transition-all duration-300" type="button" id="mobileMenuButton" aria-label="Toggle navigation">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden lg:hidden absolute left-0 right-0 mt-2 bg-white shadow-lg rounded-b-xl border-t border-gray-200" id="mobileMenu">
            <div class="px-4 pt-4 pb-6 space-y-2">
                <a class="block px-3 py-2 rounded text-gray-800 hover:text-[<?php echo $primaryColor; ?>] hover:bg-gray-100 font-medium transition-all duration-200 <?php echo $activeHomeMobile; ?>" href="/home">Home</a>
                <a class="block px-3 py-2 rounded text-gray-800 hover:text-[<?php echo $primaryColor; ?>] hover:bg-gray-100 font-medium transition-all duration-200 <?php echo $activeServicesMobile; ?>" href="/services">Services</a>
                <a class="block px-3 py-2 rounded text-gray-800 hover:text-[<?php echo $primaryColor; ?>] hover:bg-gray-100 font-medium transition-all duration-200 <?php echo $activeProcessMobile; ?>" href="/process">Process</a>
                <a class="block px-3 py-2 rounded text-gray-800 hover:text-[<?php echo $primaryColor; ?>] hover:bg-gray-100 font-medium transition-all duration-200 <?php echo $activeTestimonialsMobile; ?>" href="/testimonials">Testimonials</a>
                <a class="block px-3 py-2 rounded text-gray-800 hover:text-[<?php echo $primaryColor; ?>] hover:bg-gray-100 font-medium transition-all duration-200 <?php echo $activeContactMobile; ?>" href="/contact">Contact</a>
                <a class="block w-full text-center px-6 py-3 mt-2 rounded-full font-semibold shadow bg-[<?php echo $primaryColor; ?>] text-white hover:bg-[<?php echo $secondaryColor; ?>] hover:scale-105 hover:brightness-110 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[<?php echo $secondaryColor; ?>] focus:ring-offset-2" id="bookNowBtnMobile" href="/booking">
                    Book Now
                </a>
                <?php if ($callNumber): ?>
                    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $callNumber); ?>" class="block w-full text-center px-6 py-3 mt-2 rounded-full font-semibold shadow bg-[<?php echo $secondaryColor; ?>] text-white hover:bg-[<?php echo $primaryColor; ?>] hover:scale-105 hover:brightness-110 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[<?php echo $primaryColor; ?>] focus:ring-offset-2" id="callNowBtnMobile">
                        <i class="fas fa-phone-alt mr-2"></i>Call Now
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<!-- Add margin to prevent content from hiding under fixed header -->
<div class="h-20"></div>

<!-- Overlay for blurring the page background when mobile menu is open -->
<div id="mobileMenuOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40"></div>

