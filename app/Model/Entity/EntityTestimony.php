<?php 

  namespace App\Model\Entity;

  use WilliamCosta\DatabaseManager\Database;

  class EntityTestimony{

    /**
     * ID do depoimento
     * @var integer  
     */
    public $id;

    /**
     * Nome do usuário que fez o depoimento
     * @var string
     */
    public $name;

    /**
     * Mensagem do depoimento
     * @var string
     */
    public $message;

    /**
     * Data da publicação do depoimento
     * @var string  
     */
    public $date;

    /**
     * Método responsável por cadastrar a instancia atual no banco de dados
     * @return boolean
     */
    public function register(){
      // DEFINE A DATA
      $this->date = date('Y-m-d H:i:s');
      
      // INSERE O DEPOIMENTO NO DB
      $this->id = (new Database('testimonies'))->insert([
        'name' => $this->name,
        'message' => $this->message,
        'date' => $this->date
      ]);
      
      // SUCESSO
      return true;
    }

    /**
     * Método responsável por retornar depoimentos
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = ''){
      return (new Database('testimonies'))->select($where,$order,$limit,$fields);
    }





  }

?>