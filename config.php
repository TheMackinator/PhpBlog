<?php
ob_start();
session_start();

//Binero Databas
   define('DBHOST', 'blogg-220512.mysql.binero.se');
   define('DBUSER', '220512_ve61572');
   define('DBPASS', 'mareng1mareng');
   define('DBNAME', '220512-blogg');

//Lokal Databas

// define('DBHOST','localhost');
// define('DBUSER','root');
// define('DBPASS','');
// define('DBNAME','blogg');

$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//set timezone
date_default_timezone_set('Europe/Stockholm');

// //load classes as needed
//  function __autoload($class) {
   
//     $class = strtolower($class);

//  	//if call from within assets adjust the path
//     $classpath = 'classes/class.'.$class . '.php';
//     if ( file_exists($classpath)) {
//       require_once $classpath;
// 	} 	
	
// 	//if call from within admin adjust the path
//     $classpath = '../classes/class.'.$class . '.php';
//     if ( file_exists($classpath)) {
//       require_once $classpath;
//  	}
	
//  	//if call from within admin adjust the path
//     $classpath = '../../classes/class.'.$class . '.php';
//     if ( file_exists($classpath)) {
//        require_once $classpath;
//  	} 		
	 
//  }

//  $user = new User($db); 
?>