<?php
ob_start();
session_start();
//database credentials
include('db.php');


//set timezone
date_default_timezone_set('Asia/Kolkata');

//load classes as needed
function myAutoload($class)
{

   $class = strtolower($class);

   //if call from within assets adjust the path
   $classpath = 'classes/class.' . $class . '.php';
   if (file_exists($classpath)) {
      require_once $classpath;
   }

   //if call from within admin adjust the path
   $classpath = '../classes/class.' . $class . '.php';
   if (file_exists($classpath)) {
      require_once $classpath;
   }

   //if call from within admin adjust the path
   $classpath = '../../classes/class.' . $class . '.php';
   if (file_exists($classpath)) {
      require_once $classpath;
   }
}

spl_autoload_register('myAutoload');

$user = new User($db);

include('functions.php');
