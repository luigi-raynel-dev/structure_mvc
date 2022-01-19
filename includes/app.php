<?php 

require './vendor/autoload.php';


use App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;

//LOAD ENVIRONMENT VARS FROM FILE ON ROOT
Environment::load(__DIR__.'/../');

// Define as configurações do db
Database::config(
  getenv('DB_HOST'),
  getenv('DB_NAME'),
  getenv('DB_USER'),
  getenv('DB_PASS'),
  getenv('DB_PORT')
);

define('URL',getenv('URL'));

// Define o valor padrão das variáveis
View::init([
  'URL' => URL
]);


?>