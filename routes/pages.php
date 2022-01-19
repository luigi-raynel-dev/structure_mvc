<?php 

  use App\Http\Response;
  use App\Controller\Pages;

  // Rota Home
  $router->get('/',[
    function(){
      return new Response(200,Pages\Home::getHome());
    }
  ]);

  // Rota Sobre
  $router->get('/sobre',[
    function(){
      return new Response(200,Pages\About::getAbout());
    }
  ]);

  // Rota Depoimentos
  $router->get('/depoimentos',[
    function($request){
      return new Response(200,Pages\Testimony::getTestimonies($request));
    }
  ]);

  // Rota Depoimentos (INSERT)
  $router->post('/depoimentos',[
    function($request){
      return new Response(200,Pages\Testimony::insertTestimonies($request));
    }
  ]);
  

?>