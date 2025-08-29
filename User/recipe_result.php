<?php
include("C:/xampp/htdocs/ChefAI/User/navigation.php");

// Get selections from URL
$selections_json = isset($_GET['selections']) ? urldecode($_GET['selections']) : '[]';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Preparing Your Recipe...</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <style>
    /* =======================================
       THEME: ELEGANT CULINARY JOURNAL
    ==========================================*/
    :root {
      --bg: #fdfdfd;
      --bg-alt: #f7f9f7;
      --text-primary: #333d29; /* Dark, earthy green-black */
      --text-secondary: #656d4a; /* Muted olive green */
      --accent: #a3b18a; /* Soft, elegant green */
      --accent-dark: #588157; /* Richer green for highlights */
      --border-color: #e9ecef;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      --font-serif: 'Playfair Display', serif;
      --font-sans: 'Roboto', sans-serif;
    }
    * { box-sizing: border-box; }
    body {
      padding-top: 80px;
      background-color: var(--bg);
      font-family: var(--font-sans);
      color: var(--text-primary);
      line-height: 1.8;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }
    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 40px 20px;
    }

    /* ===============================
       LOADER: REMAINS THE SAME (IT'S GREAT!)
    ==========================================*/
    .loader-container {
      display: grid;
      place-items: center;
      padding: 80px 20px;
      text-align: center;
    }
    .knife-loader {
      width: 150px; height: 50px; position: relative;
      animation: slide-in 1.5s ease-out forwards;
    }
    .knife-loader svg { width: 100%; height: auto; fill: var(--text-secondary); }
    .gleam {
      position: absolute; top: 0; left: 0; width: 20px; height: 100%;
      background: linear-gradient(to right, transparent 0%, #ffffff 50%, transparent 100%);
      animation: gleam 2.5s infinite; opacity: 0.8;
    }
    .loader-text {
      font-family: var(--font-serif); font-size: 1.3rem;
      color: var(--text-secondary); margin-top: 15px; opacity: 0;
      animation: fade-in 1s 1s forwards;
    }
    @keyframes slide-in { from { transform: translateX(-100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes gleam { 0% { transform: translateX(0) skewX(-30deg); } 100% { transform: translateX(150px) skewX(-30deg); } }
    @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }

    /* ===============================
       RESULT: ELEGANT & VISUALLY RICH
    ==========================================*/
    #result { display: none; }
    .recipe-journal {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.8s ease-out, transform 0.6s ease-out;
    }
    .recipe-journal.visible { opacity: 1; transform: translateY(0); }
    
    .recipe-main-image {
      width: 100%; height: 450px; object-fit: cover;
      border-radius: 16px; margin-bottom: 40px;
      box-shadow: var(--shadow);
      transition: transform 0.4s ease;
    }
    .recipe-main-image:hover { transform: scale(1.03); }

    .recipe-header { text-align: center; margin-bottom: 40px; }
    .recipe-title {
      font-family: var(--font-serif);
      font-size: clamp(2.5rem, 6vw, 3.5rem);
      line-height: 1.1; margin: 0 0 15px;
      color: var(--text-primary);
    }
    .recipe-description {
      font-size: 1.15rem; color: var(--text-secondary);
      max-width: 700px; margin: 0 auto;
    }
    
    .meta-bar {
      display: flex; justify-content: center; gap: 30px;
      flex-wrap: wrap; padding: 25px; margin: 40px 0;
      background-color: var(--bg-alt);
      border-radius: 12px;
      border-top: 1px solid var(--border-color);
      border-bottom: 1px solid var(--border-color);
    }
    .meta-item {
      display: flex; align-items: center; gap: 12px;
      color: var(--text-primary); text-align: center;
    }
    .meta-item svg { width: 28px; height: 28px; fill: var(--accent-dark); }
    .meta-item span { font-weight: 500; font-size: 1rem; }
    
    .recipe-body {
      display: grid; grid-template-columns: 1fr; gap: 50px;
      margin-top: 50px;
    }
    @media (min-width: 768px) { .recipe-body { grid-template-columns: 3fr 5fr; } }
    
    .recipe-body h3 {
      font-family: var(--font-serif); font-size: 1.8rem;
      margin: 0 0 20px; padding-bottom: 15px;
      border-bottom: 3px solid var(--accent);
      color: var(--accent-dark);
    }
    
    .ingredients-list { list-style: none; padding: 0; }
    .ingredients-list li {
      display: flex; align-items: center; gap: 15px;
      margin-bottom: 15px; cursor: pointer;
      font-size: 1.05rem;
    }
    .ingredients-list li::before {
      content: ''; width: 22px; height: 22px;
      border: 2px solid var(--border-color);
      background-color: #fff;
      border-radius: 5px; flex-shrink: 0;
      transition: all 0.2s ease;
      position: relative;
    }
    .ingredients-list li.checked { color: var(--text-secondary); text-decoration: line-through; }
    .ingredients-list li.checked::before {
      background-color: var(--accent);
      border-color: var(--accent);
    }
    .ingredients-list li.checked::after { /* The checkmark */
      content: '';
      position: absolute;
      left: 7px; top: 2px;
      width: 6px; height: 12px;
      border: solid white;
      border-width: 0 3px 3px 0;
      transform: rotate(45deg);
    }
    
    .instructions-list { list-style: none; padding-left: 45px; counter-reset: instruction-counter; }
    .instructions-list li {
      position: relative; margin-bottom: 25px; line-height: 1.8;
    }
    .instructions-list li::before {
      counter-increment: instruction-counter; content: counter(instruction-counter);
      position: absolute; left: -45px; top: -2px;
      width: 32px; height: 32px; background: var(--accent-dark);
      color: white; border-radius: 50%; display: grid;
      place-items: center; font-weight: 500; font-family: var(--font-serif);
    }

    .notes-section {
      background-color: var(--bg-alt);
      border-left: 5px solid var(--accent);
      padding: 25px;
      border-radius: 8px;
      margin-top: 30px;
    }
    .notes-section h3 {
      border-bottom: none;
      padding-bottom: 0;
      margin-bottom: 15px;
    }
    .notes-section ul {
      padding-left: 20px;
      margin: 0;
      color: var(--text-secondary);
    }

    .recipe-actions {
      text-align: center; margin-top: 60px;
      padding-top: 40px; border-top: 1px solid var(--border-color);
      display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;
    }
    .btn {
      text-decoration: none; border: 2px solid var(--accent-dark);
      background: var(--accent-dark); color: white; border-radius: 50px;
      padding: 14px 35px; font-weight: 500; font-size: 1rem;
      cursor: pointer; transition: all .3s ease;
      display: inline-flex; align-items: center; gap: 8px;
    }
    .btn.btn-secondary {
      background: transparent;
      color: var(--accent-dark);
    }
    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .btn svg { width: 20px; height: 20px; fill: currentColor; }
  </style>
</head>
<body>
  <div class="container">
    <div id="loader" class="loader-container">
      <div class="knife-loader">
        <svg viewBox="0 0 100 30"><path d="M99.5 10a9.5 9.5 0 00-9.5-9.5H10A10 10 0 000 10v10a10 10 0 0010 10h80a10 10 0 0010-10v-2.5a2.5 2.5 0 00-5 0V20a5 5 0 01-5 5H10a5 5 0 01-5-5V10a5 5 0 015-5h80a5 5 0 014.5 2.5 2.5 2.5 0 004-3z"></path><rect class="gleam" width="10" height="30"></rect></svg>
      </div>
      <div id="loaderText" class="loader-text">Sharpening the knives...</div>
    </div>

    <section id="result">
      <!-- The Modern Chef's Journal will be injected here -->
    </section>
  </div>

  <script>
    const loader = document.getElementById('loader');
    const resultSection = document.getElementById('result');
    const loaderText = document.getElementById('loaderText');

    const loaderMessages = [
      'Sourcing the finest ingredients...',
      'Prepping the workstation...',
      'Writing down the details...',
      'Your recipe is ready!'
    ];

    function fillRecipe(data) {
      document.title = data.title + ' - A ChefAI Recipe';
      const imageUrl = 'https://www.tasteofhome.com/wp-content/uploads/2021/09/indian-food-GettyImages-1127563435-MLedit-FT.jpg';

      const timeIcon = `<svg viewBox="0 0 24 24"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path><path d="M13 7h-2v6h6v-2h-4V7z"></path></svg>`;
      const servingsIcon = `<svg viewBox="0 0 24 24"><path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path></svg>`;
      const difficultyIcon = `<svg viewBox="0 0 24 24"><path d="M20 19h-3V5h3v14zM4 19h3V5H4v14zM12 19h3V5h-3v14z"></path></svg>`;

      // --- FIX: Handle complex ingredient and instruction objects from AI ---
      const ingredientsHtml = (data.ingredients || []).map(ing => {
        if (typeof ing === 'object' && ing.item) {
          return `<li><strong>${ing.item}:</strong> ${ing.quantity || ''} <em>${ing.notes || ''}</em></li>`;
        }
        return `<li>${ing}</li>`; // Fallback f or simple string ingredients
      }).join('');

      const instructionsHtml = (data.instructions || []).map(instr => {
        if (typeof instr === 'object' && instr.description) {
          return `<li>${instr.description}</li>`;
        }
        return `<li>${instr}</li>`; // Fallback for simple string instructions
      }).join('');

      let chefTipsHtml = '';
      if (data.chefTips && data.chefTips.length > 0) {
        chefTipsHtml = `
        <div class="notes-section">
            <h3>Chef's Notes</h3>
            <ul>
              ${data.chefTips.map(tip => `<li>${tip}</li>`).join('')}
            </ul>
        </div>`;
      }

      resultSection.innerHTML = `
      <div class="recipe-journal" id="recipeJournal">
        <img src="${imageUrl}" alt="${data.title}" class="recipe-main-image">
        <header class="recipe-header">
          <h1 class="recipe-title">${data.title || 'Recipe Title Not Found'}</h1>
          <p class="recipe-description">${data.description || ''}</p>
        </header>
        <div class="meta-bar">
          <div class="meta-item">${timeIcon}<span>${data.time || 'N/A'}</span></div>
          <div class="meta-item">${servingsIcon}<span>${data.servings || 'N/A'}</span></div>
          <div class="meta-item">${difficultyIcon}<span>${data.difficulty || 'N/A'}</span></div>
        </div>
        <div class="recipe-body">
          <div class="ingredients-section">
            <h3>Ingredients</h3>
            <ul class="ingredients-list">${ingredientsHtml}</ul>
          </div>
          <div class="instructions-section">
            <h3>Instructions</h3>
            <ol class="instructions-list">${instructionsHtml}</ol>
            ${chefTipsHtml}
          </div>
        </div>
        <div class="recipe-actions">
          <a href="generate_recipe.php" class="btn">← Create a New Recipe</a>
        </div>
      </div>`;
    }

    function setupInteractivity() {
      const journal = document.getElementById('recipeJournal');
      if (!journal) return;

      journal.classList.add('visible');

      const ingredients = journal.querySelectorAll('.ingredients-list li');
      ingredients.forEach(item => {
        item.addEventListener('click', () => {
          item.classList.toggle('checked');
        });
      });
    }

    document.addEventListener('DOMContentLoaded', () => {
      const selections = JSON.parse('<?php echo $selections_json; ?>');

      let i = 0;
      const tick = setInterval(() => {
        i = (i + 1) % loaderMessages.length;
        loaderText.textContent = loaderMessages[i];
      }, 2000);

      fetch('../API/generate_recipe_service.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(selections)
      })
      .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw new Error(JSON.stringify(err, null, 2)); });
        }
        return response.json();
      })
      .then(data => {
        clearInterval(tick);
        loader.style.display = 'none';
        resultSection.style.display = 'block';
        fillRecipe(data);
        setupInteractivity();
      })
      .catch(error => {
        clearInterval(tick);
        console.error('Error:', error);
        loader.innerHTML = `<div class="loader-text" style="animation: none; opacity: 1;">Could not prepare the recipe.<br><pre style="text-align: left; max-width: 800px; margin: 10px auto; padding: 10px; background: #fff8f8; border: 1px solid #ffbaba; color: #d8000c; white-space: pre-wrap;">${error.message}</pre></div>`;
      });
    });
  </script>
</body>
</html>