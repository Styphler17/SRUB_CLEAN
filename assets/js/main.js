function initHeader() {
  const header = document.getElementById('mainHeader');
  const mobileMenuButton = document.getElementById('mobileMenuButton');
  const mobileMenu = document.getElementById('mobileMenu');
  const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', function (e) {
      e.stopPropagation();
      mobileMenu.classList.toggle('hidden');
      if (mobileMenuOverlay) mobileMenuOverlay.classList.toggle('hidden');
    });

    document.addEventListener('click', function (e) {
      if (!mobileMenu.classList.contains('hidden')) {
        if (!mobileMenu.contains(e.target) && e.target !== mobileMenuButton) {
          mobileMenu.classList.add('hidden');
          if (mobileMenuOverlay) mobileMenuOverlay.classList.add('hidden');
        }
      }
    });

    mobileMenu.addEventListener('click', function (e) {
      e.stopPropagation();
    });

    if (mobileMenuOverlay) {
      mobileMenuOverlay.addEventListener('click', function () {
        mobileMenu.classList.add('hidden');
        mobileMenuOverlay.classList.add('hidden');
      });
    }
  }

  if (header) {
    let lastScrollY = window.scrollY;
    let ticking = false;
    let hideThreshold = 0;

    function updateThreshold() {
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      hideThreshold = docHeight * 0.05;
    }

    updateThreshold();
    window.addEventListener('resize', updateThreshold);

    function onScroll() {
      const currentScrollY = window.scrollY;
      if (currentScrollY > lastScrollY && currentScrollY > hideThreshold) {
        header.classList.add('header-hidden');
      } else {
        header.classList.remove('header-hidden');
      }
      lastScrollY = currentScrollY;
      ticking = false;
    }

    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(onScroll);
        ticking = true;
      }
    });
  }
}

function initBackToTop() {
  const backToTopButton = document.getElementById('backToTop');
  if (!backToTopButton) return;

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
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

function initBookingForm() {
  const form = document.getElementById('bookingForm');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
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

    let message = `Booking Request:%0A`;
    message += `Service: ${service}%0A`;
    message += `Date: ${date}%0A`;
    message += `Time: ${time}%0A`;
    message += `Name: ${firstName} ${lastName}%0A`;
    message += `Email: ${email}%0A`;
    message += `Phone: ${phone}%0A`;
    message += `Address: ${address}, ${city}, ${state}, ${zip}%0A`;
    if (notes) message += `Notes: ${notes}%0A`;

    const waLink = `https://wa.me/447359129002?text=${message}`;
    window.open(waLink, '_blank');
  });
}

function initTestimonialsSwiper() {
  if (typeof Swiper === 'undefined') return;
  const swiper = document.querySelector('.testimonials-swiper');
  if (!swiper) return;

  new Swiper('.testimonials-swiper', {
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    slidesPerView: 1,
    spaceBetween: 32,
    breakpoints: {
      768: { slidesPerView: 1 },
      1024: { slidesPerView: 1 },
    },
  });
}

function hideFooterOnHome() {
  const path = window.location.pathname.replace(/\/$/, '');
  if (path === '/home' || path === '/') {
    const footer = document.querySelector('footer');
    if (footer) footer.style.display = 'none';
  }
}

document.addEventListener('DOMContentLoaded', () => {
  initHeader();
  initBackToTop();
  initBookingForm();
  initTestimonialsSwiper();
  hideFooterOnHome();
});

// .header-hidden { transform: translateY(-100%); transition: transform 0.3s; }
