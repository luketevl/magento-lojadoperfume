<?php

class CleverWeb_Mercadolivre_VendasController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
    			
		$this->loadLayout()
                ->_addContent(
                $this->getLayout()
                ->createBlock('core/template')
                ->setTemplate('cleverweb_ml/anuncios.phtml'))
                ->renderLayout();
    }	
}