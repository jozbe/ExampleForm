<?php
require_once '../autoloader.php';
// Set the name of the current page
$PAGE = '404';


// Do the rendering of the page
include '../views/header.php';      // This requres the $PAGE variable
include '../views/404.php';        // This requires $PROMO_PRODUCTS and $OTHER_PRODUCTS
include '../views/footer.php';      // This has no variable requirements
