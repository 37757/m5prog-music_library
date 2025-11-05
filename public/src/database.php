<?php

// haal de configuratie op door het config.php bestand te laden.
require_once('src/config.php');

// Maak een database verbinding waarbij je de constanten uit de .env file gebruikt
$connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
?>