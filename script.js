const prefersReducedMotion = window.matchMedia(
  "(prefers-reduced-motion: reduce)"
).matches;
const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
const root = document.documentElement;
const body = document.body;

if (prefersReducedMotion) {
  root.classList.add("reduced-motion");
}

const storedTheme = localStorage.getItem("theme");
const initialTheme = storedTheme || (prefersDark ? "dark" : "light");
body.setAttribute("data-theme", initialTheme);

const themeToggle = document.querySelector(".theme-toggle");
if (themeToggle) {
  themeToggle.addEventListener("click", () => {
    const nextTheme = body.getAttribute("data-theme") === "dark" ? "light" : "dark";
    body.setAttribute("data-theme", nextTheme);
    localStorage.setItem("theme", nextTheme);
  });
}

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("is-visible");
        observer.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.2 }
);

const revealItems = document.querySelectorAll(
  ".about-cards article, .project, .skill-block, .contact-card"
);

revealItems.forEach((item, index) => {
  item.style.transitionDelay = `${index * 80}ms`;
  item.classList.add("reveal");
  observer.observe(item);
});

if (!prefersReducedMotion && window.gsap) {
  const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

  tl.from(".site-header", { y: -20, opacity: 0, duration: 0.8 })
    .from(
      ".hero .hero-availability",
      { y: 10, opacity: 0, duration: 0.6 },
      "-=0.4"
    )
    .from(
      ".hero h1",
      { y: 20, opacity: 0, duration: 0.8 },
      "-=0.4"
    )
    .from(
      ".hero .lede",
      { y: 16, opacity: 0, duration: 0.6 },
      "-=0.5"
    )
    .from(
      ".hero-actions .btn",
      { y: 12, opacity: 0, duration: 0.5, stagger: 0.12 },
      "-=0.4"
    )
    .from(
      ".hero-showcase",
      { scale: 0.95, opacity: 0, duration: 0.8 },
      "-=0.6"
    )
    .from(
      ".hero-showcase .hero-card",
      { y: 18, opacity: 0, duration: 0.6, stagger: 0.12 },
      "-=0.6"
    );
} else if (!prefersReducedMotion) {
  root.classList.add("hero-animate");
}
