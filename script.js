document.addEventListener("DOMContentLoaded", function () {
  // Header scroll effect
  const header = document.querySelector(".header");
  let lastScroll = 0;

  window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > lastScroll && currentScroll > 50) {
      header.classList.add("scrolled");
    } else if (currentScroll < 50) {
      header.classList.remove("scrolled");
    }

    lastScroll = currentScroll;
  });

  // Mobile menu toggle
  const navToggle = document.querySelector(".nav-toggle");
  const navMenu = document.querySelector(".nav-menu");
  const navHamburger = document.querySelector(".nav-hamburger");

  navToggle.addEventListener("click", function () {
    navMenu.classList.toggle("active");
    navHamburger.classList.toggle("fa-close");
  });

  // Close mobile menu when clicking outside
  document.addEventListener("click", function (event) {
    if (!event.target.closest(".nav") && navMenu.classList.contains("active")) {
      navMenu.classList.remove("active");
    }
  });

  // Modal functionality
  const modal = document.getElementById("contactModal");
  const openModalBtn = document.getElementById("openModal");
  const closeModalBtn = document.querySelector(".close-modal");

  if (openModalBtn) {
    openModalBtn.addEventListener("click", function () {
      modal.style.display = "flex";
    });
  }

  if (closeModalBtn) {
    closeModalBtn.addEventListener("click", function () {
      modal.style.display = "none";
    });
  }

  // Close modal when clicking outside
  window.addEventListener("click", function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });

  // Contact form submission (main form)
  const contactForm = document.getElementById("contactForm");
  const phoneInput = document.getElementById("phone");

  if (contactForm && phoneInput) {
    contactForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const formData = {
        name: document.getElementById("name").value,
        phone: phoneInput.value,
        comment: document.getElementById("comment").value,
      };

      console.log("Form submitted:", formData);

      alert("Спасибо! Мы свяжемся с вами в ближайшее время.");

      contactForm.reset();
    });

    // Phone number input mask for main form
    phoneInput.addEventListener("input", function (e) {
      let x = e.target.value
        .replace(/\D/g, "")
        .match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,4})/);

      e.target.value = !x[2]
        ? x[1]
        : "+7 (" + x[2] + (x[3] ? ") " + x[3] : "") + (x[4] ? "-" + x[4] : "");
    });
  }
});
