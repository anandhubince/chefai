<?php

include("C:/xampp/htdocs/ChefAI/User/navigation.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Quick Recipe Genius — Ultra</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />
  <style>
    /* ===============================
       THEME / TOKENS
    =================================*/
    :root {
      --bg: radial-gradient(1200px 800px at 10% -10%, #baf7e1 0%, transparent 60%),
            radial-gradient(1000px 900px at 120% 10%, #ffd6ea 0%, transparent 50%),
            linear-gradient(135deg, #eefbf4 0%, #eff6ff 100%);
      --card: rgba(255, 255, 255, 0.7);
      --card-strong: rgba(255, 255, 255, 0.9);
      --glass-stroke: 1px solid rgba(255,255,255,.45);
      --text: #0f172a;
      --muted: #475569;
      --accent: #22c55e;
      --accent-2: #16a34a;
      --info: #3b82f6;
      --violet: #8b5cf6;
      --shadow-xl: 0 30px 80px rgba(2, 6, 23, .22);
      --shadow-lg: 0 18px 52px rgba(2, 6, 23, .15);
      --shadow-sm: 0 6px 20px rgba(2, 6, 23, .08);
      --chip: rgba(34,197,94,.12);
      --ring-muted: rgba(148,163,184,.25);
      --glass-blur: blur(18px) saturate(140%);
    }
    [data-theme="dark"] {
      --bg: radial-gradient(1200px 800px at 0% -10%, #0b3a2a 0%, transparent 55%),
            radial-gradient(1000px 800px at 120% -10%, #3a1147 0%, transparent 60%),
            linear-gradient(135deg, #0b1220 0%, #0b1d17 100%);
      --card: rgba(15, 23, 42, 0.5);
      --card-strong: rgba(15, 23, 42, 0.7);
      --glass-stroke: 1px solid rgba(255,255,255,.08);
      --text: #e2e8f0;
      --muted: #94a3b8;
      --chip: rgba(34,197,94,.18);
      --ring-muted: rgba(100,116,139,.35);
      --shadow-xl: 0 30px 90px rgba(0,0,0,.5);
      --shadow-lg: 0 18px 52px rgba(0,0,0,.38);
      --shadow-sm: 0 6px 20px rgba(0,0,0,.25);
      --glass-blur: blur(20px) saturate(160%);
    }

    /* ===============================
       BASE & LAYOUT
    =================================*/
    * { box-sizing: border-box; }
    html, body { height: 100%; }
    body {
      margin: 0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      color: var(--text);
      background: var(--bg);
      background-attachment: fixed;
      line-height: 1.5;
      overflow-x: hidden;
    }

    .parallax { position: fixed; inset: 0; pointer-events: none; z-index: 0; }
    .blob { position:absolute; filter: blur(40px); opacity:.35; transform: translateZ(0); }
    .blob.one { width: 420px; height: 420px; left:-80px; top:-80px; background: conic-gradient(from 120deg, #22c55e, #3b82f6, #8b5cf6, #22c55e); border-radius: 50%; }
    .blob.two { width: 520px; height: 520px; right:-120px; top:-60px; background: conic-gradient(from -60deg, #f59e0b, #ef4444, #8b5cf6, #f59e0b); border-radius: 50%; opacity:.25; }

  
// ...existing code...
   /* Add enough top padding for your fixed navigation height */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  position: relative;
  z-index: 1;
  padding-top: 120px; /* adjust based on nav height */
}
/* Navigation bar fix */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 80px; /* adjust to match actual nav height */
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 2rem;
  background: rgba(255, 255, 255, 0.7); /* light glass effect */
  backdrop-filter: blur(12px);
  z-index: 1000;
  border-bottom: 1px solid rgba(255,255,255,0.2);
}
/* Add padding so content clears the navbar */
body {
  padding-top: 80px; /* must equal navbar height */
}

// ...existing code...

.hero {
  display: flex;
  flex-direction: column;   /* stack vertically */
  justify-content: center;  /* center vertically in container */
  align-items: center;      /* center horizontally */
  text-align: center;
  gap: 18px;
  padding: 40px 0;          /* spacing top and bottom */
}

    .hero h1 {
      font-family: Poppins, Inter, system-ui;
      font-weight: 800;
      letter-spacing: -0.02em;
      font-size: clamp(2.2rem, 3.6vw, 3.4rem);
      margin: 0;
      background: linear-gradient(90deg, #16a34a, #22c55e 35%, #3b82f6 80%);
      -webkit-background-clip: text; background-clip: text; color: transparent;
      filter: drop-shadow(0 6px 16px rgba(34,197,94,.25));
      transform-style: preserve-3d;
    }
    .hero p { margin: 0; color: var(--muted); max-width: 800px; }

    .toolbar {
      display: flex; gap: 10px; justify-content: center; align-items: center; margin: 12px 0 26px;
    }

    .switch {
      --w: 56px; --h: 30px; --r: 22px;
      width: var(--w); height: var(--h); border-radius: 999px; position: relative; cursor: pointer; user-select: none;
      background: var(--card); border: var(--glass-stroke); box-shadow: var(--shadow-sm);
    }
    .switch input { display: none; }
    .knob {
      position: absolute; top: 3px; left: 3px; width: 24px; height: 24px; border-radius: 50%;
      background: white; box-shadow: 0 6px 20px rgba(2,6,23,.15), inset 0 -1px 1px rgba(2,6,23,.08);
      transition: transform .25s ease;
    }
    .switch input:checked + .knob { transform: translateX(26px); }

    /* PANELS */
    .panel {
      background: var(--card);
      border: var(--glass-stroke);
      border-radius: 24px;
      box-shadow: var(--shadow-lg);
      backdrop-filter: var(--glass-blur);
      transform-style: preserve-3d;
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .panel[data-tilt="true"]:hover { box-shadow: var(--shadow-xl); }

    /* ===============================
       SELECTOR / CHIPS
    =================================*/
    .grid { display:grid; grid-template-columns: 1.15fr 1fr; gap:18px; align-items:start; }
    @media (max-width: 980px){ .grid { grid-template-columns: 1fr; } }

    .section { padding: 18px 18px 12px; }
    .section h3 { margin: 0 0 16px; font-family: Poppins, Inter; font-size: 1.1rem; letter-spacing: .3px; color: var(--text); padding-bottom: 10px; border-bottom: 1px solid var(--ring-muted); }
    .chips { display: flex; flex-wrap: wrap; gap: 10px; }
    .chip {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 10px 14px; border-radius: 999px; border: 1px solid rgba(148,163,184,.25);
      background: var(--chip); color: var(--text); font-weight: 600; cursor: pointer; position: relative; overflow: hidden;
      transition: transform .15s ease, box-shadow .3s ease, border-color .2s ease;
    }
    .chip:hover { transform: translateY(-2px); box-shadow: var(--shadow-sm); }
    .chip.selected { border-color: #22c55e; box-shadow: 0 6px 24px rgba(34,197,94,.22); }

    /* Ripple effect */
    .chip::after, .btn::after {
      content: ""; position: absolute; inset: 0; background: radial-gradient(120px 120px at var(--x) var(--y), rgba(255,255,255,.55), transparent 40%);
      opacity: 0; transition: opacity .6s ease; pointer-events: none;
    }
    .chip:active::after, .btn:active::after { opacity: .7; transition: opacity .12s ease; }

    /* INPUT */
    .input {
      width: 100%; padding: 14px 16px; border-radius: 14px; border: 1px solid rgba(148,163,184,.35);
      background: var(--card-strong); color: var(--text); outline: none; font-size: 0.95rem;
      box-shadow: inset 0 2px 6px rgba(2,6,23,.05);
    }
    .input-wrapper {
      display: flex;
      gap: 8px;
      align-items: center;
    }
    .input-wrapper .input {
      flex-grow: 1;
    }
    .input-wrapper .add-btn {
      flex-shrink: 0;
      padding: 0;
      width: 44px;
      height: 44px;
      border-radius: 14px;
      border: none;
      background: var(--accent);
      color: white;
      font-size: 24px;
      cursor: pointer;
      display: grid;
      place-items: center;
      transition: background-color .2s;
    }
    .input-wrapper .add-btn:hover {
      background: var(--accent-2);
    }

    /* ===============================
       ACTIONS / BUTTONS
    =================================*/
    .actions { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; padding: 18px; }
    .btn {
      position: relative; overflow: hidden; border: none; cursor: pointer; border-radius: 16px; padding: 14px 18px; font-weight: 700;
      background: linear-gradient(90deg, #16a34a, #22c55e 40%, #3b82f6); color: white;
      box-shadow: 0 12px 40px rgba(34,197,94,.28);
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .btn.alt { background: linear-gradient(90deg, #0ea5e9, #8b5cf6 60%, #22d3ee); box-shadow: 0 12px 40px rgba(59,130,246,.28); }
    .btn.violet { background: linear-gradient(90deg, #8b5cf6, #22d3ee); box-shadow: 0 12px 40px rgba(139,92,246,.28); }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 16px 50px rgba(34,197,94,.35); }

    /* ===============================
       LOADER (Chef pan)
    =================================*/
    .loader-wrap { display:none; place-items: center; padding: 26px; }
    .chef { width: 120px; height: 120px; position: relative; }
    .pan { position:absolute; bottom: 10px; left: 4px; width: 112px; height: 22px; background: #0f172a; border-radius: 12px; box-shadow: inset 0 -2px 0 rgba(255,255,255,.2); }
    .handle { position:absolute; right: -28px; top: -4px; width: 36px; height: 10px; background:#1f2937; border-radius: 8px; }
    .egg { position:absolute; bottom: 22px; left: 28px; width: 20px; height: 28px; background:#fde68a; border-radius: 50% 50% 46% 46%; animation: flip 1.4s infinite ease-in-out; box-shadow: inset 0 -3px 0 #fbbf24; }
    .steam { position:absolute; bottom: 36px; left: 12px; width: 6px; height: 6px; background: #a7f3d0; border-radius: 50%; filter: blur(1px); animation: rise 2.4s infinite ease-in; }
    .steam:nth-child(2){ left: 54px; animation-delay: .4s; }
    .steam:nth-child(3){ left: 86px; animation-delay: .8s; }
    @keyframes rise { from{ transform: translateY(0) scale(.9); opacity:.8 } to{ transform: translateY(-46px) scale(1.1); opacity:0 } }
    @keyframes flip { 0%{ transform: translateX(0) rotate(0) } 50%{ transform: translateX(26px) rotate(180deg) } 100%{ transform: translateX(0) rotate(360deg) } }
    .loader-text { margin-top: 12px; color: var(--muted); font-weight: 600; }

    /* ===============================
       RESULT / RECIPE CARD
    =================================*/
    .result { display: none; }
    .recipe { padding: 20px; }
    .title { font-family: Poppins, Inter; font-weight: 800; font-size: clamp(1.6rem, 2.2vw, 2.1rem); margin: 0 0 8px; }
    .meta { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin: 14px 0 6px; }
    .meta-card { background: var(--card-strong); border: var(--glass-stroke); border-radius: 16px; padding: 12px; text-align: center; box-shadow: var(--shadow-sm); }
    .meta-card small { color: var(--muted); display:block; }
    .meta-card b { font-size: 1.05rem; }

    .cols { display: grid; gap: 18px; grid-template-columns: 1fr; }
    @media (min-width: 900px){ .cols { grid-template-columns: 1.1fr 1.2fr; } }

    .card { background: var(--card-strong); border: var(--glass-stroke); border-radius: 18px; padding: 16px 16px 12px; box-shadow: var(--shadow-sm); }
    .card h4 { margin: 0 0 10px; font-size: 1rem; letter-spacing: .2px; }
    ul.fancy, ol.fancy { margin: 0; padding-left: 18px; }
    ul.fancy li, ol.fancy li { margin: 6px 0; opacity: 0; transform: translateY(6px); animation: itemIn .5s forwards; }
    ul.fancy li:nth-child(n), ol.fancy li:nth-child(n){ animation-delay: calc(var(--i) * .06s); }
    @keyframes itemIn { to { opacity: 1; transform: translateY(0); } }

    /* NUTRITION RINGS */
    .rings { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; }
    .ring { aspect-ratio: 1/1; border-radius: 16px; display: grid; place-items: center; background: var(--card); border: var(--glass-stroke); box-shadow: var(--shadow-sm); }
    .ring .circle { --val: 62; width: 78px; height: 78px; border-radius: 50%; background: conic-gradient(var(--accent) calc(var(--val)*1%), var(--ring-muted) 0); display: grid; place-items: center; }
    .ring .circle span { background: var(--card-strong); padding: 6px 10px; border-radius: 999px; font-weight: 700; font-size: .9rem; }
    .ring small { color: var(--muted); display:block; margin-top: 8px; font-weight: 600; }

    /* TOAST / SAVE ANIMATION */
    .toast { position: fixed; left: 50%; bottom: 26px; transform: translateX(-50%) translateY(40px); background: var(--card-strong); border: var(--glass-stroke); padding: 12px 16px; border-radius: 14px; box-shadow: var(--shadow-lg); opacity: 0; transition: transform .35s ease, opacity .35s ease; font-weight: 700; z-index: 90; }
    .toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }

    .emoji-rain { position: fixed; inset: 0; pointer-events: none; z-index: 80; overflow: hidden; }
    .emoji { position: absolute; font-size: 22px; animation: fall linear forwards; }
    @keyframes fall { from { transform: translateY(-10vh) rotate(0); opacity: 1 } to { transform: translateY(110vh) rotate(360deg); opacity: 0 } }

    /* DRAWER (Saved Recipes) */
    .drawer { position: fixed; top: 0; right: 0; width: 380px; max-width: 92vw; height: 100vh; background: var(--card-strong); border-left: var(--glass-stroke); box-shadow: var(--shadow-xl); transform: translateX(102%); transition: transform .35s ease; z-index: 100; backdrop-filter: var(--glass-blur); }
    .drawer.open { transform: translateX(0); }
    .drawer header { display:flex; align-items:center; justify-content: space-between; padding: 14px 16px; border-bottom: var(--glass-stroke); position: sticky; top: 0; background: var(--card-strong); }
    .drawer .list { padding: 10px 12px 16px; overflow-y:auto; height: calc(100% - 56px); }
    .save-card { padding: 12px; border-radius: 14px; border: 1px solid rgba(148,163,184,.28); background: var(--card); box-shadow: var(--shadow-sm); margin-bottom: 12px; cursor: pointer; transition: transform .15s ease; }
    .save-card:hover { transform: translateY(-2px); }
    .save-card h5 { margin: 0 0 4px; font-size: 1rem; }
    .save-card small { color: var(--muted); }

    /* UTIL */
    .hidden { display: none !important; }

    .review-summary-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  padding: 20px;
  border-radius: 18px;
}

.summary-item {
  background: var(--card-strong);
  padding: 16px;
  border-radius: 14px;
  border: 1px solid var(--ring-muted);
  box-shadow: var(--shadow-sm);
  transition: transform .2s ease;
}

.summary-item:hover {
    transform: translateY(-3px);
}

.summary-item strong {
  display: block;
  color: var(--muted);
  font-size: 0.9rem;
  margin-bottom: 6px;
}

.summary-item span {
  font-weight: 600;
  font-size: 1.05rem;
  color: var(--accent-2);
  word-wrap: break-word;
}
  </style>
</head>
<body>
  <div class="parallax" aria-hidden="true">
    <div class="blob one"></div>
    <div class="blob two"></div>
  </div>

  <div class="container">
    <header class="hero" data-tilt="true">
      <h1>Quick Recipe Genius</h1>
      <p>Create stunning, tailored recipes in seconds. Choose ingredients & vibes — we’ll plate up something delicious ✨</p>
      <div class="toolbar">
        <span style="color:var(--muted);font-weight:600">Dark Mode</span>
        <label class="switch" aria-label="Toggle dark mode">
          <input id="themeToggle" type="checkbox" />
          <span class="knob"></span>
        </label>
      </div>
    </header>

    <!-- SELECTOR PANELS -->
    <section id="builder" class="panel grid" aria-live="polite" data-tilt="true">
      <div class="section">
        <h3>Ingredients</h3>
        <div class="input-wrapper">
          <input id="ingInput" class="input" placeholder="Type an ingredient..." />
          <button id="addIngBtn" class="add-btn" aria-label="Add Ingredient">+</button>
        </div>
        <div id="ingChips" class="chips" style="margin-top:10px">
          <button class="chip" data-val="Chicken">🍗 Chicken</button>
          <button class="chip" data-val="Eggs">🥚 Eggs</button>
          <button class="chip" data-val="Cheese">🧀 Cheese</button>
          <button class="chip" data-val="Tomato">🍅 Tomato</button>
          <button class="chip" data-val="Rice">🍚 Rice</button>
          <button class="chip" data-val="Tofu">🌱 Tofu</button>
        </div>
      </div>

      <div class="section">
        <h3>Preferences</h3>
        <div class="chips" id="cuisineChips">
          <button class="chip" data-val="Italian">Italian</button>
          <button class="chip" data-val="Mexican">Mexican</button>
          <button class="chip" data-val="Indian">Indian</button>
          <button class="chip" data-val="Thai">Thai</button>
          <button class="chip" data-val="Japanese">Japanese</button>
          <button class="chip" data-val="Mediterranean">Mediterranean</button>
        </div><br>
         <h3>Meal Type</h3>
        <div class="chips" style="margin-top:12px" id="mealChips">
         <button class="chip" data-val="Breakfast">Breakfast</button>
          <button class="chip" data-val="Lunch">Lunch</button>
          <button class="chip" data-val="Dinner">Dinner</button>
          <button class="chip" data-val="Dessert">Dessert</button>
        </div>
      </div>

      <div class="section">
        <h3>Details</h3>
        <div class="chips" id="servingChips">
          <button class="chip" data-val="1-2">1-2</button>
          <button class="chip" data-val="3-4">3-4</button>
          <button class="chip" data-val="5-6">5-6</button>
          <button class="chip" data-val="7+">7+</button>
        </div>
        <div class="chips" style="margin-top:12px" id="timeChips">
          <button class="chip" data-val="< 30 min">< 30 min</button>
          <button class="chip" data-val="30-60 min">30-60 min</button>
          <button class="chip" data-val="> 60 min">> 60 min</button>
        </div>
        <div class="chips" style="margin-top:12px" id="diffChips">
          <button class="chip" data-val="Easy">Easy</button>
          <button class="chip" data-val="Medium">Medium</button>
          <button class="chip" data-val="Hard">Hard</button>
        </div>
      </div>

      <div class="section">
        <h3>Dietary</h3>
        <div class="chips" id="dietChips">
          <button class="chip" data-val="Vegan">Vegan</button>
          <button class="chip" data-val="Vegetarian">Vegetarian</button>
          <button class="chip" data-val="Gluten-Free">Gluten-Free</button>
          <button class="chip" data-val="Keto">Keto</button>
        </div>
      </div>

      <div class="actions" style="grid-column:1/-1">
        <button id="surpriseBtn" class="btn alt">✨ Surprise Me</button>
        <button id="createBtn" class="btn">🍽️ Create Recipe</button>
        <button id="clearBtn" class="btn violet">🧹 Clear Selections</button>
      </div>
    </section>

    <!-- REVIEW SELECTIONS -->
    <section id="review" class="panel hidden" data-tilt="true">
      <div class="section">
        <div style="text-align:center; margin-bottom: 24px;">
          <h3 style="font-family: Poppins, Inter; font-size: 1.5rem; letter-spacing: .2px; margin-bottom: 8px; border-bottom: none;">Confirm Your Recipe</h3>
          <p style="color: var(--muted); max-width: 500px; margin: auto;">One last look before we fire up the stove! Make sure your selections are just right.</p>
        </div>
        <div id="reviewSummary" class="review-summary-grid">
            <!-- Selections will be populated here by JS -->
        </div>
        <div class="actions" style="grid-template-columns: 1fr 1fr; max-width: 480px; margin: 24px auto 0;">
            <button id="editBtn" class="btn alt">✏️ Back to Builder</button>
            <button id="confirmBtn" class="btn">🔥 Let's Cook!</button>
        </div>
      </div>
    </section>
  </div>

  <script>
    /* ===============================
       THEME TOGGLE
    =================================*/
    const themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('change', () => {
      document.documentElement.setAttribute('data-theme', themeToggle.checked ? 'dark' : 'light');
      localStorage.setItem('qrg-theme', themeToggle.checked ? 'dark' : 'light');
    });
    (function initTheme(){
      const stored = localStorage.getItem('qrg-theme');
      const dark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
      document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
      themeToggle.checked = dark;
    })();

    /* ===============================
       UI/UX ENHANCEMENTS
    =================================*/
    const parallax = document.querySelector('.parallax');
    window.addEventListener('mousemove', (e)=>{
      const x = (e.clientX / window.innerWidth - 0.5) * 30;
      const y = (e.clientY / window.innerHeight - 0.5) * 30;
      parallax.style.transform = `translate(${x}px, ${y}px)`;
    });

    function attachTilt(el){
      const max = 10; // deg
      el.addEventListener('mousemove', (ev)=>{
        const r = el.getBoundingClientRect();
        const px = (ev.clientX - r.left) / r.width - 0.5;
        const py = (ev.clientY - r.top) / r.height - 0.5;
        el.style.transform = `rotateY(${px*max}deg) rotateX(${-py*max}deg)`;
      });
      el.addEventListener('mouseleave', ()=>{
        el.style.transform = 'rotateY(0) rotateX(0)';
      });
    }
    document.querySelectorAll('[data-tilt="true"]').forEach(attachTilt);

    /* ===============================
       CORE LOGIC
    =================================*/
    const builder = document.getElementById('builder');
    const review = document.getElementById('review');
    const ingInput = document.getElementById('ingInput');

    function show(el){ el.classList.remove('hidden'); el.style.display = 'grid'; }
    function hide(el){ el.style.display = 'none'; el.classList.add('hidden'); }

    // Chip selection
    function toggleChip(e){
      const chip = e.target.closest('.chip');
      if(!chip) return;
      chip.classList.toggle('selected');
    }
    function addRipplePosition(e){
      const r = e.currentTarget.getBoundingClientRect();
      e.currentTarget.style.setProperty('--x', (e.clientX - r.left) + 'px');
      e.currentTarget.style.setProperty('--y', (e.clientY - r.top) + 'px');
    }
    document.querySelectorAll('.chip, .btn').forEach(c => {
      c.addEventListener('mousedown', addRipplePosition);
      if (c.classList.contains('chip')) {
        c.addEventListener('click', toggleChip);
      }
    });

    // Add ingredient from input
    ingInput.addEventListener('keydown', (e)=>{
      if(e.key==='Enter' && ingInput.value.trim()){
        const val = ingInput.value.trim();
        const btn = document.createElement('button');
        btn.className = 'chip'; btn.dataset.val = val; btn.textContent = val;
        btn.addEventListener('click', toggleChip); btn.addEventListener('mousedown', addRipplePosition);
        document.getElementById('ingChips').appendChild(btn);
        ingInput.value = '';
      }
    });

    // Collect all selections
    function vals(containerId){
      return Array.from(document.querySelectorAll('#'+containerId+' .chip.selected')).map(x => x.dataset.val);
    }
    function collectSelections(){
      return {
        ings: vals('ingChips'),
        cuisine: vals('cuisineChips')[0] || 'Any',
        meal: vals('mealChips')[0] || 'Any',
        servings: vals('servingChips')[0] || 'Any',
        time: vals('timeChips')[0] || 'Any',
        diff: vals('diffChips')[0] || 'Any',
        diet: vals('dietChips')
      };
    }

    // Review and Redirect logic
    function showReview() {
      const sel = collectSelections();
      const summaryDiv = document.getElementById('reviewSummary');
      const items = [
        { label: 'Ingredients', value: sel.ings.length > 0 ? sel.ings.join(', ') : 'Any' },
        { label: 'Cuisine', value: sel.cuisine },
        { label: 'Meal Type', value: sel.meal },
        { label: 'Servings', value: sel.servings },
        { label: 'Cooking Time', value: sel.time },
        { label: 'Difficulty', value: sel.diff },
        { label: 'Dietary', value: sel.diet.length > 0 ? sel.diet.join(', ') : 'None' }
      ];
      summaryDiv.innerHTML = items.map(item => `
        <div class="summary-item">
          <strong>${item.label}</strong>
          <span>${item.value}</span>
        </div>
      `).join('');
      hide(builder);
      show(review);
    }

    function redirectToResult(isSurprise) {
      let selections = {};
      if (!isSurprise) {
        selections = collectSelections();
      }
      const encodedSelections = encodeURIComponent(JSON.stringify(selections));
      window.location.href = `recipe_result.php?selections=${encodedSelections}`;
    }

    // Button event listeners
    document.getElementById('createBtn').addEventListener('click', showReview);
    document.getElementById('surpriseBtn').addEventListener('click', () => redirectToResult(true));
    document.getElementById('clearBtn').addEventListener('click', () => {
        document.querySelectorAll('.chip.selected').forEach(el=>el.classList.remove('selected'));
        ingInput.value = '';
    });
    document.getElementById('editBtn').addEventListener('click', () => {
      hide(review);
      show(builder);
    });
    document.getElementById('confirmBtn').addEventListener('click', () => redirectToResult(false));

  </script>
</body>
</html>


