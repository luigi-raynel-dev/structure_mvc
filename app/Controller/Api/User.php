<?php 

  namespace App\Controller\Api;

  use \App\Model\Entity\User as EntityUser;
  use \WilliamCosta\DatabaseManager\Pagination;

  class User extends Api{

    /**
     * Método responsável por obter a renderização dos itens de usuários.
     * @param Request $request
     * @param Pagination $pagination
     * @return string
     */ 
    private function getUsersItems($request,&$pagination){
      // Usuários
      $items = [];

      // QUANTIDADE TOTAL DE REGISTROS
      $totalAmount = EntityUser::getUsers(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

      // PÁGINA ATUAL
      $queryParams = $request->getQueryParams();
      $currentPage = $queryParams['page'] ?? 1;

      // INSTÂNCIA DE PAGINAÇÃO
      $pagination = new Pagination($totalAmount,$currentPage,5);

      // RESULTADOS DA PÁGINA
      $results = EntityUser::getUsers(null,'id ASC',$pagination->getLimit());

      while($user = $results->fetchObject(EntityUser::class)){
        $items[] = [
          'id' => (int)$user->id,
          'name' => $user->name,
          'email' => $user->email
        ];
      }

      // RETORNA USUÁRIO(S)
      return $items;
    }

    /**
     * Método responsável por retornar os usuários
     * @param Request $request
     * @return array
     */
    public static function getUsers($request){

      return [
        'users' => self::getUsersItems($request,$pagination),
        'pagination' => parent::getPagination($request,$pagination)
      ];
    }

    /**
     * Método responsável por retornar um usuário
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getUser($request,$id){
      // VALIDA O ID DO USUÁRIO
      if(!is_numeric($id)){
        throw new \Exception("O id: $id não é válido",400);
      }

      // BUSCA USUÁRIO
      $user = EntityUser::getUserById($id);

      // VALIDA SE O USUÁRIO EXISTE
      if(!$user instanceof EntityUser){
        throw new \Exception("O usuário $id não foi encontrado.",404);
      }

      return [
        'id' => (int)$user->id,
        'name' => $user->name,
        'email' => $user->email,
      ];
    }

    /**
     * Método responsável por cadastrar um usuário
     * @param Request $request
     * @return array
     */
    public static function setNewUser($request){
      // POST VARS
      $postVars = $request->getPostVars();

      // VALIDA OS CAMPOS OBRIGATÓRIOS
      if(!isset($postVars['name']) || !isset($postVars['message'])){
        throw new \Exception("Os campos nome e mensagem são obrigatórios",400);
      }

      // NOVO USUÁRIO
      $user = new EntityUser;
      $user->name = $postVars['name'];
      $user->message = $postVars['message'];
      // CADASTRAR USUÁRIO NO DB
      $user->register();

      // RETORNA OS DETALHES DO USUÁRIO
      return [
        'success' => true,
        'id' => (int)$user->id,
        'name' => $user->name,
        'date' => $user->date,
        'message' => $user->message
      ];
    }

    /**
     * Método responsável por atualizar um usuário
     * @param Request $request
     * @param int $int
     * @return array
     */
    public static function setEditUser($request,$id){
      // POST VARS
      $postVars = $request->getPostVars();

      // VALIDA OS CAMPOS OBRIGATÓRIOS
      if(!isset($postVars['name']) || !isset($postVars['message'])){
        throw new \Exception("Os campos nome e mensagem são obrigatórios",400);
      }

      // VALIDA SE O USUÁRIO EXISTE
      $user = EntityUser::getUserById($id);

      // VALIDA A instancia
      if(!$user instanceof User){
        throw new \Exception("Usuário $id não encontrado!",404);
      }
      // ATUALIZA USUÁRIO
      $user->name = $postVars['name'];
      $user->message = $postVars['message'];
      // CADASTRAR USUÁRIO NO DB
      $user->update();

      // RETORNA OS DETALHES DO USUÁRIO ATUALIZADO
      return [
        'success' => true,
        'id' => (int)$user->id,
        'name' => $user->name,
        'date' => $user->date,
        'message' => $user->message
      ];
    }

    /**
     * Método responsável por apagar um usuário
     * @param Request $request
     * @param int $int
     * @return array
     */
    public static function setDeleteUser($request,$id){
       // VALIDA SE O USUÁRIO EXISTE
      $user = EntityUser::getUserById($id);

      // VALIDA A instancia
      if(!$user instanceof User){
        throw new \Exception("Usuário $id não encontrado!",404);
      }
      // Exclui USUÁRIO
      $user->delete();

      // RETORNA O SUCESSO DA EXCLUSÃO
      return [
        'success' => true
      ];
    }




  }



?>