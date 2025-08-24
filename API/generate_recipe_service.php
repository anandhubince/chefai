<?php
/*
 * =====================================================================
 * DEBUGGING-FOCUSED API SCRIPT
 * =====================================================================
 * This script is simplified to ensure it runs and provides clear, 
 * JSON-formatted errors to diagnose the final server configuration issue.
*/

// Force error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// We will always return JSON
header('Content-Type: application/json');

// 1. Check for cURL extension
if (!function_exists('curl_init')) {
    echo json_encode(['error' => 'PHP Configuration Error', 'message' => 'The cURL extension is not enabled in your php.ini. Please enable it and restart Apache.']);
    exit;
}

// 2. Define API key and endpoint
$apiKey = 'AIzaSyDMG74LhQU2h7zB46hqGDz_TMDZCzJVOP8';
$apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key=' . $apiKey;

// 3. Get input from the frontend
$requestBody = file_get_contents('php://input');
$selections = json_decode($requestBody, true);

// 4. Construct the prompt
$prompt = "You are a world-class chef. Generate a complete recipe based on the following criteria.\n\n";
$prompt .= "Cuisine: " . (isset($selections['cuisine']) ? $selections['cuisine'] : 'Any') . ".\n";
$prompt .= "Ingredients: " . (isset($selections['ings']) && !empty($selections['ings']) ? implode(', ', $selections['ings']) : 'Any') . ".\n";
$prompt .= "Dietary Needs: " . (isset($selections['diet']) && !empty($selections['diet']) ? implode(', ', $selections['diet']) : 'None') . ".\n";
$prompt .= "Your response must be a single, clean JSON object with keys: title, description, image, time, servings, difficulty, ingredients, instructions, chefTips.";

// 5. Prepare the data payload for Gemini API
$data = [
    'contents' => [
        [
            'parts' => [
                [
                    'text' => $prompt
                ]
            ]
        ]
    ]
];
$payload = json_encode($data);

// 6. Initialize and execute the cURL request
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypasses SSL verification for local XAMPP. Not for production.

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

// 7. Handle any errors from the cURL request itself
if ($curl_error) {
    echo json_encode(['error' => 'cURL System Error', 'message' => 'The cURL request failed to execute. This is often a network or SSL configuration issue.', 'details' => $curl_error]);
    exit;
}

// 8. Handle non-successful HTTP status codes from the API
if ($httpcode != 200) {
    echo json_encode(['error' => 'API Communication Error', 'message' => 'The Google AI API responded with an error.', 'status_code' => $httpcode, 'api_response' => json_decode($response)]);
    exit;
}

// 9. Process the successful response from the AI
$responseData = json_decode($response, true);
$recipeText = isset($responseData['candidates'][0]['content']['parts'][0]['text']) ? $responseData['candidates'][0]['content']['parts'][0]['text'] : '';

if (empty($recipeText)) {
    echo json_encode(['error' => 'AI Response Format Error', 'message' => 'The AI returned a response, but it was empty or in an unexpected format.']);
    exit;
}

// 10. Clean and return the final JSON from the AI's text response
$recipeText = str_replace('```json', '', $recipeText);
$recipeText = str_replace('```', '', $recipeText);
$recipeText = trim($recipeText);

$recipeJson = json_decode($recipeText, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(['error' => 'AI Response JSON Error', 'message' => 'Failed to decode the recipe JSON from the AI response.', 'raw_response' => $recipeText]);
    exit;
}

echo json_encode($recipeJson);

?>