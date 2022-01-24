<?php 

  namespace App\Controller\Admin;

  use \App\Utils\View;
  use \App\Model\Entity\User;
  use \App\Session\Admin\Login as SessionAdminLogin;  

  class Login extends Page{

    /**
     * Método responsável por retornar a renderização da página de Login
     * @return Request $request
     * @return string $errorMessage
     * @return string
     */
    public static function getLogin($request, $errorMessage = null){
      // STATUS DE LOGIN
      $status = !is_null($errorMessage) ? View::render('admin/login/status',[
        'message' => $errorMessage
      ]) : '';

      // CONTEÚDO DA PÁGINA DE LOGIN
      $content = View::render('admin/login',[
        'status' => $status
      ]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPage('Login',$content);
    }

    /**
     * Método responsável por defirnir o login do usuário
     * @param Request $request
     */
    public static function setLogin($request){
      // POST VARS
      $postVars = $request->getPostVars();
      $email = $postVars['email'] ?? '';
      $password = $postVars['password'] ?? '';

      // BUSCA USUÁRIO PELO E-MAIL
      $user = User::getUserByEmail($email);

      // VERIFICA O EMAIL DO USUÁRIO
      if(!$user instanceof User){
        return self::getLogin($request,'E-mail ou senha inválidos!');
      }

      // VERIFICA A SENHA DO USUÁRIO
      if(!password_verify($password,$user->password)){
        return self::getLogin($request,'E-mail ou senha inválidos!');
      }

      // CRIA A SESSÃO DE Login
      SessionAdminLogin::login($user);

      // REDIRECIONA O USUÁRIO PARA A HOME DO ADMIN
      $request->getRouter()->redirect('/admin');
      
    }

    /**
     * Método responsável por definir o logout do usuário
     * @param Request $request
     */
    public static function setLogout($request){
      // DESTROI A SESSÃO DE Login
      SessionAdminLogin::logout($user);

      // REDIRECIONA O USUÁRIO PARA A TELA DE LOGIN DO ADMIN
      $request->getRouter()->redirect('/admin/login');
    }

  }



?>