<?php 

  namespace App\Controller\Pages;
  
  use App\Utils\View;
  use \App\Model\Entity\EntityTestimony;
  use WilliamCosta\DatabaseManager\Pagination;

  class Testimony extends Page{

    /**
     * Método responsável por obter a renderização dos itens de depoimentos.
     * @param Request $request
     * @param Pagination $pagination
     * @return string
     */ 
    private function getTestimoniesItems($request,&$pagination){
      // Depoimentos
      $items = '';

      // QUANTIDADE TOTAL DE REGISTROS
      $totalAmount = EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

      // PÁGINA ATUAL
      $queryParams = $request->getQueryParams();
      $currentPage = $queryParams['page'] ?? 1;

      // INSTÂNCIA DE PAGINAÇÃO
      $pagination = new Pagination($totalAmount,$currentPage,5);

      // RESULTADOS DA PÁGINA
      $results = EntityTestimony::getTestimonies(null,'id DESC',$pagination->getLimit());

      while($testimony = $results->fetchObject(EntityTestimony::class)){
        $items .= View::render('pages/testimony/item',[
          'name' => $testimony->name,
          'date' => date('d/m/Y H:i:s',strtotime($testimony->date)),
          'message' => $testimony->message
        ]);
      }

      return $items;
    }
     
    /**
     * Método responsável por retornar o conteúdo da (view) de depoimentos.
     * @param Request $request
     * @return string
     */ 

    public static function getTestimonies($request){

      $content = View::render('pages/testimonies',[
        'items' => self::getTestimoniesItems($request,$pagination),
        'pagination' => parent::getPagination($request,$pagination)
      ]);

      // Retorna a view da Page
      return parent::getPage('Depoimentos > Dev LR', $content);
    }

    /**
     * Método responsável por cadastrar um depoimento
     * @param Request $request
     * @return string
     */
    public static function insertTestimonies($request){
      // DADOS DO POST
      $postVars = $request->getPostVars();
      
      // NOVA INSTÂNCIA DE DEPOIMENTO
      $testimony = new EntityTestimony;
      $testimony->name = $postVars['name'];
      $testimony->message = $postVars['message'];
      $testimony->register();
      
      // RETORNA A PÁGINA DE LISTAGEM DE DEPOIMENTOS
      return self::getTestimonies($request);      
    }

  }

?>