document.addEventListener('DOMContentLoaded', function() {
    const recipeForm = document.getElementById('recipe-form');
    if (recipeForm) {
        recipeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const ingredients = document.getElementById('ingredients').value;
            const recipeResult = document.getElementById('recipe-result');
            recipeResult.innerHTML = '<p>Generating recipe...</p>';

            fetch('../API/ai_recipe_service.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ingredients: ingredients })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    recipeResult.innerHTML = `
                        <h2>Recipe</h2>
                        <pre>${data.recipe_text}</pre>
                        <button id="save-recipe-btn" class="btn">Save Recipe</button>
                    `;
                } else {
                    recipeResult.innerHTML = `<p class="error">${data.error}</p>`;
                }
            })
            .catch(error => {
                recipeResult.innerHTML = `<p class="error">An error occurred: ${error}</p>`;
            });
        });
    }
});
