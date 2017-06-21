<?php
/*
 * Desenvolvido por: Mauro Lacerda
 * http://www.cleverweb.com.br
 */
class CleverWeb_Mercadolivre_Model_Mysql4_Mercadolivre extends Mage_Core_Model_Mysql4_Abstract{
    public function _construct(){    
        // Observe que o mercadolivre_id se refere ao campo de chave na tabela do banco de dados.
        $this->_init('mercadolivre/mercadolivre', 'entity_id');
    }
}