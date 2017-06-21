<?php

class CleverWeb_Mercadolivre_PerguntasController extends Mage_Adminhtml_Controller_Action
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