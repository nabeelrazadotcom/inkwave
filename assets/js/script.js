// Floating ambient phrases
const phrases = [
  "Write without resistance",
  "Let ideas flow",
  "Every story begins here",
  "Thought becomes form",
  "The page is alive",
];

const bg = document.getElementById("bg");

function createFloatText() {
  const el = document.createElement("div");
  el.className = "float-text";
  el.innerText = phrases[Math.floor(Math.random() * phrases.length)];

  el.style.left = Math.random() * 100 + "vw";
  el.style.top = "100vh";
  el.style.animationDuration = 12 + Math.random() * 10 + "s";

  bg.appendChild(el);

  setTimeout(() => {
    el.remove();
  }, 20000);
}

// generate floating text continuously
setInterval(createFloatText, 2000);

// initial burst
for (let i = 0; i < 8; i++) {
  setTimeout(createFloatText, i * 400);
}

// Subtle typing placeholder effect (optional emotional touch)

const phrases = [
  "Pick up your thoughts…",
  "Keep the flow alive…",
  "Your story continues…",
];

let i = 0;

setInterval(() => {
  document.querySelector(".brand").textContent = phrases[i];
  i = (i + 1) % phrases.length;
}, 4000);


// SCRIPT FOR Main Page
// Intersection Observer for scroll reveals
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observer.unobserve(entry.target);
      }
    });
  },
  {
    threshold: 0.12,
    rootMargin: "0px 0px -40px 0px",
  },
);

document.querySelectorAll(".reveal").forEach((el, i) => {
  el.style.transitionDelay = `${(i % 3) * 80}ms`;
  observer.observe(el);
});

// Smooth anchor scroll
document.querySelectorAll('a[href="#stream"]').forEach((a) => {
  a.addEventListener("click", (e) => {
    e.preventDefault();
    document.getElementById("stream").scrollIntoView({
      behavior: "smooth",
    });
  });
});

// Nav background on scroll
const nav = document.querySelector("nav");
window.addEventListener("scroll", () => {
  if (window.scrollY > 80) {
    nav.style.background = "rgba(17,24,39,0.97)";
  } else {
    nav.style.background =
      "linear-gradient(to bottom, rgba(17,24,39,0.95) 60%, transparent)";
  }
});
