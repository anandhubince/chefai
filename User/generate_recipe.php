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
    .section h3 { margin: 0 0 12px; font-family: Poppins, Inter; font-size: 1.05rem; letter-spacing: .2px; color: var(--text); }
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
        <input id="ingInput" class="input" placeholder="Type and press Enter… e.g., chicken, pasta" />
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

    <!-- LOADER -->
    <section id="loader" class="panel loader-wrap" aria-hidden="true" data-tilt="true">
      <div>
        <div class="chef">
          <div class="pan"><div class="handle"></div></div>
          <div class="steam"></div><div class="steam"></div><div class="steam"></div>
          <div class="egg"></div>
        </div>
        <div id="loaderText" class="loader-text">Chopping veggies… 🍅</div>
      </div>
    </section>

    <!-- RESULT -->
    <section id="result" class="panel result" aria-live="polite" data-tilt="true">
      <div class="recipe">
        <div class="title" id="rTitle">—</div>
        <div class="meta">
          <div class="meta-card"><small>Time</small><b id="rTime">—</b></div>
          <div class="meta-card"><small>Servings</small><b id="rServings">—</b></div>
          <div class="meta-card"><small>Difficulty</small><b id="rDiff">—</b></div>
        </div>
        <div class="cols">
          <div class="card">
            <h4>Ingredients</h4>
            <ul id="rIngs" class="fancy"></ul>
          </div>
          <div class="card">
            <h4>Instructions</h4>
            <ol id="rSteps" class="fancy"></ol>
          </div>
        </div>
        <div class="card" style="margin-top:14px">
          <h4>Nutrition (per serving)</h4>
          <div class="rings">
            <div class="ring"><div class="circle" style="--val:72"><span id="calories">420kcal</span></div><small>Calories</small></div>
            <div class="ring"><div class="circle" style="--val:58"><span id="protein">22g</span></div><small>Protein</small></div>
            <div class="ring"><div class="circle" style="--val:64"><span id="carbs">48g</span></div><small>Carbs</small></div>
            <div class="ring"><div class="circle" style="--val:40"><span id="fat">14g</span></div><small>Fat</small></div>
          </div>
        </div>
        <div class="actions" style="margin-top:8px">
          <button id="startOverBtn" class="btn alt">↩️ Start Over</button>
          <button id="saveBtn" class="btn">💾 Save</button>
          <button id="copyBtn" class="btn violet">📋 Copy</button>
        </div>
        <div class="actions" style="margin-top:-8px">
          <button id="printBtn" class="btn alt">🖨️ Print</button>
          <button id="shareBtn" class="btn">🔗 Share</button>
          <button id="newBtn" class="btn violet">🎲 New Recipe</button>
        </div>
      </div>
    </section>

    <div id="toast" class="toast" role="status" aria-live="polite">✅ Saved!</div>
    <div id="rain" class="emoji-rain hidden" aria-hidden="true"></div>
  </div>

  <!-- Saved Drawer -->
  <aside id="savedDrawer" class="drawer" aria-hidden="true">
    <header>
      <strong>Saved Recipes</strong>
      <div>
        <button id="exportAll" class="btn alt" style="padding:8px 12px;border-radius:10px">⬇️ Export</button>
        <button id="closeDrawer" class="btn" style="padding:8px 12px;border-radius:10px">✖</button>
      </div>
    </header>
    <div id="savedList" class="list"></div>
  </aside>

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
       PARALLAX + TILT
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
       ELEMENTS
    =================================*/
    const builder = document.getElementById('builder');
    const loader = document.getElementById('loader');
    const loaderText = document.getElementById('loaderText');
    const result = document.getElementById('result');
    const toast = document.getElementById('toast');
    const rain = document.getElementById('rain');

    const rTitle = document.getElementById('rTitle');
    const rTime = document.getElementById('rTime');
    const rServings = document.getElementById('rServings');
    const rDiff = document.getElementById('rDiff');
    const rIngs = document.getElementById('rIngs');
    const rSteps = document.getElementById('rSteps');

    const ingInput = document.getElementById('ingInput');

    const openSaved = document.getElementById('openSaved');
    const savedDrawer = document.getElementById('savedDrawer');
    const closeDrawer = document.getElementById('closeDrawer');
    const savedList = document.getElementById('savedList');

    /* CHIP SELECTORS */
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
    document.querySelectorAll('.chip').forEach(c => {
      c.addEventListener('click', toggleChip);
      c.addEventListener('mousedown', addRipplePosition);
    });

    ingInput.addEventListener('keydown', (e)=>{
      if(e.key==='Enter' && ingInput.value.trim()){
        const val = ingInput.value.trim();
        const btn = document.createElement('button');
        btn.className = 'chip selected'; btn.dataset.val = val; btn.textContent = val;
        btn.addEventListener('click', toggleChip); btn.addEventListener('mousedown', addRipplePosition);
        document.getElementById('ingChips').appendChild(btn);
        ingInput.value = '';
      }
    });

    /* ACTION BUTTONS */
    ['createBtn','surpriseBtn','saveBtn','startOverBtn','copyBtn','printBtn','shareBtn','newBtn','clearBtn','openSaved','closeDrawer','exportAll'].forEach(id=>{
      const el = document.getElementById(id);
      if(el){ el.addEventListener('mousedown', addRipplePosition); }
    });

    document.getElementById('createBtn').addEventListener('click', () => generate(false));
    document.getElementById('surpriseBtn').addEventListener('click', () => generate(true));
    document.getElementById('newBtn').addEventListener('click', () => generate(true));
    document.getElementById('clearBtn').addEventListener('click', clearSelections);

    const loaderMessages = [
      'Chopping veggies… 🍅',
      'Heating the pan… 🔥',
      'Simmering flavors… 🫕',
      'Plating it pretty… 🍽️',
      'Taste testing… 😋'
    ];

    function show(el){ el.classList.remove('hidden'); el.style.display = 'grid'; }
    function hide(el){ el.style.display = 'none'; el.classList.add('hidden'); }

    function vals(containerId){
      return Array.from(document.querySelectorAll('#'+containerId+' .chip.selected')).map(x => x.dataset.val);
    }
    function collectSelections(){
      const ings = Array.from(document.querySelectorAll('#ingChips .chip.selected')).map(x=>x.dataset.val);
      const cuisine = vals('cuisineChips')[0] || 'Any';
      const meal = vals('mealChips')[0] || 'Any';
      const servings = vals('servingChips')[0] || 'Any';
      const time = vals('timeChips')[0] || 'Any';
      const diff = vals('diffChips')[0] || 'Any';
      const diet = vals('dietChips');
      return {ings, cuisine, meal, servings, time, diff, diet};
    }

    function clearSelections(){
      document.querySelectorAll('.chip.selected').forEach(el=>el.classList.remove('selected'));
      ingInput.value = '';
      toastMsg('Selections cleared');
    }

    function generate(isSurprise){
      // clear any leftover animations
      rain.innerHTML = ''; hide(rain); toast.classList.remove('show');

      const sel = collectSelections();
      hide(builder); show(loader);

      // Rotate loader text
      let i = 0; loaderText.textContent = loaderMessages[0];
      const tick = setInterval(()=>{
        i = (i+1) % loaderMessages.length;
        loaderText.textContent = loaderMessages[i];
      }, 900);

      // TODO: Plug your API here. For now we mock a recipe.
      setTimeout(()=>{
        clearInterval(tick);
        hide(loader);
        fillRecipe(mockRecipe(sel, isSurprise));
        revealResult();
      }, 1900 + Math.random()*900);
    }

    function fillRecipe(data){
      rTitle.textContent = data.title;
      rTime.textContent = data.time;
      rServings.textContent = data.servings;
      rDiff.textContent = data.difficulty;

      rIngs.innerHTML = '';
      data.ingredients.forEach((t,idx)=>{
        const li = document.createElement('li'); li.style.setProperty('--i', idx);
        li.textContent = t; rIngs.appendChild(li);
      });
      rSteps.innerHTML = '';
      data.instructions.forEach((t,idx)=>{
        const li = document.createElement('li'); li.style.setProperty('--i', idx);
        li.textContent = t; rSteps.appendChild(li);
      });

      if(data.nutrition){
        document.getElementById('calories').textContent = data.nutrition.calories + 'kcal';
        document.getElementById('protein').textContent = data.nutrition.protein + 'g';
        document.getElementById('carbs').textContent = data.nutrition.carbs + 'g';
        document.getElementById('fat').textContent = data.nutrition.fat + 'g';
      }

      // cache current recipe for Save/Share
      window.__currentRecipe = data;
    }

    function revealResult(){
      result.style.display = 'block';
      result.classList.remove('hidden');
      result.animate([
        { opacity: 0, transform: 'translateY(14px) scale(.98)' },
        { opacity: 1, transform: 'translateY(0) scale(1)' }
      ], { duration: 420, easing: 'cubic-bezier(.2,.7,.2,1)', fill: 'forwards' });
    }

    document.getElementById('startOverBtn').addEventListener('click', ()=>{
      hide(result);
      clearSelections();
      show(builder);
    });

    document.getElementById('saveBtn').addEventListener('click', ()=>{
      if(!window.__currentRecipe){ toastMsg('No recipe yet'); return; }
      // localStorage save
      const list = JSON.parse(localStorage.getItem('qrg-saves')||'[]');
      const id = Date.now();
      list.unshift({ id, ts: new Date().toISOString(), data: window.__currentRecipe });
      localStorage.setItem('qrg-saves', JSON.stringify(list.slice(0,100)));
      renderSaved();

      // Toast
      toastMsg('✅ Saved!');

      // Emoji rain
      rain.innerHTML = '';
      show(rain);
      const EMOJIS = ['🍕','🥗','🍜','🍰','🌮','🍣','🍹'];
      const total = 30;
      for(let i=0;i<total;i++){
        const span = document.createElement('span');
        span.className = 'emoji';
        span.textContent = EMOJIS[Math.floor(Math.random()*EMOJIS.length)];
        span.style.left = Math.random()*100 + 'vw';
        span.style.top = (Math.random()*-20 - 5) + 'vh';
        span.style.animationDuration = (1 + Math.random()*1.5) + 's';
        rain.appendChild(span);
      }
      // Auto clear so it never blocks next generation
      setTimeout(()=>{ rain.classList.add('hidden'); rain.innerHTML=''; }, 2200);
    });

    document.getElementById('copyBtn').addEventListener('click', async ()=>{
      if(!window.__currentRecipe){ toastMsg('Nothing to copy'); return; }
      const t = serializeRecipe(window.__currentRecipe);
      await navigator.clipboard.writeText(t);
      toastMsg('Copied to clipboard');
    });

    document.getElementById('printBtn').addEventListener('click', ()=>{
      window.print();
    });

    document.getElementById('shareBtn').addEventListener('click', async ()=>{
      if(!window.__currentRecipe){ toastMsg('Nothing to share'); return; }
      const data = window.__currentRecipe;
      const text = serializeRecipe(data);
      if(navigator.share){
        try { await navigator.share({ title: data.title, text }); toastMsg('Shared'); } catch(e){ /* ignore */ }
      } else {
        await navigator.clipboard.writeText(text);
        toastMsg('Share not supported — copied');
      }
    });

    document.getElementById('openSaved').addEventListener('click', ()=>{
      savedDrawer.classList.add('open');
      document.getElementById('openSaved').setAttribute('aria-expanded','true');
      renderSaved();
    });
    document.getElementById('closeDrawer').addEventListener('click', ()=>{
      savedDrawer.classList.remove('open');
      document.getElementById('openSaved').setAttribute('aria-expanded','false');
    });

    document.getElementById('exportAll').addEventListener('click', ()=>{
      const list = JSON.parse(localStorage.getItem('qrg-saves')||'[]');
      const blob = new Blob([JSON.stringify(list, null, 2)], { type: 'application/json' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url; a.download = 'recipes.json'; a.click();
      URL.revokeObjectURL(url);
      toastMsg('Exported recipes.json');
    });

    function renderSaved(){
      const list = JSON.parse(localStorage.getItem('qrg-saves')||'[]');
      savedList.innerHTML = '';
      if(!list.length){ savedList.innerHTML = '<p style="color:var(--muted)">No saved recipes yet.</p>'; return; }
      list.forEach(item=>{
        const card = document.createElement('div');
        card.className = 'save-card';
        const date = new Date(item.ts).toLocaleString();
        card.innerHTML = `<h5>${item.data.title}</h5><small>${date} • ${item.data.time} • ${item.data.servings} • ${item.data.difficulty}</small>`;
        card.addEventListener('click', ()=>{
          fillRecipe(item.data);
          revealResult();
          savedDrawer.classList.remove('open');
        });
        // right-click to delete
        card.addEventListener('contextmenu', (ev)=>{
          ev.preventDefault();
          const yes = confirm('Delete this saved recipe?');
          if(yes){
            const next = list.filter(x=>x.id !== item.id);
            localStorage.setItem('qrg-saves', JSON.stringify(next));
            renderSaved();
          }
        });
        savedList.appendChild(card);
      });
    }

    function serializeRecipe(d){
      return `${d.title}\n\nTime: ${d.time}\nServings: ${d.servings}\nDifficulty: ${d.difficulty}\n\nIngredients:\n- ${d.ingredients.join('\n- ')}\n\nInstructions:\n${d.instructions.map((s,i)=>`${i+1}. ${s}`).join('\n')}`;
    }

    function toastMsg(msg){
      toast.textContent = msg; toast.classList.add('show');
      setTimeout(()=> toast.classList.remove('show'), 1600);
    }

    /* ===============================
       MOCK DATA (replace with API)
    =================================*/
    function mockRecipe(sel, isSurprise){
      const base = sel.ings.length ? sel.ings.slice(0,3).join(', ') : 'chef\'s pantry mix';
      const title = isSurprise ? 'Chef\'s Surprise Bowl' : `${sel.cuisine !== 'Any' ? sel.cuisine+' ' : ''}${base} Delight`;
      const servings = sel.servings === 'Any' ? '2' : sel.servings;
      const time = sel.time === 'Any' ? '30-40 min' : sel.time;
      const diff = sel.diff === 'Any' ? 'Easy' : sel.diff;
      return {
        title,
        time,
        servings,
        difficulty: diff,
        ingredients: [
          '2 tbsp olive oil',
          '1 onion, finely chopped',
          '2 cloves garlic, minced',
          `${sel.ings[0] || 'protein of choice'} (250g)`,
          '1 cup tomatoes or sauce',
          'Salt & pepper to taste',
          'Fresh herbs to finish'
        ],
        instructions: [
          'Warm oil in a pan over medium heat.',
          'Sauté onion 3–4 min; add garlic 30 sec.',
          'Add protein; cook until lightly browned.',
          'Stir in tomatoes/sauce; simmer 8–10 min.',
          'Season, garnish, and serve hot.'
        ],
        nutrition: { calories: 420, protein: 22, carbs: 48, fat: 14 }
      };
    }
  </script>
</body>
</html>


