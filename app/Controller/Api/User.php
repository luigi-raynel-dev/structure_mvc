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
     * Método responsável por retornar o usuário logado
     * @param Request $request
     * @return array
     */
    public static function getCurrentUser($request){
      // BUSCA USUÁRIO ATUAL
      $user = $request->user;

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
      if(!isset($postVars['name']) && !isset($postVars['email']) && !isset($postVars['password'])){
        throw new \Exception("Os campos nome, email e senha são obrigatórios",400);
      }

      $name = $postVars['name'] ?? '';
      $email = $postVars['email'] ?? '';
      $password = $postVars['password'] ?? '';

      // VALIDA O EMAIL DO USUÁRIO
      $user = EntityUser::getUserByEmail($email);
      if($user instanceof EntityUser){
        // SE EXISTE O USUÁRIO RETORNA UMA EXCEPTION
        throw new \Exception('Este email já está cadastrado!',400);
      }

      // NOVA INSTÂNCIA DE USUÁRIO
      $user = new EntityUser;
      $user->name = $name;
      $user->email = $email;
      $user->password = password_hash($password, PASSWORD_DEFAULT);
      $user->register();

      // RETORNA OS DETALHES DO USUÁRIO
      return [
        'success' => true,
        'id' => (int)$user->id,
        'name' => $user->name,
        'email' => $user->email
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
      if(!isset($postVars['name']) && !isset($postVars['email']) && !isset($postVars['password'])){
        throw new \Exception("Os campos nome, email e senha são obrigatórios",400);
      }

      $name = $postVars['name'] ?? '';
      $email = $postVars['email'] ?? '';
      $password = $postVars['password'] ?? '';

      // VALIDA O EMAIL DO USUÁRIO
      $user = EntityUser::getUserById($id);
      if(!$user instanceof EntityUser){
        // SE NÃO EXISTE O USUÁRIO RETORNA UMA EXCEPTION
        throw new \Exception("O usuário $id não foi encontrado.",404);
      }

      // VALIDA O ID DO USUÁRIO É DIFERENTE QUE O ID DA ROTA DA API
      $userEmail = EntityUser::getUserByEmail($email);
      if($userEmail instanceof EntityUser && $userEmail->id != $user->$id){
        // SE NÃO EXISTE O USUÁRIO RETORNA UMA EXCEPTION
        throw new \Exception("O email $email está em uso!",404);
      }

      $user->name = $name;
      $user->email = $email;
      $user->password = password_hash($password, PASSWORD_DEFAULT);
      $user->update();

      // RETORNA OS DETALHES DO USUÁRIO ATUALIZADO
      return [
        'success' => true,
        'id' => (int)$user->id,
        'name' => $user->name,
        'email' => $user->email
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
      if(!$user instanceof EntityUser){
        throw new \Exception("Usuário $id não encontrado!",404);
      }

      if($user->id === $request->user->id){
        throw new \Exception("Não é possível excluir seu próprio usuário",404);
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