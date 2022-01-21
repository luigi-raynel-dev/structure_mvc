<?php 

  namespace App\Http\Middleware;

  class Queue{

    /*
     * Fila de middlwares a serem executados
     * @var array
     */  
    private $middlewares = [];

    /*
     * Função de execução do controlador
     * @var Closure
     */  
    private $controller;

    /*
     * Argumentos da função do controller
     * @var array
     */  
    private $controllerArgs = [];
    
    /*
     * Método responsável por construir a classe de fila de middlewares
     * @var array $middlewares
     * @var CLosure $controller
     * @var array $controllerArgs
     */
    public function __construct($middlewares,$controller,$controllerArgs){
      $this->middlewares = $middlewares;
      $this->controller = $controller;
      $this->controllerArgs =$controllerArgs;
    }

    /*
     * Método responsável por executar o próximo nível da fila de middlewares
     * @params Request $request
     * @return Response
     */
    public function next($request){
      echo '<pre>';
      print_r($this);
      echo '</pre>';
    }



    
  }

?>
  