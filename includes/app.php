<?php 

require './vendor/autoload.php';


use App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;
use App\Http\Middleware\Queue as MiddlewareQueue;

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

// Define o mapeamento de middlewaresS
MiddlewareQueue::setMap([
  'maintenance' => App\Http\Middleware\Maintenance::class,
  'require-admin-logout' => App\Http\Middleware\RequireAdminLogout::class,
  'require-admin-login' => App\Http\Middleware\RequireAdminLogin::class
]);

// Define o mapeamento de middlewares
MiddlewareQueue::setDefault([
  'maintenance'
]);


?>