<?php 

  namespace App\Controller\Api;

  class Api{

    /**
     * Método responsável por retornar os detalhes da API
     * @param Request $request
     * @return array
     */
    public static function getDetails($request){

      return [
        'app' => 'API - DEVLR',
        'version' => 'v1.0.0',
        'author' => 'Luigi Raynel',
        'email' => 'devluigiraynel@gmail.com'
      ];
    }

    /**
     * Método responsável por retornar os detalhes da paginação
     * @param Request $resques
     * @param Pagination $pagination
     * @return array
     */
    protected static function getPagination($request,$pagination){
      // Obter os query params
      $queryParams = $request->getQueryParams();

      // Página
      $pages = $pagination->getPages();
      // RETORNO
      return [
        'currentPage' => isset($queryParams['page']) ? (int)$queryParams['page'] : 1,
        'totalPages' => !empty($pages) ? count($pages) : 1
      ];
    }


  }



?>