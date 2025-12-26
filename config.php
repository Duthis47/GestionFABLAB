<?php 

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define('BASE_URL', 'https://localhost/GestionFABLAB/public_html/');
} else {
    define('BASE_URL', 'http://10.3.17.217/');
}