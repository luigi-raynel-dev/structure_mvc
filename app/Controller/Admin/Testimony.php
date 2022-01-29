<?php 

  namespace App\Controller\Admin;

  use \App\Utils\View;
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
        $items .= View::render('admin/module/testimonies/items',[
          'id' => $testimony->id,
          'name' => $testimony->name,
          'date' => date('d/m/Y H:i:s',strtotime($testimony->date)),
          'message' => $testimony->message
        ]);
      }

      return $items;
    }

    /**
     * Método responsável por retornar a renderização da listagem de depoimentos
     * @return Request $request
     * @return string
     */
    public static function getTestimonies($request){
      // CONTEÚDO DA HOME PAINEL
      $content = View::render('admin/module/testimonies/index',[
        'items' => self::getTestimoniesItems($request,$pagination),
        'pagination' => parent::getPagination($request,$pagination),
        'status' => self::getStatus($request)
      ]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPanel('DEPOIMENTOS - ADMIN',$content,'testimonies');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um depoimento
     * @param Request $request
     * @return string
     */
    public static function getNewTestimony($request){
      // CONTEÚDO DO FORMULÁRIO
      $content = View::render('admin/module/testimonies/form',[
        'title' => 'Cadastrar Depoimento',
        'name' => '',
        'message' => '',
        'status' => ''
      ]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPanel('CADASTRAR DEPOIMENTO - DEVLR',$content,'testimonies');
    }

    /**
     * Método responsável por cadastrar um depoimento no banco de dados
     * @param Request $request
     * @return string
     */
    public static function setNewTestimony($request){
      //POST VARS
      $postVars = $request->getPostVars();
      
      // NOVA INSTÂNCIA DE DEPOIMENTO
      $testimony = new EntityTestimony;
      $testimony->name = $postVars['name'] ?? '';
      $testimony->message = $postVars['message'] ?? '';
      $testimony->register();

      // REDIRECIONA O USUÁRIO
      $request->getRouter()->redirect('/admin/testimonies/'.$testimony->id.'/edit?status=created');
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
          return Alert::getSuccess('Depoimento Criado Com Sucesso!');
          break;
        case 'updated':
          return Alert::getSuccess('Depoimento Atualizado Com Sucesso!');
          break;
        case 'deleted':
          return Alert::getSuccess('Depoimento Excluído Com Sucesso!');
          break;
        
      }
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditTestimony($request,$id){
      // OBTÉM O DEPOIMENTO DO DB
      $testimony = EntityTestimony::getTestimonyById($id);
      
      //VALIDA A INSTANCIA
      if(!$testimony instanceof EntityTestimony){
        $request->getRouter()->redirect('/admin/testimonies');
      }

      // CONTEÚDO DO FORMULÁRIO
      $content = View::render('admin/module/testimonies/form',[
        'title' => 'Editar Depoimento',
        'name' => $testimony->name,
        'message' => $testimony->message,
        'status' => self::getStatus($request)
      ]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPanel('EDITAR DEPOIMENTO - DEVLR',$content,'testimonies');
    }

    /**
     * Método responsável por atualizar um depoimento no banco de dados
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditTestimony($request,$id){
      // OBTÉM O DEPOIMENTO DO DB
      $testimony = EntityTestimony::getTestimonyById($id);
      
      //VALIDA A INSTANCIA
      if(!$testimony instanceof EntityTestimony){
        $request->getRouter()->redirect('/admin/testimonies');
      }

      //POST VARS
      $postVars = $request->getPostVars();
      
      // ATUALIZA INSTÂNCIA DE DEPOIMENTO
      $testimony->name = $postVars['name'] ?? '';
      $testimony->message = $postVars['message'] ?? '';
      $testimony->update();

      // REDIRECIONA O USUÁRIO
      $request->getRouter()->redirect('/admin/testimonies/'.$testimony->id.'/edit?status=updated');
    }

    /**
     * Método responsável por retornar o formulário de exclusão de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteTestimony($request,$id){
      // OBTÉM O DEPOIMENTO DO DB
      $testimony = EntityTestimony::getTestimonyById($id);
      
      //VALIDA A INSTANCIA
      if(!$testimony instanceof EntityTestimony){
        $request->getRouter()->redirect('/admin/testimonies');
      }

      // CONTEÚDO DO FORMULÁRIO
      $content = View::render('admin/module/testimonies/delete',[
        'name' => $testimony->name,
        'message' => $testimony->message,
      ]);

      // RETORNA A PÁGINA COMPLETA
      return parent::getPanel('Excluir Depoimento - DEVLR',$content,'testimonies');
    }

    /**
     * Método responsável por deletar um depoimento no banco de dados
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteTestimony($request,$id){
      // OBTÉM O DEPOIMENTO DO DB
      $testimony = EntityTestimony::getTestimonyById($id);
      
      //VALIDA A INSTANCIA
      if(!$testimony instanceof EntityTestimony){
        $request->getRouter()->redirect('/admin/testimonies');
      }

      // Excluir o depoimento
      $testimony->delete();

      // REDIRECIONA O USUÁRIO
      $request->getRouter()->redirect('/admin/testimonies?status=deleted');
    }


  }



?>