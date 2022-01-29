<?php 

  use App\Http\Response;
  use App\Controller\Admin;

  // Rota Admin/Login (View Login)
  $router->get('/admin/login',[
    'middlewares' => [
      'require-admin-logout'
    ],
    function($request){
      return new Response(200,Admin\Login::getLogin($request));
    }
  ]);

  // Rota Admin/Login (Verify login)
  $router->post('/admin/login',[
    'middlewares' => [
      'require-admin-logout'
    ],
    function($request){
      return new Response(200,Admin\Login::setLogin($request));
    }
  ]);

  // Rota Admin/Logout
  $router->get('/admin/logout',[
    'middlewares' => [
      'require-admin-login'
    ],
    function($request){
      return new Response(200,Admin\Login::setLogout($request));
    }
  ]);


?>