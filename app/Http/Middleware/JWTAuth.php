<?php 

  namespace App\Http\Middleware;

  use App\Model\Entity\User;
  use \Firebase\JWT\JWT;
  use \Firebase\JWT\Key;

  class JWTAuth{

    /**
     * Método responsável por retornar uma instância de um usuário autenticado
     * @param Request $request
     * @return User
     */
    private function getJWTAuthUser($request){
      // HEADERS
      $headers = $request->getHeaders();

      // Token puro em jwt
      $jwt = isset($headers['Authorization']) ? str_replace('Bearer ','',$headers['Authorization']) : '';       

      try{
        // DECODE
        $decode = (array)JWT::decode($jwt,new Key(getenv('JWT_KEY'), 'HS256'));
      }catch(\Exception $e){
        throw new \Exception("Token inválido", 403);
        
      }
      
      $email = $decode['email'] ?? '';
        
      // BUSCA USUÁRIO PELO EMAIL
      $user = User::getUserByEmail($email);
      
      //RETORNA O USUÁRIO
      return $user instanceof User ? $user : false;
    } 


    /**
     * Método responsável por validar o acesso via JWT
     * @param Request $request
     */
    private function auth($request){
      // VERIFICA O USUÁRIO RECEBIDO
      if($user = $this->getJWTAuthUser($request)){
        $request->user = $user;
        return true;
      }

      // EMITE O ERRO DE USUÁRIO E SENHA
      throw new \Exception("Acesso negado", 403);
      
    } 

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next){
      // REALIZA A VALIDAÇÃO DO ACESSO VIA JWT
      $this->auth($request);
      
      return $next($request);
    }

  }

?>