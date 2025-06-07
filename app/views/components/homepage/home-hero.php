<?php
// Get settings for description
global $connexion;
?>

<!-- Hero Section -->
<section class="relative py-20 overflow-hidden bg-gradient-to-br from-[var(--color-neutral)] via-gray-50 to-[var(--color-secondary)]/10">
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-[var(--color-primary)]/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 bg-[var(--color-secondary)]/20 rounded-full blur-3xl animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/2 w-48 h-48 bg-[var(--color-accent)]/20 rounded-full blur-2xl animate-pulse"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <!-- Left Content -->
            <div class="lg:w-1/2 text-center lg:text-left">
                <div class="animate-fadeInUp">
                    <h1 class="text-5xl md:text-7xl font-extrabold mb-4 uppercase text-[var(--color-primary)] drop-shadow-lg tracking-tight animate-slideIn">
                        Professional Cleaning Services for Your Space
                    </h1>
                    <p class="text-2xl md:text-2xl italic mb-4 text-[var(--color-secondary)] font-medium animate-slideIn-delayed">
                        <?php echo $description ?? 'Bringing sparkle to your space. Trusted by hundreds for spotless home and office cleaning services.'; ?>
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fadeInUp-delayed">
                        <a href="/services" class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-[var(--color-primary)] hover:bg-[var(--color-primary)]/90 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            Our Services
                            <span class="ml-2 transform group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Content - Image -->
            <div class="lg:w-1/2 relative">
                <div class="relative z-10 animate-float">
                    <img src="/assets/images/hero/hero-bg.png"
                         alt="Professional Cleaning Service" 
                         class="rounded-lg shadow-2xl w-full h-auto transform hover:scale-105 transition-transform duration-500">
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-[var(--color-primary)]/20 rounded-full blur-2xl animate-pulse"></div>
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-[var(--color-secondary)]/20 rounded-full blur-2xl animate-pulse-delayed"></div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes slideIn {
        0% {
            opacity: 0;
            transform: translateX(-50px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 1.2s ease-out;
    }

    .animate-fadeInUp-delayed {
        animation: fadeInUp 1.2s ease-out 0.6s both;
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    .animate-float-delayed {
        animation: float 6s ease-in-out 2s infinite;
    }

    .animate-slideIn {
        animation: slideIn 1s ease-out;
    }

    .animate-slideIn-delayed {
        animation: slideIn 1s ease-out 0.3s both;
    }

    .animate-pulse-delayed {
        animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) 1.5s infinite;
    }
</style>