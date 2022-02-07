<?php 

  use \App\Http\Response;
  use App\Controller\Api;

  // Rota de listagem de usuários
  $router->get('/api/v1/users',[
    'middlewares' => [
      'api',
      'jwt-auth'
    ],
    function($request){
      return new Response(200,Api\User::getUsers($request),'application/json');
    }
  ]);

  // Rota de consulta individual do usuário logado
  $router->get('/api/v1/users/me',[
    'middlewares' => [
      'api',
      'jwt-auth'
    ],
    function($request){
      return new Response(200,Api\User::getCurrentUser($request),'application/json');
    }
  ]);

  // Rota de consulta individual de um usuário
  $router->get('/api/v1/users/{id}',[
    'middlewares' => [
      'api',
      'jwt-auth'
    ],
    function($request,$id){
      return new Response(200,Api\User::getUser($request,$id),'application/json');
    }
  ]);


  // Rota de cadastro de usuário
  $router->post('/api/v1/users',[
    'middlewares' => [
      'api',
      'jwt-auth'
    ],
    function($request){
      return new Response(201,Api\User::setNewUser($request),'application/json');
    }
  ]);

  // Rota de edição de usuário
  $router->put('/api/v1/users/{id}',[
    'middlewares' => [
      'api',
      'jwt-auth'
    ],
    function($request,$id){
      return new Response(200,Api\User::setEditUser($request,$id),'application/json');
    }
  ]);

  // Rota de exclusão de usuário
  $router->delete('/api/v1/users/{id}',[
    'middlewares' => [
      'api',
      'jwt-auth'
    ],
    function($request,$id){
      return new Response(200,Api\User::setDeleteUser($request,$id),'application/json');
    }
  ]);


?>