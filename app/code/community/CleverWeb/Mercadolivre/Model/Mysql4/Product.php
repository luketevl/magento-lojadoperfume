<?php

class CleverWeb_Mercadolivre_Model_Mysql4_Product extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('mercadolivre/product','product_id');
    }
}