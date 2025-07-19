<?php
require_once 'session_start.php';
require_once 'functions.php';

session_unset();
session_destroy();

redirect('/index.php');
