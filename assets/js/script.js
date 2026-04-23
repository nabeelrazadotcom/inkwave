(() => {
  // Floating ambient phrases (register page background)
  const floatPhrases = [
    "Write without resistance",
    "Let ideas flow",
    "Every story begins here",
    "Thought becomes form",
    "The page is alive",
  ];

  const bg = document.getElementById("bg");

  function createFloatText() {
    if (!bg) return;
    const el = document.createElement("div");
    el.className = "float-text";
    el.innerText = floatPhrases[Math.floor(Math.random() * floatPhrases.length)];

    el.style.left = Math.random() * 100 + "vw";
    el.style.top = "100vh";
    el.style.animationDuration = 12 + Math.random() * 10 + "s";

    bg.appendChild(el);

    setTimeout(() => {
      el.remove();
    }, 20000);
  }

  if (bg) {
    setInterval(createFloatText, 2000);
    for (let i = 0; i < 8; i++) setTimeout(createFloatText, i * 400);
  }

  // Subtle brand line cycling (only if present)
  const typingPhrases = [
    "Pick up your thoughts…",
    "Keep the flow alive…",
    "Your story continues…",
  ];

  const brandEl = document.querySelector("[data-rotate]");
  if (brandEl) {
    let index = 0;
    setInterval(() => {
      brandEl.textContent = typingPhrases[index];
      index = (index + 1) % typingPhrases.length;
    }, 4000);
  }

  // Main page scroll reveals (only if reveal elements exist)
  const revealEls = document.querySelectorAll(".reveal");
  if (revealEls.length) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: "0px 0px -40px 0px" },
    );

    revealEls.forEach((el, i) => {
      el.style.transitionDelay = `${(i % 3) * 80}ms`;
      observer.observe(el);
    });
  }

  // Smooth anchor scroll (homepage)
  document.querySelectorAll('a[href="#stream"]').forEach((a) => {
    a.addEventListener("click", (e) => {
      const target = document.getElementById("stream");
      if (!target) return;
      e.preventDefault();
      target.scrollIntoView({ behavior: "smooth" });
    });
  });

  // Nav background on scroll (homepage)
  const nav = document.querySelector("nav");
  if (nav) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 80) {
        nav.style.background = "rgba(17,24,39,0.97)";
      } else {
        nav.style.background =
          "linear-gradient(to bottom, rgba(17,24,39,0.95) 60%, transparent)";
      }
    });
  }
})();
