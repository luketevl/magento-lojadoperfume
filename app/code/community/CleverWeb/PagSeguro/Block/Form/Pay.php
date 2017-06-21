<?php 
class CleverWeb_PagSeguro_Block_Form_Pay extends Mage_Payment_Block_Form{
	protected function _construct(){
		parent::_construct();
		
		$this->setTemplate('cleverweb/pagseguro/form/pay.phtml');
	}
}