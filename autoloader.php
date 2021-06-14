<?php
spl_autoload_register('myAutoloader');

function myAutoloader($className)
{
    $path = "models/";
    $extension = ".php";
    $fullPath = $path . strtolower($className) . $extension;
    include_once $fullPath;
}


?>