<?php 
class CleverWeb_PagSeguroBoleto_Block_Form_Pay extends Mage_Payment_Block_Form{
	protected function _construct(){
		parent::_construct();
		
		$this->setTemplate('cleverweb/pagseguroboleto/form/pay.phtml');
	}
}