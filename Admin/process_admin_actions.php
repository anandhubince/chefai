<?php
require_once '../session_start.php';
require_once '../functions.php';
require_once '../db_connection.php';

if (!is_logged_in() || !is_admin()) {
    redirect('/login.php');
}

// This file will handle form submissions for admin actions
// (e.g., deleting a user)
