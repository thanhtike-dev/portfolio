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

//smooth scroll
const lenis = new Lenis();

lenis.on('scroll', ScrollTrigger.update);

gsap.ticker.add((time) => {
  lenis.raf(time * 1000);
});

gsap.ticker.lagSmoothing(0);

const hasGsapMotion = !prefersReducedMotion && window.gsap;

if (hasGsapMotion) {
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

let workMatchMedia = null;
let resizeTimer = null;

const destroyWorkScroll = () => {
  if (workMatchMedia) {
    workMatchMedia.revert();
    workMatchMedia = null;
  }
};

const initWorkScroll = () => {
  if (!(hasGsapMotion && window.ScrollTrigger)) {
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  const workSection = document.querySelector(".work");
  const workShell = document.querySelector(".work-shell");
  const workViewport = document.querySelector(".work-cards-viewport");
  const workTrack = document.querySelector(".work-track");

  if (!workSection || !workShell || !workViewport || !workTrack) {
    return;
  }

  destroyWorkScroll();

  workMatchMedia = gsap.matchMedia();

  workMatchMedia.add("(min-width: 1001px)", () => {
    const getTravel = () =>
      Math.max(0, workTrack.scrollHeight - workViewport.clientHeight);

    if (getTravel() < 12) {
      return undefined;
    }

    const tween = gsap.to(workTrack, {
      y: () => -getTravel(),
      ease: "none",
      scrollTrigger: {
        id: "work-vertical-scroll",
        trigger: workSection,
        start: "top top",
        end: () => `+=${Math.max(1, getTravel())}`,
        pin: workShell,
        scrub: 0.8,
        invalidateOnRefresh: true,
        anticipatePin: 1,
      },
    });

    return () => {
      tween.scrollTrigger?.kill();
      tween.kill();
      gsap.set(workTrack, { clearProps: "transform" });
    };
  });

  requestAnimationFrame(() => {
    ScrollTrigger.refresh();
  });
};

initWorkScroll();

window.addEventListener("pagehide", () => {
  destroyWorkScroll();
});

window.addEventListener("pageshow", (event) => {
  if (event.persisted) {
    initWorkScroll();
  }
});

if (hasGsapMotion && window.ScrollTrigger) {
  window.addEventListener("load", () => {
    ScrollTrigger.refresh();
  });

  const handleViewportChange = () => {
    if (resizeTimer) {
      window.clearTimeout(resizeTimer);
    }

    resizeTimer = window.setTimeout(() => {
      destroyWorkScroll();
      initWorkScroll();
      ScrollTrigger.refresh();
    }, 180);
  };

  window.addEventListener("resize", handleViewportChange, { passive: true });
  window.addEventListener("orientationchange", handleViewportChange, {
    passive: true,
  });
}
