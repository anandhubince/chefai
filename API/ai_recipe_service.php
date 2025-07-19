<?php
require_once '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $input_data = json_decode(file_get_contents('php://input'), true);
   $ingredients = $input_data['ingredients']; // Example: "chicken, bell peppers, rice"

   // Simplified prompt based on available tables
   $prompt = "Generate a recipe using the following ingredients: " . $ingredients . ". Provide the recipe name, formatted ingredient list, step-by-step instructions, and estimated cooking time. If possible, suggest serving size and difficulty. Output as plain text.";

   $chatHistory = [['role' => 'user', 'parts' => [['text' => $prompt]]]];
   $payload = ['contents' => $chatHistory];

   $ch = curl_init(AI_API_URL);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
   curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

   $response = curl_exec($ch);
   if (curl_errno($ch)) {
       echo json_encode(['error' => 'cURL Error: ' . curl_error($ch)]);
       exit();
   }
   curl_close($ch);

   $result = json_decode($response, true);

   if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
       $ai_response_text = $result['candidates'][0]['content']['parts'][0]['text'];
       // You will need to parse this plain text response into structured data
       // for recipeName, ingredients, instructions, cooking_time, etc.
       // This might involve simple string parsing or a more robust text-to-structure parser.
       echo json_encode(['success' => true, 'recipe_text' => $ai_response_text]);
   } else {
       echo json_encode(['error' => 'Failed to get recipe from AI.', 'details' => $result]);
   }
} else {
   echo json_encode(['error' => 'Invalid request method.']);
}
?>