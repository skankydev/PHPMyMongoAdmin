<?php 
namespace Index;
use PHPMyMongoAdmin\PHPMyMongoAdmin;
use PHPMyMongoAdmin\Config\Autoloader;

define('DS',DIRECTORY_SEPARATOR); //séparateurs de dossier.
define('PUBLIC_FOLDER',dirname(__FILE__));//dossier public
define('APP_FOLDER', dirname(PUBLIC_FOLDER));//dossier de l'application 

mb_internal_encoding("UTF-8");	//defini encodage des carataire utf-8

require '../vendor/autoload.php';

new PHPMyMongoAdmin();
