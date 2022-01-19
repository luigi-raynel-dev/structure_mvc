<?php 

  namespace App\Model\Entity;

  class Organization{

    /**
     * ID da organização
     * @var integer
     */
    public $id = 1;

    /**
     * Nome da organização
     * @var string
     */
    public $name = 'Dev LR';

    /**
     * Site da organização
     * @var string
     */
    public $site = 'https://github.com/luigi-raynel-dev';

    /**
     * Descrição da organização
     * @var string
     */
    public $description = 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reiciendis quasi debitis, assumenda quis nostrum porro molestias. Et sed impedit, obcaecati omnis iste, molestiae, facilis fugiat porro quod tempore error reiciendis.';

  }

?>