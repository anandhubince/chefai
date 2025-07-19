<?php
require_once 'config.php';
require_once 'db_connection.php';

function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit();
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function generate_shopping_list($ingredients_text) {
    $ingredients = explode(",", $ingredients_text);
    $shopping_list = "";
    foreach ($ingredients as $ingredient) {
        $shopping_list .= trim($ingredient) . "\n";
    }
    return $shopping_list;
}