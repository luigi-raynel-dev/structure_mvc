<?php 

  require __DIR__.'/includes/app.php';

  use App\Http\Router;

  // Inicia o router
  $router = new Router(URL);

  // Inclui as rotas de páginas
  include __DIR__.'/routes/pages.php';

  // Imprime o Response da rota
  $router->run()
    ->sendResponse();

?>