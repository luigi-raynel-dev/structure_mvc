<?php 

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class User{

  /**
   * ID do usuário
   * @var string
   */
  public $id;

  /**
   * Nome do usuário
   * @var string
   */
  public $name;

  /**
   * Email do usuário
   * @var string
   */
  public $email;

  /**
   * Senha do usuário
   * @var string
   */
  public $password;

  /**
   * Método responsável por retornar um usuário com base em seu Email
   * @param string $email
   * @return User
   */
  public static function getUserByEmail($email){

    return (new Database('users'))->select('email = "'.$email.'"')->fetchObject(self::class);

  }

  /**
     * Método responsável por retornar usuários
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = ''){
      return (new Database('users'))->select($where,$order,$limit,$fields);
    }

    /**
     * Método responsável por retornar um usuário com base no seu ID
     * @param integer $id
     * @return Testimony
     */
    public static function getUserById($id){
      return self::getUsers("id = $id")->fetchObject(self::class);
    }

    /**
     * Método responsável por cadastrar a instancia atual no banco de dados
     * @return boolean
     */
    public function register(){
      // INSERE O USUÁRIO NO DB
      $this->id = (new Database('users'))->insert([
        'name' => $this->name,
        'email' => $this->email,
        'password' => $this->password
      ]);
      
      // SUCESSO
      return true;
    }

    /**
     * Método responsável por atualizar a instancia atual no banco de dados
     * @return boolean
     */
    public function update(){
           
      // ATUALIZA O USUÁRIO NO DB
      return (new Database('users'))->update("id = ".$this->id,[
        'name' => $this->name,
        'email' => $this->email
      ]);
      
      // SUCESSO
      return true;
    }

    /**
     * Método responsável por excluir a instancia atual no banco de dados
     * @return boolean
     */
    public function delete(){
           
      // APAGA O USUÁRIO NO DB
      return (new Database('users'))->delete("id = ".$this->id);
      
      // SUCESSO
      return true;
    }


}


?>