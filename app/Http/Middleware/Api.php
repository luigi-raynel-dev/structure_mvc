<?php 

  namespace App\Http\Middleware;

  class Api{

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next){
      // Seta o content-type para json
      $request->getRouter()->setContentType('application/json');

      if(getenv('MAINTENANCE') == 'true'){
        throw new \Exception("Página em manutenção. Tente novamente mais tarde!",200);
      }
      return $next($request);
    }

  }

?>