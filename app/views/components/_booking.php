<?php
// Get theme colors
global $themeColors;
?>
<!-- Booking Section -->
<section id="booking" class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">Book Your Cleaning Service</h2>

        <div class="max-w-3xl mx-auto">
            <div class="relative group">
                <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#f8fafc'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#f8fafc'; ?>]/20 rounded-2xl border-2 border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/20 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/40 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
                <div class="relative z-10 p-6">
                    <form id="bookingForm">
                        <!-- Service Selection -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Select Service</label>
                            <select class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="service_id" required>
                                <option value="">Choose a service...</option>
                                <?php foreach ($services as $service): ?>
                                    <option value="<?php echo $service['id']; ?>"
                                        data-price="<?php echo $service['base_price']; ?>"
                                        data-duration="<?php echo $service['duration_minutes']; ?>">
                                        <?php echo $service['name']; ?> - $<?php echo number_format($service['base_price'], 2); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Date and Time Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Preferred Date</label>
                                <input type="date" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="preferred_date" required
                                    min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Preferred Time</label>
                                <select class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="preferred_time" required>
                                    <option value="">Select time...</option>
                                    <?php
                                    $start = strtotime('08:00');
                                    $end = strtotime('18:00');
                                    for ($time = $start; $time <= $end; $time += 3600) {
                                        echo '<option value="' . date('H:i', $time) . '">' . date('g:i A', $time) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="first_name" class="block text-gray-700 font-medium mb-2">First Name</label>
                                <input type="text" id="first_name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="first_name" required autocomplete="given-name">
                            </div>
                            <div>
                                <label for="last_name" class="block text-gray-700 font-medium mb-2">Last Name</label>
                                <input type="text" id="last_name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="last_name" required autocomplete="family-name">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" id="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="email" required autocomplete="email">
                            </div>
                            <div>
                                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone</label>
                                <input type="tel" id="phone" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="phone" required autocomplete="tel">
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="mb-6">
                            <label for="address" class="block text-gray-700 font-medium mb-2">Address</label>
                            <input type="text" id="address" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="address" required autocomplete="street-address">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label for="city" class="block text-gray-700 font-medium mb-2">City</label>
                                <input type="text" id="city" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="city" required autocomplete="address-level2">
                            </div>
                            <div>
                                <label for="state" class="block text-gray-700 font-medium mb-2">State</label>
                                <input type="text" id="state" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="state" required autocomplete="address-level1">
                            </div>
                            <div>
                                <label for="zip_code" class="block text-gray-700 font-medium mb-2">ZIP Code</label>
                                <input type="text" id="zip_code" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="zip_code" required autocomplete="postal-code">
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Additional Notes</label>
                            <textarea class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2" style="border-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" name="notes" rows="3"></textarea>
                        </div>

                        <!-- Booking Summary -->
                        <div class="relative group mb-6">
                            <div class="absolute inset-0 z-0 bg-gradient-to-br from-[<?php echo $themeColors['neutral'] ?? '#f8fafc'; ?>]/60 to-[<?php echo $themeColors['neutral'] ?? '#f8fafc'; ?>]/20 rounded-2xl border-2 border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]/20 group-hover:border-[<?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>]/40 backdrop-blur-lg transition-all duration-300 shadow-xl group-hover:shadow-2xl"></div>
                            <div class="relative z-10 p-6">
                                <h5 class="text-lg font-semibold mb-4 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">Booking Summary</h5>
                                <div id="bookingSummary" class="space-y-2">
                                    <p class="text-gray-700">Service: <span id="selectedService" class="font-medium">-</span></p>
                                    <p class="text-gray-700">Duration: <span id="serviceDuration" class="font-medium">-</span></p>
                                    <p class="text-gray-700">Total Price: <span id="totalPrice" class="font-medium">-</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="px-8 py-4 text-white rounded-full text-lg font-medium transition-colors duration-300 shadow-md" style="background-color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;" onmouseover="this.style.backgroundColor='<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>'" onmouseout="this.style.backgroundColor='<?php echo $themeColors['primary'] ?? '#f34d26'; ?>'">
                                Send Booking Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Collect form data
        const service = this.service_id.options[this.service_id.selectedIndex].text;
        const date = this.preferred_date.value;
        const time = this.preferred_time.value;
        const firstName = this.first_name.value;
        const lastName = this.last_name.value;
        const email = this.email.value;
        const phone = this.phone.value;
        const address = this.address.value;
        const city = this.city.value;
        const state = this.state.value;
        const zip = this.zip_code.value;
        const notes = this.notes.value;

        // Compose WhatsApp message
        let message = `Booking Request:%0A`;
        message += `Service: ${service}%0A`;
        message += `Date: ${date}%0A`;
        message += `Time: ${time}%0A`;
        message += `Name: ${firstName} ${lastName}%0A`;
        message += `Email: ${email}%0A`;
        message += `Phone: ${phone}%0A`;
        message += `Address: ${address}, ${city}, ${state}, ${zip}%0A`;
        if (notes) message += `Notes: ${notes}%0A`;

        // WhatsApp link
        const waLink = `https://wa.me/447359129002?text=${message}`;
        window.open(waLink, '_blank');
    });
</script>