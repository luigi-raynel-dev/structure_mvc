<?php 

  use \App\Http\Response;
  use App\Controller\Api;

  // Rota de listagem de depoimentos
  $router->get('/api/v1/testimonies',[
    'middlewares' => [
      'api'
    ],
    function($request){
      return new Response(200,Api\Testimony::getTestimonies($request),'application/json');
    }
  ]);

  // Rota de consulta individual de um depoimento
  $router->get('/api/v1/testimonies/{id}',[
    'middlewares' => [
      'api'
    ],
    function($request,$id){
      return new Response(200,Api\Testimony::getTestimony($request,$id),'application/json');
    }
  ]);

  // Rota de cadastro de depoimento
  $router->post('/api/v1/testimonies',[
    'middlewares' => [
      'api',
      'user-basic-auth'
    ],
    function($request){
      return new Response(201,Api\Testimony::setNewTestimony($request),'application/json');
    }
  ]);

  // Rota de cadastro de depoimento
  $router->put('/api/v1/testimonies/{id}',[
    'middlewares' => [
      'api',
      'user-basic-auth'
    ],
    function($request){
      return new Response(201,Api\Testimony::setEditTestimony($request),'application/json');
    }
  ]);


?>