<?php
/*
 * Desenvolvido por: Mauro Lacerda
 * http://www.cleverweb.com.br
 */
class CleverWeb_Mercadolivre_Block_Mercadolivre extends Mage_Core_Block_Template{
	public function _prepareLayout(){
		return parent::_prepareLayout();
	}
    
     public function getMercadolivre(){ 
        if (!$this->hasData('mercadolivre')){
            $this->setData('mercadolivre', Mage::registry('mercadolivre'));
        }
        return $this->getData('mercadolivre');
        
    }
}