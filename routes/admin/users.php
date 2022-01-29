<?php 

use App\Http\Response;
use App\Controller\Admin;

// Rota de LISTAGEM DE USUÁRIOS
$router->get('/admin/users',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request){
    return new Response(200,Admin\User::getUsers($request));
  }
]);

// Rota de CADASTRO DE UM NOVO USUÁRIO (GET)
$router->get('/admin/users/new',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request){
    return new Response(200,Admin\User::getNewUser($request));
  }
]);

// Rota de CADASTRO DE UM NOVO USUÁRIO (POST)
$router->post('/admin/users/new',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request){
    return new Response(200,Admin\User::setNewUser($request));
  }
]);

// Rota de EDIÇÃO DO USUÁRIO (GET)
$router->get('/admin/users/{id}/edit',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\User::getEditUser($request,$id));
  }
]);

// Rota de EDIÇÃO DO USUÁRIO (POST)
$router->post('/admin/users/{id}/edit',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\User::setEditUser($request,$id));
  }
]);

// Rota de EXCLUSÃO DO USUÁRIO (GET)
$router->get('/admin/users/{id}/delete',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\User::getDeleteUser($request,$id));
  }
]);

// Rota de EXCLUSÃO DO USUÁRIO (POST)
$router->post('/admin/users/{id}/delete',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\User::setDeleteUser($request,$id));
  }
]);


?>