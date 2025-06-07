document.addEventListener("DOMContentLoaded", function () {
  const header = document.getElementById("mainHeader");
  const mobileMenuButton = document.getElementById("mobileMenuButton");
  const mobileMenu = document.getElementById("mobileMenu");

  // Mobile menu toggle
  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener("click", function (e) {
      e.stopPropagation();
      mobileMenu.classList.toggle("hidden");
    });

    // Close menu when clicking outside
    document.addEventListener("click", function (e) {
      if (!mobileMenu.classList.contains("hidden")) {
        if (!mobileMenu.contains(e.target) && e.target !== mobileMenuButton) {
          mobileMenu.classList.add("hidden");
        }
      }
    });

    // Prevent clicks inside the menu from closing it
    mobileMenu.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  }

  // Header scroll effect: hide on scroll down after 5% scroll, show on scroll up
  if (header) {
    let lastScrollY = window.scrollY;
    let ticking = false;
    let hideThreshold = 0;

    function updateThreshold() {
      // 5% of total scrollable height
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      hideThreshold = docHeight * 0.05;
    }

    updateThreshold();
    window.addEventListener('resize', updateThreshold);

    function onScroll() {
      const currentScrollY = window.scrollY;
      if (currentScrollY > lastScrollY && currentScrollY > hideThreshold) {
        // Scrolling down past 5%
        header.classList.add("header-hidden");
      } else {
        // Scrolling up
        header.classList.remove("header-hidden");
      }
      lastScrollY = currentScrollY;
      ticking = false;
    }

    window.addEventListener("scroll", function () {
      if (!ticking) {
        window.requestAnimationFrame(onScroll);
        ticking = true;
      }
    });
  }
});

// Add this CSS to your stylesheet or in a <style> block:
// .header-hidden { transform: translateY(-100%); transition: transform 0.3s; }
