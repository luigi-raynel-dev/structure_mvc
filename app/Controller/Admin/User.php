<?php 

  namespace App\Controller\Admin;

  use \App\Utils\View;
  use \App\Model\Entity\User as EntityUser;
  use WilliamCosta\DatabaseManager\Pagination;

  class User extends Page{

    /**
     * Método responsável por obter a renderização de cada usuário.
     * @param Request $request
     * @param Pagination $pagination
     * @return string
     */ 
    private function getUserItems($request,&$pagination){
      // usuários
      $items = '';

      // QUANTIDADE TOTAL DE REGISTROS
      $totalAmount = EntityUser::getUsers(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

      // PÁGINA ATUAL
      $queryParams = $request->getQueryParams();
      $currentPage = $queryParams['page'] ?? 1;

      // INSTÂNCIA DE PAGINAÇÃO
      $pagination = new Pagination($totalAmount,$currentPage,5);

      // RESULTADOS DA PÁGINA
      $results = EntityUser::getUsers(null,'id DESC',$pagination->getLimit());

      // RENDERIZA
      while($user = $results->fetchObject(EntityUser::class)){
        $items .= View::render('admin/module/users/items',[
          'id' => $user->id,
          'name' => $user->name,
          'email' => $user->email
        ]);
      }

      return $items;
    }

    /**
     * Método responsável por retornar a renderização da listagem de usuários
     * @return Request $request
     * @return string
     */
    public static function getUsers($request){
      // CONTEÚDO DA HOME PAINEL
      $content = View::render('admin/module/users/index',[
        'items' => self::getUserItems($request,$pagination),
        'pagination' => parent::getPagination($request,$pagination),
        'status' => self::getStatus($request)
      ]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPanel('USUÁRIOS - ADMIN',$content,'users');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um usuário
     * @param Request $request
     * @return string
     */
    public static function getNewUser($request){
      // CONTEÚDO DO FORMULÁRIO
      $content = View::render('admin/module/users/form',[
        'title' => 'Cadastrar Usuário',
        'name' => '',
        'email' => '',
        'status' => self::getStatus($request)
      ]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPanel('CADASTRAR USUÁRIO - DEVLR',$content,'users');
    }

    /**
     * Método responsável por cadastrar um usuário no banco de dados
     * @param Request $request
     * @return string
     */
    public static function setNewUser($request){
      //POST VARS
      $postVars = $request->getPostVars();
      $name = $postVars['name'] ?? '';
      $email = $postVars['email'] ?? '';
      $password = $postVars['password'] ?? '';

      // VALIDA O EMAIL DO USUÁRIO
      $user = EntityUser::getUserByEmail($email);
      if($user instanceof EntityUser){
        // REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/new?status=duplicated');
      }

      // NOVA INSTÂNCIA DE USUÁRIO
      $user = new EntityUser;
      $user->name = $name;
      $user->email = $email;
      $user->password = password_hash($password, PASSWORD_DEFAULT);
      $user->register();

      // REDIRECIONA O USUÁRIO
      $request->getRouter()->redirect('/admin/users/'.$user->id.'/edit?status=created');
    }

    /**
     * Método responsável por retornar a mensagem de status
     * @param Request $request
     * @return string
     */
    private static function getStatus($request){
      // QUERY PARAMS
      $queryParams = $request->getQueryParams();
      
      // STATUS
      if(!isset($queryParams['status'])) return '';

      // MENSAGENS DE STATUS
      switch($queryParams['status']){
        case 'created':
          return Alert::getSuccess('Usuário Criado Com Sucesso!');
          break;
        case 'updated':
          return Alert::getSuccess('Usuário Atualizado Com Sucesso!');
          break;
        case 'deleted':
          return Alert::getSuccess('Usuário Excluído Com Sucesso!');
          break;
        case 'duplicated':
          return Alert::getError('Este email já está cadastrado!');
          break;
        
      }
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditUser($request,$id){
      // OBTÉM O DEPOIMENTO DO DB
      $user = EntityUser::getUserById($id);
      
      //VALIDA A INSTANCIA
      if(!$user instanceof EntityUser){
        $request->getRouter()->redirect('/admin/users');
      }

      // CONTEÚDO DO FORMULÁRIO
      $content = View::render('admin/module/users/form',[
        'title' => 'Editar Usuário',
        'name' => $user->name,
        'email' => $user->email,
        'status' => self::getStatus($request)
      ]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPanel('EDITAR USUÁRIO - DEVLR',$content,'users');
    }

    /**
     * Método responsável por atualizar um usuário no banco de dados
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditUser($request,$id){
      // OBTÉM O DEPOIMENTO DO DB
      $user = EntityUser::getUserById($id);
      
      //VALIDA A INSTANCIA
      if(!$user instanceof EntityUser){
        $request->getRouter()->redirect('/admin/testimonies');
      }

      //POST VARS
      $postVars = $request->getPostVars();
      $name = $postVars['name'] ?? '';
      $email = $postVars['email'] ?? '';
      $password = $postVars['password'] ?? '';

      // VALIDA O EMAIL DO USUÁRIO
      $userEmail = EntityUser::getUserByEmail($email);
      if($userEmail instanceof EntityUser && $userEmail->id !== $id){
        // REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/'.$user->id.'/edit?status=duplicated');
      }
      
      // ATUALIZA INSTÂNCIA DE DEPOIMENTO
      $user->name = $name;
      $user->email = $email;
      $user->password = password_hash($password, PASSWORD_DEFAULT);
      $user->update();

      // REDIRECIONA O USUÁRIO
      $request->getRouter()->redirect('/admin/users/'.$user->id.'/edit?status=updated');
    }

    /**
     * Método responsável por retornar o formulário de exclusão de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteUser($request,$id){
      // OBTÉM O USUÁRIO DO DB
      $user = EntityUser::getUserById($id);
      
      //VALIDA A INSTANCIA
      if(!$user instanceof EntityUser){
        $request->getRouter()->redirect('/admin/users');
      }

      // CONTEÚDO DO FORMULÁRIO
      $content = View::render('admin/module/users/delete',[
        'name' => $user->name,
        'email' => $user->email,
      ]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPanel('Excluir Usuário - DEVLR',$content,'users');
    }

    /**
     * Método responsável por deletar um usuário no banco de dados
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteUser($request,$id){
      // OBTÉM O USUÁRIO DO DB
      $user = EntityUser::getUserById($id);
      
      //VALIDA A INSTANCIA
      if(!$user instanceof EntityUser){
        $request->getRouter()->redirect('/admin/users');
      }

      // Excluir o depoimento
      $user->delete();

      // REDIRECIONA O USUÁRIO
      $request->getRouter()->redirect('/admin/users?status=deleted');
    }


  }



?>