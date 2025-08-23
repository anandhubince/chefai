<?php
include("C:/xampp/htdocs/ChefAI/User/navigation.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Saved Recipes</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: linear-gradient(135deg, #f8fff8, #e8f5e9);
      color: #222;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      font-family: 'Inter', sans-serif;
    }

    header {
      margin-top: 6rem; /* keeps below fixed navbar */
      text-align: center;
      padding: 1rem;
    }

    header h1 {
      font-size: 2rem;
      font-weight: 700;
      color: #2e7d32;
      margin-bottom: 0.5rem;
    }

    header nav .btn {
      background: #4CAF50;
      color: white;
      padding: 0.6rem 1.4rem;
      border-radius: 1.2rem;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
      display: inline-block;
      margin-top: 0.5rem;
    }

    header nav .btn:hover {
      background: #43a047;
      transform: translateY(-2px);
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      padding: 2rem;
    }

    .recipes {
      width: 100%;
      max-width: 1100px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
    }

    .card {
      background: rgba(255, 255, 255, 0.6);
      border: 1px solid rgba(76, 175, 80, 0.4);
      border-radius: 1.5rem;
      padding: 2rem;
      backdrop-filter: blur(12px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .card:hover {
      transform: translateY(-6px) scale(1.02);
      box-shadow: 0 12px 28px rgba(76, 175, 80, 0.25);
    }

    .card h2 {
      font-size: 1.6rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #1b5e20;
    }

    .card p {
      font-size: 1rem;
      margin-bottom: 1.5rem;
      color: #333;
    }

    .actions {
      display: flex;
      gap: 1rem;
      justify-content: flex-end;
    }

    .btn {
      background: #4CAF50;
      color: white;
      padding: 0.6rem 1.2rem;
      border-radius: 1rem;
      text-decoration: none;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background: #43a047;
      transform: translateY(-3px);
    }

    /* Differentiate Delete button */
    .btn.delete {
      background: #e53935;
    }
    .btn.delete:hover {
      background: #d32f2f;
    }
  </style>
</head>
<body>
  <header>
    <h1>📖 Your Saved Recipes</h1>
    <nav>
      <a href="generate_recipe.php" class="btn">🏠 Back to Generator</a>
    </nav>
  </header>

  <main>
    <div class="recipes" id="recipes"></div>
  </main>

  <script>
    const recipesDiv = document.getElementById('recipes');
    const list = JSON.parse(localStorage.getItem('recipes')||'[]');

    if(list.length===0){
      recipesDiv.innerHTML = `<p style="font-size:1.2rem; color:#555; text-align:center;">✨ No saved recipes yet. Go generate one!</p>`;
    } else {
      list.forEach((r,idx)=>{
        const card = document.createElement('div');
        card.className = 'card';
        card.innerHTML = `
          <h2>${r.title}</h2>
          <p><strong>Time:</strong> ${r.time} | <strong>Servings:</strong> ${r.servings}</p>
          <div class="actions">
            <button class="btn view">👀 View</button>
            <button class="btn delete">🗑 Delete</button>
          </div>
        `;
        card.querySelector('.view').onclick=()=>{
          localStorage.setItem('viewRecipe', JSON.stringify(r));
          window.location.href="view_recipe.php";
        };
        card.querySelector('.delete').onclick=()=>{
          const updated = list.filter(x=>x.id!==r.id);
          localStorage.setItem('recipes', JSON.stringify(updated));
          location.reload();
        };
        recipesDiv.appendChild(card);
      });
    }
  </script>
</body>
</html>
