<?php 

  namespace App\Controller\Pages;

  use \App\Utils\View;
  use \App\Model\Entity\Organization;

  class Home extends Page{
     
    /**
     * Método responsável por retornar o conteúdo da (view) da home.
     * @return string
     */ 

    public static function getHome(){
      // ORGANIZAÇÃO
      $organization = new Organization;

      $content = View::render('pages/home',[
        'name' => $organization->name,
      ]);

      // Retorna a view da Page
      return parent::getPage('Home > Dev LR', $content);
    }

  }

?>