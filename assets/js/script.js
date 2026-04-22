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
    "Your story continues…"
];

let i = 0;

setInterval(() => {
    document.querySelector('.brand').textContent = phrases[i];
    i = (i + 1) % phrases.length;
}, 4000);