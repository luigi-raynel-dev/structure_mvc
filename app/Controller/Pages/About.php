<?php 

  namespace App\Controller\Pages;

  use \App\Utils\View;
  use \App\Model\Entity\Organization;

  class About extends Page{
     
    /**
     * Método responsável por retornar o conteúdo da (view) de sobre.
     * @return string
     */ 

    public static function getAbout(){
      // ORGANIZAÇÃO
      $organization = new Organization;

      $content = View::render('pages/about',[
        'name' => $organization->name,
        'description' => $organization->description,
        'site' => $organization->site
      ]);

      // Retorna a view da Page
      return parent::getPage('Sobre > Dev LR', $content);
    }

  }

?>