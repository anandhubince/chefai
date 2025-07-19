<?php
/**
 * General Configuration
 */

// The base URL of your application.
// IMPORTANT: Make sure this is correct for your environment.
define('SITE_URL', 'http://localhost/ChefAI');

/**
 * API Configuration
 * For simplicity in this project, we are defining them as constants.
 * In a production environment, use a more secure method like environment variables.
 */

// IMPORTANT: Replace 'YOUR_API_KEY' with your actual Google Gemini API key.
define('AI_API_KEY', 'YOUR_API_KEY');
define('AI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . AI_API_KEY);