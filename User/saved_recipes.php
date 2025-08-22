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
      background: #f8fff8;
      color: #222;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      font-family: 'Inter', sans-serif;
    }

    main {
      margin-top: 6rem; /* Ensures content is below fixed navbar */
      flex: 1;
      display: flex;
      justify-content: center;
      padding: 2rem;
    }

    .recipes {
      width: 100%;
      max-width: 800px;
    }

    .card {
      background: white;
      border: 2px solid #4CAF50;
      border-radius: 1.2rem;
      padding: 2rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .card h2 {
      font-size: 1.4rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #2e7d32;
    }

    .card p {
      font-size: 1rem;
      margin-bottom: 1rem;
      color: #444;
    }

    .actions {
      display: flex;
      gap: 1rem;
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
      transition: 0.3s;
    }

    .btn:hover {
      background: #43a047;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>
  <header>
    <h1>📖 Saved Recipes</h1>
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
      recipesDiv.innerHTML = `<p>No saved recipes yet.</p>`;
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