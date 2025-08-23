<?php
include("C:/xampp/htdocs/ChefAI/User/navigation.php");

// Get selections from URL
$selections_json = isset($_GET['selections']) ? urldecode($_GET['selections']) : '[]';
// It's safer to pass the raw selections and let the API build the prompt
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Generating Your Recipe...</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />
  <style>
    /* Using a subset of styles from the main page for the loader and result */
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
      --shadow-lg: 0 18px 52px rgba(2, 6, 23, .15);
      --shadow-sm: 0 6px 20px rgba(2, 6, 23, .08);
      --ring-muted: rgba(148,163,184,.25);
      --glass-blur: blur(18px) saturate(140%);
    }
    body {
      padding-top: 80px; background: var(--bg);
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      color: var(--text); line-height: 1.5;
    }
    .container { max-width: 800px; margin: 0 auto; padding: 20px; }
    .panel {
      background: var(--card); border: var(--glass-stroke); border-radius: 24px;
      box-shadow: var(--shadow-lg); backdrop-filter: var(--glass-blur);
    }
    /* Loader styles (copied from generate_recipe.php) */
    .loader-wrap { display: grid; place-items: center; padding: 26px; }
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
    /* Result styles */
    #result { display: none; padding: 20px; }
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
    ul.fancy li, ol.fancy li { margin: 6px 0; }
    .actions { display: grid; grid-template-columns: repeat(2,1fr); gap: 14px; padding: 18px 0 0; }
    .btn { text-decoration: none; text-align: center; position: relative; overflow: hidden; border: none; cursor: pointer; border-radius: 16px; padding: 14px 18px; font-weight: 700; background: linear-gradient(90deg, #16a34a, #22c55e 40%, #3b82f6); color: white; box-shadow: 0 12px 40px rgba(34,197,94,.28); }
    .btn.alt { background: linear-gradient(90deg, #0ea5e9, #8b5cf6 60%, #22d3ee); }
    .btn.violet { background: linear-gradient(90deg, #8b5cf6, #22d3ee); }
  </style>
</head>
<body>
  <div class="container">
    <!-- LOADER -->
    <section id="loader" class="panel loader-wrap">
      <div>
        <div class="chef">
          <div class="pan"><div class="handle"></div></div>
          <div class="steam"></div><div class="steam"></div><div class="steam"></div>
          <div class="egg"></div>
        </div>
        <div id="loaderText" class="loader-text">Generating your masterpiece...</div>
      </div>
    </section>

    <!-- RESULT -->
    <section id="result" class="panel">
      <!-- Recipe content will be injected here by JavaScript -->
    </section>
  </div>

  <script>
    const loader = document.getElementById('loader');
    const resultSection = document.getElementById('result');
    const loaderText = document.getElementById('loaderText');

    const loaderMessages = [
      'Consulting ancient cookbooks...',
      'Chopping veggies with precision...',
      'Simmering sauces to perfection...',
      'Asking the chef for a secret touch...',
      'Plating your masterpiece...'
    ];

    // Function to fill recipe data into the result section
    function fillRecipe(data) {
        document.title = data.title + ' - Recipe';
        let nutritionHtml = '';
        if (data.nutrition) {
            nutritionHtml = `
            <div class="card" style="margin-top:14px">
              <h4>Nutrition (per serving)</h4>
              <!-- Nutrition rings would go here if needed -->
            </div>`;
        }

        resultSection.innerHTML = `
        <div class="recipe">
            <div class="title">${data.title}</div>
            <div class="meta">
              <div class="meta-card"><small>Time</small><b>${data.time}</b></div>
              <div class="meta-card"><small>Servings</small><b>${data.servings}</b></div>
              <div class="meta-card"><small>Difficulty</small><b>${data.difficulty}</b></div>
            </div>
            <div class="cols">
              <div class="card">
                <h4>Ingredients</h4>
                <ul class="fancy">${data.ingredients.map(i => `<li>${i}</li>`).join('')}</ul>
              </div>
              <div class="card">
                <h4>Instructions</h4>
                <ol class="fancy">${data.instructions.map(i => `<li>${i}</li>`).join('')}</ul>
              </div>
            </div>
            ${nutritionHtml}
            <div class="actions">
                <a href="generate_recipe.php" class="btn alt">↩️ Start Over</a>
                <button onclick="window.print()" class="btn violet">🖨️ Print</button>
            </div>
        </div>`;
    }

    // On page load, fetch the recipe
    document.addEventListener('DOMContentLoaded', () => {
        const selections = JSON.parse('<?php echo $selections_json; ?>');

        let i = 0;
        const tick = setInterval(() => {
            i = (i + 1) % loaderMessages.length;
            loaderText.textContent = loaderMessages[i];
        }, 1500);

        fetch('../API/generate_recipe_service.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(selections)
        })
        .then(response => {
            if (!response.ok) { throw new Error('API request failed'); }
            return response.json();
        })
        .then(data => {
            clearInterval(tick);
            loader.style.display = 'none';
            fillRecipe(data);
            resultSection.style.display = 'block';
        })
        .catch(error => {
            clearInterval(tick);
            console.error('Error:', error);
            loaderText.textContent = 'Sorry, we couldn\'t generate a recipe. Please try again.';
            // You might want to add a "Try Again" button here
        });
    });
  </script>
</body>
</html>