<?php
// Get theme colors
global $themeColors;
?>
    <!-- Contact Section -->
<section id="contact" class="py-16 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#f8fafc'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#f8fafc'; ?>]/20 min-h-[60vh]">
        <div class="container mx-auto px-4 flex flex-col items-center justify-center">
        <div class="max-w-4xl w-full mx-auto">
            <div class="bg-white/80 rounded-3xl shadow-2xl border-2 border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/20 p-10 flex flex-col md:flex-row gap-10 items-stretch">
                <!-- Contact Methods -->
                <div class="flex-1 flex flex-col gap-8 justify-center">
                    <h2 class="text-4xl font-bold text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] mb-8 text-center md:text-left">Contact Us</h2>
                    <!-- Phone Numbers -->
                    <?php if (!empty($contactInfo['phone_numbers'])): ?>
                        <?php foreach ($contactInfo['phone_numbers'] as $phone): ?>
                            <div class="flex items-center gap-4 bg-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/10 rounded-xl p-4 shadow-sm">
                                <div class="bg-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>] text-white rounded-full p-3 shadow-md">
                                    <i class="fas fa-phone text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-800">Phone</h5>
                                    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="text-gray-700 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] underline text-lg transition-colors duration-200">
                                        <?php echo $phone; ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                            <!-- WhatsApp -->
                    <div class="flex items-center gap-4 bg-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>]/10 rounded-xl p-4 shadow-sm">
                        <div class="bg-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] text-white rounded-full p-3 shadow-md">
                                    <i class="fa-brands fa-whatsapp text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-800">WhatsApp</h5>
                                    <?php if (!empty($contactInfo['whatsapp_link'])): ?>
                                <a href="<?php echo $contactInfo['whatsapp_link']; ?>" target="_blank" class="text-gray-700 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] underline text-lg transition-colors duration-200">
                                            <?php echo preg_replace('/^https:\/\/wa\.me\//', '+', $contactInfo['whatsapp_link']); ?>
                                        </a>
                                    <?php else: ?>
                                        <p class="text-gray-600">Not available</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Email -->
                    <div class="flex items-center gap-4 bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/10 rounded-xl p-4 shadow-sm">
                        <div class="bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white rounded-full p-3 shadow-md">
                                    <i class="fas fa-envelope text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-800">Email</h5>
                                    <?php if (!empty($contactInfo['email'])): ?>
                                <a href="mailto:<?php echo $contactInfo['email']; ?>" class="text-gray-700 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] underline text-lg transition-colors duration-200">
                                            <?php echo $contactInfo['email']; ?>
                                        </a>
                                    <?php else: ?>
                                        <p class="text-gray-600">Not available</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                <!-- Business Hours -->
                <div class="flex-1 flex flex-col items-center justify-center">
                    <h5 class="font-semibold text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] mb-6 text-center text-2xl">Available Hours</h5>
                    <div class="w-full flex flex-col gap-2">
                            <?php if (!empty($businessHours) && is_array($businessHours)): ?>
                            <?php
                            // Assign a color for each day (cycling through theme colors)
                            $dayColors = [
                                $themeColors['primary'] ?? '#f34d26',
                                $themeColors['secondary'] ?? '#00bda4',
                                $themeColors['accent'] ?? '#7d2ea8',
                                '#fbbf24', // yellow-400
                                '#60a5fa', // blue-400
                                '#34d399', // green-400
                                '#f472b6', // pink-400
                            ];
                            $i = 0;
                            ?>
                                    <?php foreach ($businessHours as $hour): ?>
                                <?php $bgColor = $dayColors[$i % count($dayColors)] . '20'; /* 20 for ~12% opacity */ ?>
                                <div class="flex items-center justify-between rounded-lg px-4 py-2 mb-1" style="background-color: <?php echo $bgColor; ?>;">
                                            <span class="font-medium text-gray-900"><?php echo $hour['day']; ?>:</span>
                                            <?php if ($hour['is_closed']): ?>
                                                <span class="text-red-500 font-semibold">Closed</span>
                                            <?php else: ?>
                                        <span class="text-gray-700"><?php echo date('g:i A', strtotime($hour['open_time'])) . ' - ' . date('g:i A', strtotime($hour['close_time'])); ?></span>
                                            <?php endif; ?>
                                </div>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p class="text-gray-600 text-center">Business hours not available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>