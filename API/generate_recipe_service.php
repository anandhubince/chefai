<?php
header('Content-Type: application/json');

sleep(5); 

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

// --- DYNAMICALLY GENERATE A FAKE RECIPE BASED ON NEW ADVANCED INPUT ---

$ings = $data['ings'] ?? [];
$exclude = $data['exclude'] ?? [];
$cuisine = $data['cuisine'] ?? 'Any';
$diet = $data['diet'] ?? [];
$methods = $data['methods'] ?? [];

$title = "Advanced " . ($cuisine !== 'Any' ? $cuisine : 'Fusion') . " Creation";
if (!empty($ings)) {
    $title = "Custom " . $ings[0] . " Dish";
}

$instructions = [
    "Begin by preparing your ingredients: " . (!empty($ings) ? implode(', ', $ings) : 'all necessary items') . ".",
    "Ensure you avoid using any " . (!empty($exclude) ? implode(', ', $exclude) : 'excluded items') . ".",
    "This recipe is specifically designed to be " . (!empty($diet) ? implode(', ', $diet) : 'delicious') . ".",
    "The primary cooking method will be " . (!empty($methods) ? implode(', ', $methods) : 'a secret technique') . ".",
    "Follow all steps carefully and serve when ready."
];

$generatedRecipe = [
    'title' => $title,
    'time' => $data['time'] ?? '45 min',
    'servings' => '4',
    'difficulty' => $data['diff'] ?? 'Medium',
    'ingredients' => array_merge($ings, [
        '1 dash of innovation',
        '2 cups of fresh air'
    ]),
    'instructions' => $instructions,
    'nutrition' => [
        'calories' => rand(300, 800),
        'protein' => rand(15, 50),
        'carbs' => rand(30, 100),
        'fat' => rand(10, 40)
    ]
];

echo json_encode($generatedRecipe);
?>