<?php
session_start();
require 'config.php';

// Check of gebruiker is ingelogd, anders redirect naar inlog
if (!isset($_SESSION['naam'])) {
    header('Location: inlog.php');
    exit;
}

// View laden
include "view/home_view.php";
