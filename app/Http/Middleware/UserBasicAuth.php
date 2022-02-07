<?php 

  namespace App\Http\Middleware;

  use App\Model\Entity\User;

  class UserBasicAuth{

    /**
     * Método responsável por retornar uma instância de um usuário autenticado
     * @return User
     */
    private function getBasicAuthUser(){
      // VERIFICA A EXISTÊNCIA DO USUÁRIO RECEBIDO
  
      if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])){
        return false;
      }
        
      // BUSCA USUÁRIO PELO EMAIL
      $user = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);
      
      // VERIFICA A INSTÂNCIA
      if(!$user instanceof User){
        return false;
      }

      // VALIDA A SENHA E RETORNA USUÁRIO
      return password_verify($_SERVER['PHP_AUTH_PW'],$user->password) ? 
      $user : false;
      
    } 


    /**
     * Método responsável por validar o acesso via basic auth
     * @param Request $request
     */
    private function basicAuth($request){
      // VERIFICA O USUÁRIO RECEBIDO
      if($user = $this->getBasicAuthUser()){
        $request->user = $user;
        return true;
      }

      // EMITE O ERRO DE USUÁRIO E SENHA
      throw new \Exception("Usuário 3 ou Senha inválidos", 403);
      
    } 

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next){
      // REALIZA A VALIDAÇÃO DO ACESSO VIA BASIC AUTH
      $this->basicAuth($request);
      
      return $next($request);
    }

  }

?>