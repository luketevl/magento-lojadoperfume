<?php
// This block allows data along with the payment method to be presented on the admin screen and user order screen.
class CleverWeb_PagSeguroBoleto_Block_Info_Pay extends Mage_Payment_Block_Info{
    protected function _prepareSpecificInformation($transport = null)
       {
           if (null !== $this->_paymentSpecificInformation) {
               return $this->_paymentSpecificInformation;
           }
           $info = $this->getInfo();
           $transport = new Varien_Object();
           //$transport = parent::_prepareSpecificInformation($transport);
          if($additional = $info->getAdditionalInformation()){
	           $transport->addData(array(
	           	   Mage::helper('payment')->__('boleto') => $additional['urlboleto']
	           ));
		   }
		   $transport = parent::_prepareSpecificInformation($transport);
           return $transport;
       }
}

/*

			   Mage::helper('payment')->__('Data de Nascimento') => $info->getDtanascimento(),
			   Mage::helper('payment')->__('CPF do titular') => $info->getStrcpftit(),
			   Mage::helper('payment')->__('Telefone') => $info->getStrdddtelfone(),
			   Mage::helper('payment')->__('Número do cartão') => $info->getCreditcardnumber(),
			   Mage::helper('payment')->__('Código de segurança') => $info->getCreditcardcvv(),			   
			   Mage::helper('payment')->__('Mês Validade') => $info->getCreditcardduedatemonth(),
			   Mage::helper('payment')->__('Ano Validade') => $info->Creditcardduedateyear(),
			   Mage::helper('payment')->__('Parcelas') => $info->getStrparcelas()
*/