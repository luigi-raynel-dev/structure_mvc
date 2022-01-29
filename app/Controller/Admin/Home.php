<?php 

  namespace App\Controller\Admin;

  use \App\Utils\View;

  class Home extends Page{

    /**
     * Método responsável por retornar a renderização a home do painel
     * @return Request $request
     * @return string
     */
    public static function getHome($request){
      // CONTEÚDO DA HOME PAINEL
      $content = View::render('admin/module/home/index',[]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPanel('HOME - ADMIN',$content,'home');
    }

  }



?>