<?php 

  namespace App\Session\Admin;

  class Login{

    /**
     * Método responsável por iniciar a sessão
     */
    private static function init(){
      // VERIFICA SE A SESSÃO NÃO ESTÁ ATIVA
      if(session_status() != PHP_SESSION_ACTIVE){
        session_start();
      }
    }

    /**
     * Método responsável por criar as seções de login do Admin
     * @param User $user
     * @return boolean
     */
    public static function login($user){
      // INICIA A SESSÃO
      self::init();

      // DEFINE A SESSÃO DO USUÁRIO
      $_SESSION['admin']['user'] = [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email
      ];

      // SUCESSO
      return true;
    }

    /**
     * Método responsável por verificar se o usuário está logado
     * @return boolean
     */
    public static function isLogged(){
      // INICIA A SESSÃO
      self::init();

      // RETORNA A VERIFICAÇÃO
      return isset($_SESSION['admin']['user']['id']);
    }

    /**
     * Método responsável por destroir a sessão de login do usuário
     * @return boolean
     */
    public static function logout(){
      // INICIA A SESSÃO
      self::init();

      // DESLOGA O USUÁRIO
      unset($_SESSION['admin']['user']);

      // SUCESSO
      return true;
    }
    

  }


?>