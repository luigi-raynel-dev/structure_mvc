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

}


?>