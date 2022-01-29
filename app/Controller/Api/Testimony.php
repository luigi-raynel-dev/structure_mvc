<?php 

  namespace App\Controller\Api;

  use \App\Model\Entity\EntityTestimony;
  use \WilliamCosta\DatabaseManager\Pagination;

  class Testimony extends Api{

    /**
     * Método responsável por obter a renderização dos itens de depoimentos.
     * @param Request $request
     * @param Pagination $pagination
     * @return string
     */ 
    private function getTestimoniesItems($request,&$pagination){
      // Depoimentos
      $items = [];

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
        $items[] = [
          'id' => (int)$testimony->id,
          'name' => $testimony->name,
          'date' => $testimony->date,
          'message' => $testimony->message
        ];
      }

      return $items;
    }

    /**
     * Método responsável por retornar os depoimentos
     * @param Request $request
     * @return array
     */
    public static function getTestimonies($request){

      return [
        'testimonies' => self::getTestimoniesItems($request,$pagination),
        'pagination' => parent::getPagination($request,$pagination)
      ];
    }

    /**
     * Método responsável por retornar um depoimento
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getTestimony($request,$id){
      // VALIDA O ID DO DEPOIMENTO
      if(!is_numeric($id)){
        throw new \Exception("O id: $id não é válido",400);
      }

      // BUSCA DEPOIMENTO
      $testimony = EntityTestimony::getTestimonyById($id);
      
      // VALIDA SE O DEPOIMENTO EXISTE
      if(!$testimony instanceof EntityTestimony){
        throw new \Exception("O depoimento $id não foi encontrado.",404);
      }

      return [
        'id' => (int)$testimony->id,
        'name' => $testimony->name,
        'date' => $testimony->date,
        'message' => $testimony->message
      ];
    }

    /**
     * Método responsável por cadastrar um depoimento
     * @param Request $request
     * @return array
     */
    public static function setNewTestimony($request){
      // POST VARS
      $postVars = $request->getPostVars();

      // VALIDA OS CAMPOS OBRIGATÓRIOS
      if(!isset($postVars['name']) || !isset($postVars['message'])){
        throw new \Exception("Os campos nome e mensagem são obrigatórios",400);
      }

      // NOVO DEPOIMENTO
      $testimony = new EntityTestimony;
      $testimony->name = $postVars['name'];
      $testimony->message = $postVars['message'];
      // CADASTRAR DEPOIMENTO NO DB
      $testimony->register();

      // RETORNA OS DETALHES DO DEPOIMENTO
      return [
        'success' => true,
        'id' => (int)$testimony->id,
        'name' => $testimony->name,
        'date' => $testimony->date,
        'message' => $testimony->message
      ];
    }




  }



?>