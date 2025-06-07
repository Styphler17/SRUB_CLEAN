<?php
// Get theme colors
global $themeColors;
?>
<!-- Review Submission Form -->
<div class="max-w-lg mx-auto mb-12">
    <div class="relative group">
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#f8fafc'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#f8fafc'; ?>]/20 rounded-2xl border-2 border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/20 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/40 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
        <div class="relative z-10 p-8">
            <h3 class="text-2xl font-semibold mb-2 text-center text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">Share Your Experience</h3>
            <p class="text-gray-600 mb-6 text-center">We'd love to hear about your experience with Cleanesta Cleaning!</p>
            <form action="./index.php?page=testimonials/submit" method="POST" autocomplete="off">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>; focus:ring-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" required>
                </div>
                <div class="mb-4">
                    <label for="rating" class="block text-gray-700 font-medium mb-2">Rating</label>
                    <select id="rating" name="rating" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>; focus:ring-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" required>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="comment" class="block text-gray-700 font-medium mb-2">Comment</label>
                    <textarea id="comment" name="comment" rows="4" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>; focus:ring-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" required></textarea>
                </div>
                <button type="submit" class="w-full px-6 py-3 text-white font-semibold rounded-md transition-colors duration-300 shadow-md" style="background-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" onmouseover="this.style.backgroundColor='<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>'" onmouseout="this.style.backgroundColor='<?php echo $themeColors['primary'] ?? '#f34d26'; ?>'">
                    Submit Review
                </button>
            </form>
        </div>
    </div>
</div>