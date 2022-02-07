<?php 

  namespace App\Controller\Api;

  use App\Model\Entity\User;
  use \Firebase\JWT\JWT;

  class Auth{

    /**
     * Método responsável por gerar o JWT da API
     * @param Request $request
     * @return array
     */
    public static function generateToken($request){
      // POST VARS
      $postVars = $request->getPostVars();

      // VALIDA OS CAMPOS OBRIGATÓRIOS
      if(!isset($postVars['email']) or !isset($postVars['password'])){
        throw new \Exception("E-mail e senha são obrigatórios", 400);
      }

      // BUSCA USUÁRIO PELO E-MAIL
      $user = User::getUserByEmail($postVars['email']);

      // VALIDA A INSTANCIA
      if(!$user instanceof User){
        throw new \Exception("Usuário 1 ou senha inválidos", 400);
      }

      // VALIDA A SENHA DO USUÁRIO
      if(!password_verify($postVars['password'],$user->password)){
        throw new \Exception("Usuário 2 ou senha inválidos", 400);
      }

      // PAYLOAD
      $payload = [
        'email' => $user->email
      ];

      // Retorna o token gerado
      return [
        'token' => JWT::encode($payload,getenv('JWT_KEY'),'HS256')
      ];
    }

  }



?>