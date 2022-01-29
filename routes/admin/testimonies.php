<?php 

use App\Http\Response;
use App\Controller\Admin;

// Rota de LISTAGEM DE DEPOIMENTOS
$router->get('/admin/testimonies',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request){
    return new Response(200,Admin\Testimony::getTestimonies($request));
  }
]);

// Rota de CADASTRO DE UM NOVO DEPOIMENTO (GET)
$router->get('/admin/testimonies/new',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request){
    return new Response(200,Admin\Testimony::getNewTestimony($request));
  }
]);

// Rota de CADASTRO DE UM NOVO DEPOIMENTO (POST)
$router->post('/admin/testimonies/new',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request){
    return new Response(200,Admin\Testimony::setNewTestimony($request));
  }
]);

// Rota de EDIÇÃO DO DEPOIMENTO (GET)
$router->get('/admin/testimonies/{id}/edit',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\Testimony::getEditTestimony($request,$id));
  }
]);

// Rota de EDIÇÃO DO DEPOIMENTO (POST)
$router->post('/admin/testimonies/{id}/edit',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\Testimony::setEditTestimony($request,$id));
  }
]);

// Rota de EXCLUSÃO DO DEPOIMENTO (GET)
$router->get('/admin/testimonies/{id}/delete',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\Testimony::getDeleteTestimony($request,$id));
  }
]);

// Rota de EXCLUSÃO DO DEPOIMENTO (POST)
$router->post('/admin/testimonies/{id}/delete',[
  'middlewares' => [
    'require-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\Testimony::setDeleteTestimony($request,$id));
  }
]);


?>