<?php 

  namespace App\Http\Middleware;

  class Queue{

    /**
     * Mapeamento de middlewares
     * @var array
     */
    private static $map = [];

    /**
     * Mapeamento de middlewaresque serão carregados em todas as rotas
     * @var array
     */
    private static $default = [];

    /**
     * Fila de middlwares a serem executados
     * @var array
     */  
    private $middlewares = [];

    /**
     * Função de execução do controlador
     * @var Closure
     */  
    private $controller;

    /**
     * Argumentos da função do controller
     * @var array
     */  
    private $controllerArgs = [];
    
    /**
     * Método responsável por construir a classe de fila de middlewares
     * @var array $middlewares
     * @var CLosure $controller
     * @var array $controllerArgs
     */
    public function __construct($middlewares,$controller,$controllerArgs){
      $this->middlewares = array_merge(self::$default,$middlewares);
      $this->controller = $controller;
      $this->controllerArgs = $controllerArgs;
    }

    /**
     * Método responsável por definir o mapeamento de middlewares
     */
    public static function setMap($map){
      self::$map = $map;
    }
    
    /**
     * Método responsável por definir o mapeamento de middlewares padrões
     */
    public static function setDefault($default){
      self::$default = $default;
    }

    /**
     * Método responsável por executar o próximo nível da fila de middlewares
     * @params Request $request
     * @return Response
     */
    public function next($request){
      // VERIFICA SE A FILA ESTÁ VAZIA
      if(empty($this->middlewares)) return call_user_func_array($this->controller,$this->controllerArgs);

      // Middleware
      $middleware = array_shift($this->middlewares);

      if(!isset(self::$map[$middleware])){
        throw new \Exception("Problema ao processar middlewares da requisição", 500);
      }

      // NEXT
      $queue = $this;
      $next = function($request) use($queue){
        return $queue->next($request);
      };

      // executa um middleware
      return (new self::$map[$middleware])->handle($request,$next);

    }



    
  }

?>
  