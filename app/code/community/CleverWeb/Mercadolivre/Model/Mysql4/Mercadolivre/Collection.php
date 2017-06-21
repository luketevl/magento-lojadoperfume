<?php
/*
 * Desenvolvido por: Mauro Lacerda
 * http://www.cleverweb.com.br
 */
class CleverWeb_Mercadolivre_Model_Mysql4_Mercadolivre_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    public function _construct(){
        parent::_construct();
        $this->_init('mercadolivre/mercadolivre');
    }
}