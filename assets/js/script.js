document.addEventListener("DOMContentLoaded", () => {
  // Recupere le bouton burger et le menu mobile.
  const burger = document.querySelector(".burger");
  const menu = document.querySelector(".nav-menu");

  // Arrete le script si le menu n'est pas present.
  if (!burger || !menu) return;

  // Ferme le menu mobile.
  const closeMenu = () => {
    menu.classList.remove("open");
    burger.classList.remove("active");
    burger.setAttribute("aria-expanded", "false");
    burger.setAttribute("aria-label", "Ouvrir le menu");
    document.body.classList.remove("has-mobile-menu-open");
  };

  // Ouvre le menu mobile.
  const openMenu = () => {
    menu.classList.add("open");
    burger.classList.add("active");
    burger.setAttribute("aria-expanded", "true");
    burger.setAttribute("aria-label", "Fermer le menu");
    document.body.classList.add("has-mobile-menu-open");
  };

  // Ouvre ou ferme le menu au clic sur le burger.
  burger.addEventListener("click", () => {
    if (menu.classList.contains("open")) {
      closeMenu();
      return;
    }

    openMenu();
  });

  // Ferme le menu apres le clic sur un lien.
  menu.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", closeMenu);
  });

  // Ferme le menu avec la touche Echap.
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeMenu();
    }
  });

  // Ferme le menu quand on repasse en affichage large.
  window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
      closeMenu();
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  // Anime le slider Technologies de la page A propos.
  const slider = document.querySelector("[data-tech-slider]");

  // Le script reste inactif sur les pages qui n'ont pas ce slider.
  if (!slider) return;

  const viewport = slider.querySelector(".tech-slider__viewport");
  const previousButton = slider.querySelector(".tech-slider__button--prev");
  const nextButton = slider.querySelector(".tech-slider__button--next");

  if (!viewport || !previousButton || !nextButton) return;

  const getSlideWidth = () => {
    const slide = viewport.querySelector(".tech-slide");
    const gap = 18;

    return slide ? slide.getBoundingClientRect().width + gap : 220;
  };

  // Deplace le slider d'une carte a la fois.
  const moveSlider = (direction = 1) => {
    const nextPosition = viewport.scrollLeft + getSlideWidth() * direction;

    if (nextPosition >= viewport.scrollWidth - viewport.clientWidth - 4) {
      viewport.scrollTo({ left: 0, behavior: "smooth" });
      return;
    }

    if (nextPosition <= 0) {
      viewport.scrollTo({ left: viewport.scrollWidth, behavior: "smooth" });
      return;
    }

    viewport.scrollBy({ left: getSlideWidth() * direction, behavior: "smooth" });
  };

  previousButton.addEventListener("click", () => moveSlider(-1));
  nextButton.addEventListener("click", () => moveSlider(1));

  // Ajoute une animation automatique simple, sans gener l'utilisateur.
  let autoplay = window.setInterval(() => moveSlider(1), 2800);

  slider.addEventListener("mouseenter", () => window.clearInterval(autoplay));
  slider.addEventListener("mouseleave", () => {
    autoplay = window.setInterval(() => moveSlider(1), 2800);
  });
});
